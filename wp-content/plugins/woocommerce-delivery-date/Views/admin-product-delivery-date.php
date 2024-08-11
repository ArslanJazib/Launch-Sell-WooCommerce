<?php if (!defined('ABSPATH')) exit; ?>

<div class="options_group">
    <!-- Delivery Start Date Field -->
    <p class="form-field">
        <label for="_delivery_date"><?php _e('Delivery Start Date', 'woocommerce'); ?></label>
        <input type="date" id="_delivery_date" name="_delivery_date" value="<?php echo esc_attr($delivery_date); ?>" placeholder="<?php _e('Select the delivery start date', 'woocommerce'); ?>" class="wc-datepicker" />
        <span class="description"><?php _e('Select the delivery start date for this subscription product.', 'woocommerce'); ?></span>
    </p>

    <!-- Recurring Interval Field -->
    <p class="form-field">
        <label for="_recurring_interval"><?php _e('Recurring Interval', 'woocommerce'); ?></label>
        <select id="_recurring_interval" name="_recurring_interval" class="short">
            <option value="days" <?php selected($interval_type, 'days'); ?>><?php _e('Days', 'woocommerce'); ?></option>
            <option value="weeks" <?php selected($interval_type, 'weeks'); ?>><?php _e('Weeks', 'woocommerce'); ?></option>
            <option value="months" <?php selected($interval_type, 'months'); ?>><?php _e('Months', 'woocommerce'); ?></option>
            <option value="years" <?php selected($interval_type, 'years'); ?>><?php _e('Years', 'woocommerce'); ?></option>
        </select>
        <span class="description"><?php _e('Select how frequently the delivery should recur.', 'woocommerce'); ?></span>
    </p>
    
    <p class="form-field">
        <label for="_interval_value"><?php _e('Interval Value', 'woocommerce'); ?></label>
        <input type="number" id="_interval_value" name="_interval_value" value="<?php echo esc_attr($interval_value); ?>" placeholder="<?php _e('Number of intervals', 'woocommerce'); ?>" />
        <span class="description"><?php _e('Specify the number of intervals for the recurring delivery.', 'woocommerce'); ?></span>
    </p>
</div>