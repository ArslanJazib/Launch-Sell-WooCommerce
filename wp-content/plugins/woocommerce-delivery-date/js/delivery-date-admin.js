jQuery(document).ready(function($) {
    function toggleDeliveryDateFields() {
        var productType = $('#product-type').val();
        if (productType === 'subscription' || productType === 'variable-subscription') {
            $('.delivery_date_options').show();
        } else {
            $('.delivery_date_options').hide();
        }
    }

    // On page load
    toggleDeliveryDateFields();

    // On product type change
    $('#product-type').change(function() {
        toggleDeliveryDateFields();
    });
});