var config = {
    config: {
        mixins: {
            // mixin added to select COD payment method checked
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Magento_Checkout/js/model/checkout-data-resolver-mixin': true
            },
            // new mixin to not reload shipping method when change state, pincode, city
            'Magento_Checkout/js/model/shipping-rates-validation-rules': {
                'Magento_Checkout/js/model/shipping-rates-validation-rules-mixin': false
            }
        }
    }
};