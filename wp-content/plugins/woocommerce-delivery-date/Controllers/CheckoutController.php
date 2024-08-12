<?php
namespace WCDeliveryDate\Controllers;

use WCDeliveryDate\Helpers\Utils;
class CheckoutController {

    public function __construct() {
        add_action('woocommerce_after_order_notes', array($this, 'display_delivery_date_checkout_field'));
        add_action('woocommerce_checkout_process', array($this, 'validate_delivery_date_checkout_field'));
        add_action('woocommerce_checkout_update_order_meta', array($this, 'save_delivery_date_to_order_meta'));
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_delivery_date_to_order_item'), 10, 4);
        add_action('woocommerce_thankyou', array($this, 'display_delivery_date_on_thankyou_page'));
        add_action('woocommerce_admin_order_data_after_order_details', array($this, 'display_delivery_date_in_admin_order'));
    }

    // Display Delivery Date Field on Checkout Page
    public function display_delivery_date_checkout_field($checkout) {
        $cart_items = WC()->cart->get_cart();
        foreach($cart_items as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $selected_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : null;
            $available_dates = Utils::get_recurring_dates($product_id, $selected_date);
            if (!empty($available_dates)) {
                woocommerce_form_field(
                    "_delivery_date{$cart_item_key}",
                    array(
                        'type'        => 'select',
                        'class'       => array('delivery-date-field form-row-wide'),
                        'label'       => __('Select Delivery Date for', 'woocommerce') . ' ' . $cart_item['data']->get_name(),
                        'required'    => true,
                        'options'     => array_combine($available_dates, $available_dates),
                        'default'     => $selected_date,
                    ),
                    $checkout->get_value("_delivery_date{$cart_item_key}")
                );
            }
        }
    }

    // Validate Delivery Date Field on Checkout
    public function validate_delivery_date_checkout_field() {
        $cart_items = WC()->cart->get_cart();
        foreach($cart_items as $cart_item_key => $cart_item) {
            if (empty($_POST["_delivery_date_{$cart_item_key}"])) {
                wc_add_notice(__('Please select a delivery date for', 'woocommerce') . ' ' . $cart_item['data']->get_name(), 'error');
            }
        }
    }

    // Save Delivery Date to Order Meta
    public function save_delivery_date_to_order_meta($order_id) {
        $cart_items = WC()->cart->get_cart();
        foreach($cart_items as $cart_item_key => $cart_item) {
            if (!empty($_POST["_delivery_date_{$cart_item_key}"])) {
                update_post_meta($order_id, "_delivery_date_{$cart_item_key}", sanitize_text_field($_POST["_delivery_date_{$cart_item_key}"]));
            }
        }
    }

    // Add Delivery Date to Order Line Item
    public function add_delivery_date_to_order_item($item, $cart_item_key, $cart_item, $order) {
        if (isset($_POST["_delivery_date_{$cart_item_key}"])) {
            $item->add_meta_data(__('Delivery Date', 'woocommerce'), wc_clean($_POST["_delivery_date_{$cart_item_key}"]), true);
        }
    }

    // Display Delivery Date on Thank You Page
    public function display_delivery_date_on_thankyou_page($order_id) {
        $order = wc_get_order($order_id);
        foreach ($order->get_items() as $item_id => $item) {
            $delivery_date = get_post_meta($order_id, "_delivery_date_{$item_id}", true);
            if ($delivery_date) {
                echo '<p>' . sprintf(__('Delivery Date for %s:', 'woocommerce'), esc_html($item->get_name())) . ' ' . esc_html($delivery_date) . '</p>';
            }
        }
    }

    // Display Delivery Date in Admin Order Details
    public function display_delivery_date_in_admin_order($order) {
        foreach ($order->get_items() as $item_id => $item) {
            $delivery_date = get_post_meta($order->get_id(), "_delivery_date_{$item_id}", true);
            if ($delivery_date) {
                echo '<p><strong>' . sprintf(__('Delivery Date for %s:', 'woocommerce'), esc_html($item->get_name())) . '</strong> ' . esc_html($delivery_date) . '</p>';
            }
        }
    }
}