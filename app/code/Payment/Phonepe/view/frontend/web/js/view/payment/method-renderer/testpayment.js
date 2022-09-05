define(
    [
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/quote',
        'jquery',
        'ko',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Checkout/js/action/set-payment-information',
        'mage/url',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Ui/js/model/messageList',
        'Magento_Ui/js/form/form'
    ],
    function (
        Component,
        quote,
        $,
        ko,
        additionalValidators,
        setPaymentInformationAction,
        url,
        customer,
        placeOrderAction,
        fullScreenLoader,
        messageList
    ) {
        'use strict';
        var RESEVATION_ID,temp_order_id,transaction_id;
        
        return Component.extend({
            defaults: {
                template: 'Payment_Phonepe/payment/testpayment',
                paymentMethodNonce: null,
                phonepeDataFrameLoaded: false,
                phonepe_response: {},
                
            },
        //     initialize: function () {
        //     var self= this;
        //     $.getScript("https://tyres.clarksfield.com/phonepe-js-sdk-master/bundle.js", function () {
        //         self.phonepeDataFrameLoaded = true;
                  
        //     });
        //     alert('sdfsdfsnnnnnnnnnnnnnn');
        //   self.getAuthToken();
           
        //   return this;
           
        // },
            
           

            setPaymentMethodNonce: function (paymentMethodNonce) {
                this.paymentMethodNonce = paymentMethodNonce;
            },

            beforePlaceOrder: function (data) {
                this.setPaymentMethodNonce(data.nonce);
                this.placeOrder();
            },
            handleError: function (error) {
                if (_.isObject(error)) {
                    this.messageContainer.addErrorMessage(error);
                } else {
                    this.messageContainer.addErrorMessage({
                        message: error
                    });
                }
            },
            

       

            initObservable: function () {
                var self = this._super();
                
                
                $("#agreement_phonepe_1").checked=true;
                
                $.getScript("https://tyresnmore.com/phonepe-js-sdk-master/bundle.js", function () {
                    self.phonepeDataFrameLoaded = true;
                  
                });
               

                return self;
            },

            /**
             * @override
            */
            /** Process Payment */
            preparePayment: function (context, event) {



                if (!additionalValidators.validate()) {   //Resolve checkout aggreement accept error
                     
                    return false;
                }
                
                var self = this,
                    billing_address,
                    phonepe_order_id;

                fullScreenLoader.startLoader();
                this.messageContainer.clear();

                this.amount = quote.totals()['base_grand_total'] * 100;
                billing_address = quote.billingAddress();

                this.user = {
                    name: billing_address.firstname + ' ' + billing_address.lastname,
                    contact: billing_address.telephone,
                };

                if (!customer.isLoggedIn()) {
                    this.user.email = quote.guestEmail;
                }
                else {
                    this.user.email = customer.customerData.email;
                }

                this.isPaymentProcessing = $.Deferred();

                //console.log($.Deferred());
                // 
                $.when(this.isPaymentProcessing).done(
                    function () {

                        self.placeOrder();

                    }
                ).fail(
                    function (result) {
                        self.handleError(result);
                    }


                );

                self.getPhonepeOrderId();

                return;
            },

            getPhonepeOrderId: function () {
                
                
                var self = this;
                
                $.ajax({
                    type: 'POST',
                    url: url.build('phonepe/payment/order'),

                    /**
                     * Success callback
                     * @param {Object} response
                     */
                    success: function (response) {
                      
                        fullScreenLoader.stopLoader();
                        if (response.success) {
                            self.renderIframe(response);
                        } else {
                            self.isPaymentProcessing.reject(response.message);
                        }
                    },

                    /**
                     * Error callback
                     * @param {*} response
                     */
                    error: function (response) {
                       

                        fullScreenLoader.stopLoader();
                        self.isPaymentProcessing.reject(response.message);
                    }
                });
                
                return
                
                
               
            },


            renderIframe: function (data) {
                var self = this;
                RESEVATION_ID=data.RESEVATION_ID;
                temp_order_id = data.order_id;
                transaction_id=data.transaction_id;
                
                window.PhonePe.PhonePe.build(window.PhonePe.Constants.Species.web).then((sdk) => {

                    sdk.proceedToPay(data.RESEVATION_ID, "https://tyresnmore.com/").then((response) => {
                        self.checkStatus(data);
                    }).catch((err) => {
                      
                        fullScreenLoader.stopLoader();
                        self.isPaymentProcessing.reject(err);

                    });

                });

            },
           
            checkStatus:function(data){
                
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: url.build('phonepe/payment/webhook'),
                    data: { 'transaction_id':data.transaction_id,'temp_order_id':data.order_id} ,
                    success: function (response) {
                        
                        if(response.status == 'SUCCESS'){
                            self.placeOrder();
                        }
                        //window.location.href="https://tyres.clarksfield.com/order-cancel";
                        // fullScreenLoader.stopLoader();
                        // self.isPaymentProcessing.reject('order cancel');
                        
                    },
                    error: function (response) {
                        window.location.href="https://tyresnmore.com/order-cancel";
                        // fullScreenLoader.stopLoader();
                        // self.isPaymentProcessing.reject('order cancel');
                        // alert(JSON.stringify(response));

                 
                    }
                });
            return;
                
            },   
            
            

            getData: function () {
               
                return {
                    "method": this.item.method,
                    "po_number": null,
                    "additional_data": {
                        'RESEVATION_ID':RESEVATION_ID,
                        'temp_order_id':temp_order_id,
                        'transaction_id':transaction_id
                    }
                };
            }



        });
    }
);

window.onload = function() {
	jQuery("input[type='checkbox']").click();
};
