define(
	[
		'jquery',
		'ko',
		'uiComponent',
	],
	function ($, ko, component) {
		"use strict";

		var self = this;

		return component.extend({

			self: this,

			initialize: function () {
				this._super();
				this.showLoader = ko.observable(false);
				this.manufactures = ko.observableArray();
				this.selectedManufacturer = ko.observable();
				this.models = ko.observableArray([]);
				this.selectedModel = ko.observable();
				
				var self = this;

				if(this.changePinTab)
				{
					jQuery('.'   +  this.liClass  +  ' a[href= '+  this.pinTab  +   ']').tab('show');

				}

				// hook when manufacturer is selected
				ko.computed(function(){

					var manufacturerId = this.selectedManufacturer();
					self.models([]);
					if(manufacturerId != null)
					{	
						if(self.preSelectedModel == null)
							self.showLoader(true);

						self.populateModels(manufacturerId).then(
							function(response){
								self.models(response["subcategories"]);

								if(self.changePinTab)
									self.selectedModel(self.preSelectedModel);
								self.showLoader(false);
							});
					}else
						self.models([]);
					
				}, this);


			},

			populateModels: function(manufacturerId){
				var data = {categoryId : manufacturerId};
				var self = this;
				return $.post(this.storeUrl+"cascadesearch/category/displaychildren", data);           
			},

			showSearchResults: function(){
				var record = this.getById(this.models(), this.selectedModel());
				window.location.href = record["URL"];

			},

			selectPreSelectedValue: function(option, item){

				if(this.changePinTab)
					this.selectedManufacturer(this.preSelectedManufacturer);
			}
			,
		    getById: function(items, id) {
		        if(!id) {
		            return [];
		        }
		        
		        var result = ko.utils.arrayFirst(items, function(item) {
		            return item.id === id;
		        });
		        
		        return result;
		    },


			defaults: {
				template: 'Navyuginfo_CascadeSearch/widget/search',
			},
		});
	}
);
