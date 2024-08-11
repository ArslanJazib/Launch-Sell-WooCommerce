<?php

namespace WCDeliveryDate\Controllers;

use WCDeliveryDate\Helpers\Utils;
use WCDeliveryDate\Models\DeliveryDateModel;
class DeliveryDateFieldController {

    private $helper;

    public function __construct() {
        $this->helper = new Utils();
        add_action('woocommerce_product_options_general_product_data', array($this, 'add_delivery_date_fields'));
        add_action('woocommerce_process_product_meta', array($this, 'save_delivery_date_fields'));
        add_action('woocommerce_before_add_to_cart_button', array($this, 'display_recurring_dates'), 10);
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
        global $post;

        if (Utils::is_subscription_product($post->ID)) {
            
            $delivery_date = DeliveryDateModel::get_delivery_date($post->ID);
            $interval_value = DeliveryDateModel::get_interval_value($post->ID);
            $interval_type = DeliveryDateModel::get_interval_type($post->ID);
            
            if ($delivery_date && $interval_value && $interval_type) {
                $dates = DeliveryDateCalculatorController::calculate_dates($delivery_date, $interval_value, $interval_type);
                include(plugin_dir_path(__FILE__) . '../Views/frontend-product-page-delivery-date.php');
            }
        }
    }    
}