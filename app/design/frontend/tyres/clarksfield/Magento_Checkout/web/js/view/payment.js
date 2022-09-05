/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/step-navigator',
    'Magento_Checkout/js/model/payment-service',
    'Magento_Checkout/js/model/payment/method-converter',
    'Magento_Checkout/js/action/get-payment-information',
    'Magento_Checkout/js/model/checkout-data-resolver',
    'mage/translate',
    'mage/url'
], function (
    $,
    _,
    Component,
    ko,
    quote,
    stepNavigator,
    paymentService,
    methodConverter,
    getPaymentInformation,
    checkoutDataResolver,
    $t,
    url
) {
    'use strict';

    /** Set payment methods to collection */
    paymentService.setPaymentMethods(methodConverter(window.checkoutConfig.paymentMethods));

    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/payment',
            activeMethod: ''
        },
        isVisible: ko.observable(quote.isVirtual()),
        quoteIsVirtual: quote.isVirtual(),
        isPaymentMethodsAvailable: ko.computed(function () {
            return paymentService.getAvailablePaymentMethods().length > 0;
        }),

        /** @inheritdoc */
        initialize: function () {
            this._super();
            checkoutDataResolver.resolvePaymentMethod();
            stepNavigator.registerStep(
                'payment',
                null,
                $t('Review & Payments'),
                this.isVisible,
                _.bind(this.navigate, this),
                20
            );

            return this;
        },

        /**
         * Navigate method.
         */
        navigate: function () {
            var self = this;

            if (!self.hasShippingMethod()) {
                this.isVisible(false);
                stepNavigator.setHash('shipping');
            } else {
                getPaymentInformation().done(function () {
                    self.isVisible(true);
                });
            }
        },

        /**
         * @return {Boolean}
         */
        hasShippingMethod: function () {
            return window.checkoutConfig.selectedShippingMethod !== null;
        },

        /**
         * @return {*}
         */
        getFormKey: function () {
            return window.checkoutConfig.formKey;
        },
        getPaymentUrl: function() {
			return url.build('checkout/#payment');
		},
        getShippingUrl: function() {
			return url.build('checkout/#shipping');
		},
        getHomeUrl: function() {
			return url.build('/');
		}
    });
});
