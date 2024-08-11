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
}

?>