<?php if (!defined('ABSPATH')) exit; ?>

<?php
    if (!empty($_POST['delivery_date'])) {
        ?>
        <p><?php _e('Delivery Date:', 'woocommerce'); ?> <?php echo esc_html(sanitize_text_field($_POST['delivery_date'])); ?></p>
        <?php
    }
?>