<?php if (!defined('ABSPATH')) exit; ?>

<?php
if (!empty($cart_item_data)) {
    ?>

    <table class="delivery_date_table" cellpadding="10" cellspacing="0" border="1" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th><?php _e('Title', 'woocommerce'); ?></th>
                <th><?php _e('Delivery Date Options', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cart_item_data as $cart_item_key => $data) {
                $product_name = $data['product_name'];
                $current_delivery_date = $data['delivery_date'];
                $dates = $data['dates'];
                ?>

                <tr>
                    <td><?php echo esc_html($product_name); ?></td>
                    <td>
                        <select class="delivery_date_dropdown" name="_delivery_date[<?php echo esc_attr($cart_item_key); ?>]" data-cart-item-key=<?php echo esc_attr($cart_item_key); ?> id="delivery_date_<?php echo esc_attr($cart_item_key); ?>">
                            <?php foreach ($dates as $date): ?>
                                <option value="<?php echo esc_attr($date); ?>" <?php selected($current_delivery_date, $date); ?>>
                                    <?php echo esc_html($date); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>

    <?php
}
?>