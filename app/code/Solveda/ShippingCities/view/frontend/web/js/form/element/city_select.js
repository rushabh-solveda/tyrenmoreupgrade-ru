define([
    'jquery',
    'Magento_Ui/js/form/element/select',
    'uiRegistry',
    'underscore',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'jquery/jquery.cookie'
], function ($, Select, registry, _, quote, rateRegistry) {
    'use strict';
  
    return Select.extend({
        initialize: function (val){
            this._super();
            // trigger onUpdate on initialization
            this.onUpdate(this.value());
            return this;
        },
 
        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
            
            var custom_city = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.custom_city')
            if(custom_city) {
                this.updateFields(value)
            } else {
                var parentComponent = this;
                setTimeout(function(){
                    parentComponent.updateFields(value, true);
                }, 1000);
            }
            return this._super();
        },
        updateFields: function(value, onload = false){
            var custom_city = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.custom_city')
            if(custom_city) {
                var allOptions = custom_city.options();
                var selectedCity = _.find(allOptions, function (o) { return o.value == value; })
                
                var city = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.city')
                var additional = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.additional_block')
                
                if(selectedCity) {
                    $('.product_cities_select').val(selectedCity.value);
                    $.cookie('selected_city', selectedCity.value, { expires: 30, path: '/',domain: '.tyresnmore.com'});
                    if(selectedCity.display_input_for_city == 1) {
                        city.value('');
                        city.show();
                        additional.set('isVisible', false);
                        $('.checkout-shipping-method').find('.step-title').html('Shipping & Handling fees');
                    } else {
                        city.hide();
                        city.value(selectedCity.label)
                        additional.set('isVisible', true);
                        $('.checkout-shipping-method').find('.step-title').html('Doorstep Fitment Fees');
                    }
                }
                // trigger shipping method to reload on load
                if(onload) {
                    setTimeout(function(){
                        var address = quote.shippingAddress();
                        address.trigger_reload = new Date().getTime();
                        rateRegistry.set(address.getKey(), null);
                        rateRegistry.set(address.getCacheKey(), null);
                        if(value != undefined) {
                            var customAttributes = {'attribute_code':'custom_city', value: value};
                            address.customAttributes =  address && address.customAttributes ? address.customAttributes.concat([customAttributes]) : [customAttributes];
                        }
                        quote.shippingAddress(address);
                    }, 1000);
                }
            }
        }
    });
 });