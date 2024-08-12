<?php
namespace WCDeliveryDate\Controllers;

use WCDeliveryDate\Helpers\Utils;
use WCDeliveryDate\Models\DeliveryDateModel;
use WCDeliveryDate\Controllers\DeliveryDateCalculatorController;

class CartController {

    public function __construct() {
        add_filter('woocommerce_get_item_data', array($this, 'display_delivery_date_in_cart'), 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_delivery_date_to_order_items'), 10, 4);  
        add_action('woocommerce_after_cart_item_name', array($this, 'display_delivery_date_dropdown'), 10, 2);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_cart_script'), 10, 2);  
        add_action('wp_ajax_update_delivery_date', array($this, 'update_cart_item_delivery_date'));
        add_action('wp_ajax_nopriv_update_delivery_date', array($this, 'update_cart_item_delivery_date'));
        
        // Alternative JS Based Approach For Woocommere Blocks Approach
        // add_action('wp_ajax_get_delivery_date_dropdown', array($this, 'display_delivery_date_dropdown'));
        // add_action('wp_ajax_nopriv_get_delivery_date_dropdown', array($this, 'display_delivery_date_dropdown'));
    }

    public function display_delivery_date_in_cart($item_data, $cart_item) {
        $delivery_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : '';

        if (!empty($delivery_date)) {
            $item_data[] = array(
                'key'     => __('Selected Delivery Date', 'woocommerce'),
                'value'   => wc_clean($delivery_date),
                'display' => wc_clean($delivery_date),
            );
        }

        return $item_data;
    }

    public function display_delivery_date_dropdown() {
        ob_start();    
        $cart_item_data = [];
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_name = isset($cart_item['data']) ? $cart_item['data']->get_name() : '';
    
            if (Utils::is_subscription_product($product_id)) {
                $delivery_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : '';
                $dates = Utils::get_recurring_dates($product_id, $delivery_date);
                $cart_item_data[$cart_item_key] = [
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    '_delivery_date' => $delivery_date,
                    'dates' => $dates
                ];
            }
        }
        
        // Include the view file to render the HTML
        include(plugin_dir_path(__FILE__) . '../Views/cart-page-delivery-date.php');
        // Get the HTML output
        $html = ob_get_clean();
        
        // If it's an Ajax request, send JSON response For JS Based Alternative
        if (defined('DOING_AJAX') && DOING_AJAX) {
            wp_send_json_success(array('html' => $html));
        } else {
            // Otherwise, just output the HTML
            echo $html;
        }
    }

    public function enqueue_custom_cart_script() {
        if (is_cart()) {
            wp_enqueue_script(
                'custom-cart-script',
                plugin_dir_url(__FILE__) . '../js/custom-cart.js',
                array('jquery'),
                null,
                true
            );
        }
    }

    public function add_delivery_date_to_order_items($item, $cart_item_key, $values, $order) {
        if (isset($values['_delivery_date'])) {
            $item->add_meta_data(__('Delivery Date', 'woocommerce'), $values['_delivery_date'], true);
        }
    }

    public function update_cart_item_delivery_date() {
        if (isset($_POST['_delivery_date']) && isset($_POST['cart_item_key'])) {
            $cart = WC()->cart;
            if (isset($cart->cart_contents[$_POST['cart_item_key']])) {
                $cart->cart_contents[$_POST['cart_item_key']]['_delivery_date'] = sanitize_text_field($_POST['_delivery_date']);
            }
            $cart->set_session();
            wp_send_json_success();
        } else {
            wp_send_json_error('Invalid data');
        }
        wp_die();
    }
}