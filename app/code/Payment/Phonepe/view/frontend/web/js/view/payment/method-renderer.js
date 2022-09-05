define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list',
        'Magento_Ui/js/form/form',
        'jquery',
        'mage/url'
    ],
    function (
        Component,
        rendererList,
        $,
        url
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'phonepe',
                component: 'Payment_Phonepe/js/view/payment/method-renderer/testpayment'
            }
        );
        return Component.extend({
            initialize: function () {
            var self= this._super();
            
            return this;
           
        }
        });
    }
);
