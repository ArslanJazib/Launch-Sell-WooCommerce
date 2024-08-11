<div class="delivery-date-options">
    <select id="delivery_date_select_<?php echo esc_attr($cart_item_key); ?>" name="delivery_date[<?php echo esc_attr($cart_item_key); ?>]">
        <?php foreach ($dates as $date): ?>
            <option value="<?php echo esc_attr($date); ?>" <?php selected($date, $delivery_date); ?>>
                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($date))); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>