<?php
namespace WCDeliveryDate\Controllers;

class CheckoutController {

    public function __construct() {
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_delivery_date_to_order_item'), 10, 4);
        add_action('woocommerce_checkout_update_order_meta', array($this, 'save_delivery_date_to_order_meta'));
        add_action('woocommerce_thankyou', array($this, 'display_delivery_date_on_thankyou_page'));
        add_action('woocommerce_admin_order_data_after_order_details', array($this, 'display_delivery_date_in_admin_order'));
    }

    // Add Delivery Date to Order Line Item
    public function add_delivery_date_to_order_item($item, $cart_item_key, $cart_item, $order) {
        if (isset($cart_item['delivery_date'])) {
            $item->add_meta_data(__('Delivery Date', 'woocommerce'), wc_clean($cart_item['delivery_date']), true);
        }
    }

    // Save Delivery Date to Order Meta
    public function save_delivery_date_to_order_meta($order_id) {
        if (!empty($_POST['delivery_date'])) {
            update_post_meta($order_id, '_delivery_date', sanitize_text_field($_POST['delivery_date']));
        }
    }

    // Display Delivery Date on Thank You Page
    public function display_delivery_date_on_thankyou_page($order_id) {
        $delivery_date = get_post_meta($order_id, '_delivery_date', true);
        if ($delivery_date) {
            echo '<p>' . __('Delivery Date:', 'woocommerce') . ' ' . esc_html($delivery_date) . '</p>';
        }
    }

    // Display Delivery Date in Admin Order Details
    public function display_delivery_date_in_admin_order($order) {
        $order_id = $order->get_id();
        $delivery_date = get_post_meta($order_id, '_delivery_date', true);
        if ($delivery_date) {
            echo '<p><strong>' . __('Delivery Date:', 'woocommerce') . '</strong> ' . esc_html($delivery_date) . '</p>';
        }
    }
}