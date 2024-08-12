# Custom WooCommerce Subscriptions Delivery Date Plugin

## 1. Introduction / Purpose

The **Custom WooCommerce Subscriptions Delivery Date Plugin** extends WooCommerce by adding a "Delivery Date" feature for both simple and variable subscription products. This plugin allows administrators to set a recurring delivery date (e.g., the 3rd day of every week or the 1st day of every month) and displays the next three recurring dates in a dropdown menu on the product page. Customers can view and edit their selected delivery date on the cart page, with the optional feature to adjust the delivery date during checkout. The plugin ensures a flexible and robust solution for managing subscription delivery dates, providing a user-friendly experience for both admins and customers.

## 2. Folder Structure & MVC

The plugin follows the Model-View-Controller (MVC) architectural pattern to ensure a clean separation of concerns and better code management. This structure helps maintain a clear organization of code, making it easier to manage and extend functionalities. This approach is modeled after a similar project I designed , developed & later supervised on where we developed multiple plugins and a custom theme for an automated news publication application: [Automated News Publication](https://github.com/ArslanJazib/Automated-News-Publication.git). The directory structure is organized as follows:

woocommerce-delivery-date/
│
├── Controllers/
│ ├── Activator.php
│ ├── Deactivator.php
│ ├── Uninstaller.php
│ ├── DeliveryDateFieldController.php
│ ├── DeliveryDateCalculatorController.php
│ ├── CartController.php
│ └── CheckoutController.php
│
├── Models/
│ └── DeliveryDateModel.php
│
├── Views/
│ ├── admin-product-delivery-date.php
│ ├── cart-page-delivery-date.php
│ └── frontend-product-page-delivery-date.php
│
├── Helpers/
│ └── Utils.php
│
├── js/
│ └── delivery-date-admin.js
│
└── woocommerce-delivery-date.php


## 3. Insights & Guidelines

Development took additional time due to integration challenges with WooCommerce Blocks. The latest WooCommerce versions use blocks, which do not support traditional hooks for customization. Consequently, customizations had to adapt by using shortcodes such as `[woocommerce_cart]` and `[woocommerce_checkout]` to apply modifications.

For more details on these issues, refer to:
- [Value showing as 1 of the custom field](https://wordpress.org/support/topic/value-showing-as-1-of-the-custom-field/)
- [Checkout hooks are not working when checkout page is created with WooCommerce widget](https://wordpress.org/support/topic/checkout-hooks-are-not-working-when-checkout-page-is-created-with-woo-widget/)

The decision to use the MVC pattern was driven by the need for better code management, although familiarity with the traditional plugin directory approach also influenced the design.

## 4. Improvements

Future improvements could include:
- Adding hooks to pass custom classes for styling components.
- Incorporating custom CSS to enhance visual appeal.
- Handling integration with WooCommerce Blocks more effectively.

These enhancements aim to refine the plugin’s flexibility and ensure it meets evolving user needs and WooCommerce updates.