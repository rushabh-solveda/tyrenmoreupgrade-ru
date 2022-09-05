/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

 define([
    'uiComponent',
    'ko',
    'jquery',
    'Magento_Checkout/js/model/sidebar',
	'Magento_Checkout/js/model/step-navigator'
], function (Component, ko, $, sidebarModel,steps) {
    'use strict';

    return Component.extend({
        /**
         * @param {HTMLElement} element
         */
        setModalElement: function (element) {
            sidebarModel.setPopup($(element));
        },
        getProceedText: function(){
            var activeStep = steps.getActiveItemIndex();
            var text = 'Proceed';
            if(activeStep == 1) {
                text = 'Place Order';
            }
            return text;
        },
        submitShipping: function(){
            var activeStep = steps.getActiveItemIndex();
            
            if(activeStep == 0) {
                $('#co-shipping-method-form').submit();
            } else if(activeStep == 1) {
                $('.checkout').trigger('click');
            }
        }
    });
});

