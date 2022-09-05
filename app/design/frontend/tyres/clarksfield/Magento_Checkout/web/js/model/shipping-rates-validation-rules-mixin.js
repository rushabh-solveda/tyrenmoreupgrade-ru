define([
    'jquery',
    'mage/utils/wrapper',
    'underscore',
    'uiRegistry'
], function ($, wrapper, _) {
    "use strict";

    return function (shippingRatesValidationRules) {
        shippingRatesValidationRules.getObservableFields = wrapper.wrap(shippingRatesValidationRules.getObservableFields,
            function (originalAction) {
                var fields = originalAction();
                
                var result;
                result = _.without(fields, 'street');
                result = _.without(result, 'city');
                result = _.without(result, 'region_id');
                result = _.without(result, 'country_id');
                
                return result;
            }
        );

        return shippingRatesValidationRules;
    };
});