define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Solveda_ShippingCities/checkout/shipping/additional-block'
        },
        isVisible: ko.observable(true)
    });
});