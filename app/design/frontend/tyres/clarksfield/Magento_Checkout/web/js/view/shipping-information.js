/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/step-navigator',
    'Magento_Checkout/js/model/sidebar'
], function ($, Component, quote, stepNavigator, sidebarModel) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/shipping-information'
        },

        /**
         * @return {Boolean}
         */
        isVisible: function () {
            return !quote.isVirtual() && stepNavigator.isProcessed('shipping');
        },

        /**
         * @return {String}
         */
        getShippingMethodTitle: function () {
            var shippingMethod = quote.shippingMethod();
            var message = '';
            if(shippingMethod) {
                message += shippingMethod['carrier_title']? shippingMethod['carrier_title']:'';
                message += shippingMethod['method_title']? shippingMethod['method_title']:'';
                message += shippingMethod['price_incl_tax']? ' - ₹'+shippingMethod['price_incl_tax']:'';
            }
            return message;
            // return shippingMethod ? shippingMethod['carrier_title'] + ' - ' + shippingMethod['method_title'] : '';
        },

        /**
         * Back step.
         */
        back: function () {
            sidebarModel.hide();
            stepNavigator.navigateTo('shipping');
        },

        /**
         * Back to shipping method.
         */
        backToShippingMethod: function () {
            sidebarModel.hide();
            stepNavigator.navigateTo('shipping', 'opc-shipping_method');
        }
    });
});