<?php

namespace WCDeliveryDate\Controllers;

class Activator {


    public function __construct() {

    }

    public function check_dependencies() {
        // Check if the dependencies are active
        if (!is_plugin_active('woocommerce/woocommerce.php') && !is_plugin_active('woocommerce-subscriptions/woocommerce-subscriptions.php')) {
            
            // Deactivate your plugin
            deactivate_plugins(plugin_basename('woocommerce-delivery-date/woocommerce-delivery-date.php'));
    
            // Set an activation notice message
            add_action('admin_notices', array($this, 'dependencies_notice'));

        }
    }
    
    public function dependencies_notice() {
        $message = __('WooCommerce Delivery Date Plugin Requires both Woocommerce & Woocommerce Subscriptions Plugin to installed and activated before activating this extension.', '');
        echo '<div class="error"><p>' . $message . '</p> </div>';
    }

}