/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'Magento_Checkout/js/model/totals',
	'jquery',
	'Magento_Ui/js/modal/modal',
	'mage/url'
], function (Component, totals, $, modal, url) {
    'use strict';

    return Component.extend({
        isLoading: totals.isLoading,
		
    getPopUp: function(){
			var option = {
			type: 'popup',
			responsive: true,
			innerScroll: true,
			modalClass: 'emi-details-modal',
			buttons: [{
				text: $.mage.__('Continue'),
				class: 'emi-pop',
				click: function () {
					this.closeModal();
				}
			}]
		}
			var popup = modal(option, $('#popup-mpdal'));
			$('#popup-mpdal').modal('openModal');
			$("#pdp-emi").on('click',function(){
				$('#popup-mpdal').modal('openModal');
			});
		},
		
		/**
         * @return {Number}
         */
        getGrandTotal: function () {
			var grandTotal = parseFloat(totals.getSegment('grand_total').value);
			var pricedata = {'totalprice':grandTotal};
			url.setBaseUrl(BASE_URL);
			var linkUrl = url.build('catlog/index/index');
			if(grandTotal>0){
				$.ajax({
					type: "POST",
					url: linkUrl,
					data:pricedata, 
					success: function(data){
						$('#popup-mpdal').html(data.html);
						$('#emi_starting_from').html(data.emi);
					}
				});
			}
        }
	});
});

