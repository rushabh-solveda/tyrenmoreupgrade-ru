define([
    'jquery',
    "Magento_Customer/js/customer-data",
    'Magento_Checkout/js/checkout-data',
], function ($, customerData, checkoutData) {
    'use strict';
    $.widget('bss.quote_data', {
        _create: function () {
            $("#click-button").on('click', function(){
                var cartData = customerData.get('cart-data')(); // Data from "cart-data"
                var checkout = checkoutData.getShippingAddressFromData(); // data from "checkout-data"
                var selectedShippingMethod = checkoutData.getSelectedShippingRate(); // your selected shipping method from "checkout-data"
                /*Log data in console tab of browser*/
                console.log(cartData); // you can remove this after check
                console.log(checkout); // you can remove this after check
                console.log(selectedShippingMethod); // you can remove this after check
                /* Log data in console tab of browser */
                return false;
            });
        }
    });
    return $.bss.quote_data;
});