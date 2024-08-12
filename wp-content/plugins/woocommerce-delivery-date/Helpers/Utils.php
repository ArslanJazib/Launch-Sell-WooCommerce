<?php

namespace WCDeliveryDate\Helpers;

use WCDeliveryDate\Models\DeliveryDateModel;
use WCDeliveryDate\Controllers\DeliveryDateCalculatorController;

class Utils {

    /**
     * Check if a given product ID is a subscription product.
     *
     * @param int $product_id The product ID.
     * @return bool True if the product is a subscription product, false otherwise.
     */
    public static function is_subscription_product($product_id) {
        $product = wc_get_product($product_id);
        if (!$product) {
            return false;
        }

        return $product->is_type('subscription') || $product->is_type('variable-subscription');
    }

    public static function get_recurring_dates($postID = null, $deliveryDate = null){
        $dates = [];

        if(!$postID){
            global $post;
            $postID = $post->ID;
        }

        if (Utils::is_subscription_product($postID)) {
            if(!$deliveryDate){
                $delivery_date = DeliveryDateModel::get_delivery_date($postID);
            } else {
                $delivery_date = $deliveryDate;
            }
            $interval_value = DeliveryDateModel::get_interval_value($postID);
            $interval_type = DeliveryDateModel::get_interval_type($postID);
            
            if ($delivery_date && $interval_value && $interval_type) {
                $dates = DeliveryDateCalculatorController::calculate_dates($delivery_date, $interval_value, $interval_type);
            }
        }

        return $dates;
    }
}

?>