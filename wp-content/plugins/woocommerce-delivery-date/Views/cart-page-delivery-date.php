<?php if (!defined('ABSPATH')) exit; ?>

<?php
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $delivery_date = isset($cart_item['_delivery_date']) ? $cart_item['_delivery_date'] : '';

    if (!empty($delivery_date)) {
        ?>
        <div class="delivery_date_edit">
            <label for="delivery_date_<?php echo esc_attr($cart_item_key); ?>"><?php _e('Edit Delivery Date:', 'woocommerce'); ?></label>
            <input type="text" id="delivery_date_<?php echo esc_attr($cart_item_key); ?>" name="_delivery_date" value="<?php echo esc_attr($delivery_date); ?>">
        </div>
        <?php
    }
}
?>