<?php
namespace WCDeliveryDate\Controllers;

use WCDeliveryDate\Helpers\Utils;
use WCDeliveryDate\Models\DeliveryDateModel;
use WCDeliveryDate\Controllers\DeliveryDateCalculatorController;

class CartController {

    public function __construct() {
        add_filter('woocommerce_get_item_data', array($this, 'display_delivery_date_in_cart'), 10, 2);
        add_action('woocommerce_cart_contents', array($this, 'render_delivery_date_edit_form'), 10, 2);
        add_action('woocommerce_add_cart_item_data', array($this, 'add_delivery_date_to_cart_item'), 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_delivery_date_to_order_items'), 10, 4);
        add_action('wp_loaded', array($this, 'update_cart_item_delivery_date'));
    }

    public function display_delivery_date_in_cart($item_data, $cart_item) {
        $delivery_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : '';

        // Display the delivery date if it exists
        if (!empty($delivery_date)) {
            $item_data[] = array(
                'key'     => __('Selected Delivery Date', 'woocommerce'),
                'value'   => wc_clean($delivery_date),
                'display' => wc_clean($delivery_date),
            );
        }

        return $item_data;
    }

    public function render_delivery_date_edit_form($item_name, $cart_item) {
        $product_id = $cart_item['product_id'];
        $cart_item_key = $cart_item['key'];

        if (Utils::is_subscription_product($product_id)) {
            $delivery_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : '';
            $interval_value = DeliveryDateModel::get_interval_value($product_id);
            $interval_type = DeliveryDateModel::get_interval_type($product_id);
            $dates = DeliveryDateCalculatorController::calculate_dates($delivery_date, $interval_value, $interval_type);

            ob_start();
            include(plugin_dir_path(__FILE__) . '../Views/cart-delivery-date.php');
            $dropdown_html = ob_get_clean();

            // Append the form to the cart item name
            $item_name .= $dropdown_html;
        }

        return $item_name;
    }

    public function add_delivery_date_to_cart_item($cart_item_data, $product_id) {
        if (isset($_POST['_delivery_date'])) {
            $cart_item_data['_delivery_date'] = sanitize_text_field($_POST['_delivery_date']);
        }
        return $cart_item_data;
    }

    public function add_delivery_date_to_order_items($item, $cart_item_key, $values, $order) {
        if (isset($values['_delivery_date'])) {
            $item->add_meta_data(__('Delivery Date', 'woocommerce'), $values['_delivery_date'], true);
        }
    }

    public function update_cart_item_delivery_date() {
        if (isset($_POST['delivery_date']) && is_array($_POST['delivery_date'])) {
            foreach ($_POST['delivery_date'] as $cart_item_key => $new_date) {
                $cart = WC()->cart;
                if (isset($cart->cart_contents[$cart_item_key])) {
                    $cart->cart_contents[$cart_item_key]['_delivery_date'] = sanitize_text_field($new_date);
                }
            }
            WC()->cart->set_session();
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
}