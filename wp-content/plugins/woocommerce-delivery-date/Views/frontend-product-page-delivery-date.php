<?php if (!defined('ABSPATH')) exit; ?>

<div class="delivery-date-options">
    <label for="delivery_date_select"><?php _e('Select Delivery Date:', 'woocommerce'); ?></label>
    <select id="delivery_date_select" name="_delivery_date">
        <?php foreach ($dates as $date): ?>
            <option value="<?php echo esc_attr($date); ?>"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($date))); ?></option>
        <?php endforeach; ?>
    </select>
</div>