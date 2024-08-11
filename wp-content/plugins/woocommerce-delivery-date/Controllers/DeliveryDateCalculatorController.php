<?php

namespace WCDeliveryDate\Controllers;

use DateTime;
use WCDeliveryDate\Helpers\Utils;
use WCDeliveryDate\Models\DeliveryDateModel;

class DeliveryDateCalculatorController {

    public function __construct() {
        add_action('woocommerce_before_add_to_cart_button', array($this, 'display_recurring_dates'));
    }

    /**
     * Calculate the next set of recurring dates based on provided delivery date, interval value, and interval type.
     * 
     * @param string $delivery_date Start date for calculating recurring dates.
     * @param int $interval_value Number of units for the interval (e.g., 1, 2, 3).
     * @param string $interval_type Type of interval (days, weeks, months, years).
     * @return array List of calculated dates in 'Y-m-d' format.
     */
    public static function calculate_dates($delivery_date, $interval_value, $interval_type) {
        $dates = [];
        $delivery_date = new DateTime($delivery_date);
        $current_date = new DateTime();

        // Adjust delivery date to be after the current date if necessary
        if ($delivery_date < $current_date) {
            switch ($interval_type) {
                case 'days':
                    while ($delivery_date < $current_date) {
                        $delivery_date->modify('+' . $interval_value . ' days');
                    }
                    break;
                case 'weeks':
                    while ($delivery_date < $current_date) {
                        $delivery_date->modify('+' . $interval_value . ' weeks');
                    }
                    break;
                case 'months':
                    while ($delivery_date < $current_date) {
                        $delivery_date->modify('+' . $interval_value . ' months');
                    }
                    break;
                case 'years':
                    while ($delivery_date < $current_date) {
                        $delivery_date->modify('+' . $interval_value . ' years');
                    }
                    break;
            }
        }

        // Calculate the next set of recurring dates
        $number_of_dates = DeliveryDateModel::get_number_of_dates();
        for ($i = 0; $i < $number_of_dates; $i++) {
            $dates[] = $delivery_date->format('Y-m-d');
            switch ($interval_type) {
                case 'days':
                    $delivery_date->modify('+' . $interval_value . ' days');
                    break;
                case 'weeks':
                    $delivery_date->modify('+' . $interval_value . ' weeks');
                    break;
                case 'months':
                    $delivery_date->modify('+' . $interval_value . ' months');
                    break;
                case 'years':
                    $delivery_date->modify('+' . $interval_value . ' years');
                    break;
            }
        }

        return $dates;
    }
}