<?php if (!defined('ABSPATH')) exit; ?>

<?php
if (!empty($cart_item_data)) {
    foreach ($cart_item_data as $cart_item_key => $data) {
        $current_delivery_date = $data['_delivery_date'];
        $dates = $data['dates'];
        ?>

        <div class="delivery-date-options">
            <label for="delivery_date_select_<?php echo esc_attr($cart_item_key); ?>">
                <?php _e('Select Delivery Date:', 'woocommerce'); ?>
            </label>
            <select class="delivery_date_dropdown" id="delivery_date_select_<?php echo esc_attr($cart_item_key); ?>" name="_delivery_date[<?php echo esc_attr($cart_item_key); ?>]" data-cart-item-key=<?php echo esc_attr($cart_item_key); ?>>
                <?php foreach ($dates as $date): ?>
                    <option value="<?php echo esc_attr($date); ?>" <?php selected($current_delivery_date, $date); ?>>
                        <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($date))); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php
    }
}
?>