define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'uiRegistry'
], function ($, Abstract, registry) {
    'use strict';
  
    return Abstract.extend({
        initialize: function (){
            return this._super();
        },
 
        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (fullname) {
            var name = fullname.split(' ');
            var fname = name[0];
            name.shift();
            var lname = name.join(' ');
            if(lname == '') {
                lname = '.';
            }
            // cod
            var firstname = registry.get('checkout.steps.billing-step.payment.payments-list.cashondelivery-form.form-fields.firstname');
            var lastname = registry.get('checkout.steps.billing-step.payment.payments-list.cashondelivery-form.form-fields.lastname');
            firstname.value(fname);
            lastname.value(lname);
            // pay
            var firstname = registry.get('checkout.steps.billing-step.payment.payments-list.payu-form.form-fields.firstname');
            var lastname = registry.get('checkout.steps.billing-step.payment.payments-list.payu-form.form-fields.lastname');
            firstname.value(fname);
            lastname.value(lname);
            return this._super();
        }
    });
 });