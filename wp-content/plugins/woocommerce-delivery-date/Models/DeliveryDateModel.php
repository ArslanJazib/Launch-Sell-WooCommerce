<?php

namespace WCDeliveryDate\Models;

class DeliveryDateModel {

    public static function get_delivery_date($product_id) {
        return get_post_meta($product_id, '_delivery_date', true);
    }

    public static function save_delivery_date($product_id, $delivery_date) {
        update_post_meta($product_id, '_delivery_date', $delivery_date);
    }

    public static function get_interval_value($product_id) {
        return get_post_meta($product_id, '_interval_value', true);
    }

    public static function save_interval_value($product_id, $interval_value) {
        update_post_meta($product_id, '_interval_value', $interval_value);
    }

    public static function get_interval_type($product_id) {
        return get_post_meta($product_id, '_interval_type', true);
    }

    public static function save_interval_type($product_id, $interval_type) {
        update_post_meta($product_id, '_interval_type', $interval_type);
    }
    
    public static function get_number_of_dates() {
        $number_of_dates = get_option('number_of_dates', 3);
        return intval($number_of_dates);
    } 
}