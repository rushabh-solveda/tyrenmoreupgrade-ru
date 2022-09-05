/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals',
    'Magento_Checkout/js/model/sidebar',
    'jquery',
    'Magento_Checkout/js/model/step-navigator',
    'ko',
], function (Component, quote, priceUtils, totals, sidebarModel, $, steps, ko) {
    'use strict';

    return Component.extend({
        isLoading: totals.isLoading,
        isProceedButtonHidden: ko.observable(false),
        isPaymentButtonHidden: ko.observable(true),
        /**
         * @return {Number}
         */
        getQuantity: function () {
            if (totals.totals()) {
                return parseFloat(totals.totals()['items_qty']);
            }

            return 0;
        },

        /**
         * @return {Number}
         */
        getPureValue: function () {
            if (totals.totals()) {
                return parseFloat(totals.getSegment('grand_total').value);
            }

            return 0;
        },

        /**
         * Show sidebar.
         */
        showSidebar: function () {
            sidebarModel.show();
        },

        /**
         * @param {*} price
         * @return {*|String}
         */
        getFormattedPrice: function (price) {
            return priceUtils.formatSummeryOrder(price, quote.getPriceFormat());
        },

        /**
         * @return {*|String}
         */
        getValue: function () {
            return this.getFormattedPrice(this.getPureValue());
        },
        getProceedText: function(){
            var activeStep = steps.getActiveItemIndex();
            var text = 'Proceed';
            if(activeStep == 1) {
                text = 'Place Order'
                this.isProceedButtonHidden(true);
                this.isPaymentButtonHidden(false);
            }
            return text;
        },
        submitShippingForm: function(){
            var activeStep = steps.getActiveItemIndex();
            
            if(activeStep == 0) {
                $('#co-shipping-method-form').submit();
            } else if(activeStep == 1) {
                $('.checkout').trigger('click');
            }
        }
    });
});
