jQuery(document).ready(function($) {
    // Function to load and append the delivery date dropdown
    function loadDeliveryDateDropdown() {
        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'get_delivery_date_dropdown'
            },
            success: function(response) {
                if (response.success) {
                    $('.wp-block-woocommerce-cart-items-block').append(response.data.html);
                } else {
                    console.error('Failed to load delivery date dropdown.');
                }
            },
            error: function() {
                console.error('AJAX request failed.');
            }
        });
    }

    // Event handler for changing delivery date
    $(document).on('change', '.delivery_date_dropdown', function() {
        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'update_delivery_date',
                _delivery_date: $(this).val(),
                cart_item_key: $(this).attr('data-cart-item-key')
            },
            success: function(response) {
                if (response.success) {
                    console.log('Delivery date updated successfully.');
                    location.reload();
                } else {
                    console.error('Failed to update delivery date.');
                }
            },
            error: function() {
                console.error('AJAX request failed.');
            }
        });
    });

    loadDeliveryDateDropdown();
});