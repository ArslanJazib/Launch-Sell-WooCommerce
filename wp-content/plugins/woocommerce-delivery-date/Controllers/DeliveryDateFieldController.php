<?php

namespace WCDeliveryDate\Controllers;

use WCDeliveryDate\Helpers\Utils;
use WCDeliveryDate\Models\DeliveryDateModel;
class DeliveryDateFieldController {

    public function __construct() {
        add_action('woocommerce_product_options_general_product_data', array($this, 'add_delivery_date_fields'));
        add_action('woocommerce_process_product_meta', array($this, 'save_delivery_date_fields'));
        add_action('woocommerce_before_add_to_cart_button', array($this, 'display_recurring_dates'), 10);
        add_filter('woocommerce_add_cart_item_data', array($this, 'add_delivery_date_to_cart_item'), 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_delivery_date_to_order_items'), 10, 4);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script(
            'delivery-date-admin',
            plugin_dir_url(__FILE__) . '../js/delivery-date-admin.js',
            array('jquery'),
            null,
            true
        );
    }

    public function add_delivery_date_fields() {
        global $post;

        if (Utils::is_subscription_product($post->ID)) {
            $delivery_date = DeliveryDateModel::get_delivery_date($post->ID);
            $interval_value = DeliveryDateModel::get_interval_value($post->ID);
            $interval_type = DeliveryDateModel::get_interval_type($post->ID);

            include(dirname(plugin_dir_path(__FILE__)) . '/Views/admin-product-delivery-date.php');
        }
    }

    public function save_delivery_date_fields($post_id) {
        if (Utils::is_subscription_product($post_id)) {
            if (isset($_POST['_delivery_date'])) {
                DeliveryDateModel::save_delivery_date($post_id, sanitize_text_field($_POST['_delivery_date']));
            }

            if (isset($_POST['_interval_value'])) {
                DeliveryDateModel::save_interval_value($post_id, intval($_POST['_interval_value']));
            }

            if (isset($_POST['_recurring_interval'])) {
                DeliveryDateModel::save_interval_type($post_id, sanitize_text_field($_POST['_recurring_interval']));
            }
        }
    }

    public function display_recurring_dates() {
        if(!empty(Utils::get_recurring_dates())){
            $dates = Utils::get_recurring_dates();
            include(plugin_dir_path(__FILE__) . '../Views/frontend-product-page-delivery-date.php');
        }
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
}