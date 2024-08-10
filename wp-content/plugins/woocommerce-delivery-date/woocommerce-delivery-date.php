<?php
/*
 * Plugin Name: WooCommerce Delivery Date
 * Plugin URI: https://github.com/ArslanJazib/Launch-Sell-WooCommerce.git
 * Description: WooCommerce Subscriptions Delivery Date Feature
 * Author: Arslan Jazib
 * Author URI: https://www.linkedin.com/in/arslan-jazib/
 * Version: 1.0.0
 * Requires Plugins: woocommerce, woocommerce-subscriptions
*/

defined('ABSPATH') or die('I can see you');

// Load Composer autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

use WCDeliveryDate\Controllers\Activator;
use WCDeliveryDate\Controllers\Deactivator;
use WCDeliveryDate\Controllers\Uninstaller;
use WCDeliveryDate\Controllers\DeliveryDateFieldController;
use WCDeliveryDate\Controllers\CartController;
use WCDeliveryDate\Controllers\CheckoutController;

if (!class_exists('WCDeliveryDate')) {
    class WCDeliveryDate {
        private $activator;
        private $deactivator;

        public function __construct() {
            // Initialize dependencies checker
            add_action('admin_init', array($this, 'dependency_checker'));

            // Initialize controllers
            new DeliveryDateFieldController();
            new CartController();
            new CheckoutController();

            // Setup activator and deactivator
            $this->activator = new Activator();
            register_activation_hook(__FILE__, array($this, 'plugin_activation'));

            $this->deactivator = new Deactivator();
            register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));

            // Register uninstall hook
            register_uninstall_hook(__FILE__, array('WCDeliveryDate', 'plugin_uninstall'));
        }

        // Check for plugin dependencies
        public function dependency_checker() {
            $this->activator->check_dependencies();
        }

        // Activation callback
        public function plugin_activation() {

        }

        // Deactivation callback
        public function plugin_deactivation() {

        }

        // Uninstall callback
        public static function plugin_uninstall() {
            $uninstaller = new Uninstaller();
        }
    }

    // Instantiate the main plugin class
    $wcdeliverydate = new WCDeliveryDate();
}