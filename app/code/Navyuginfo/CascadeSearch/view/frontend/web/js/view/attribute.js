define(
	[
		'jquery',
		'ko',
		'uiComponent',
	],
	function ($, ko, component) {
		"use strict";


		return component.extend({

			initialize: function () {
				this._super();
				this.attributeSet = ko.observableArray(this.attributeSet);
				this.firstDropDownAttributes = this.filterAttributes()
				this.secondDropDownAttributes = ko.observableArray([]);
				this.thirdDropDownAttributes = ko.observableArray([]);
				this.selectedAttribute1 = ko.observable();
				this.selectedAttribute2 = ko.observable();
				this.selectedAttribute3 = ko.observable();

				var self = this;

				//select attribute search tab if attribute codes are present as parameters in url.
				if(this.tabIsSelected)
				{
					jQuery('.'   +  this.liClass  +  ' a[href= '+  this.tab  +   ']').tab('show');

				}

				if(this.changePinTab)
				{

					jQuery('.'   +  this.pinLiClass  +  ' a[href= '+  this.pinTab  +   ']').tab('show');

					this.selectedAttribute1 = ko.observable(this.preSelectedAttribute1);
					this.selectedAttribute2 = ko.observable(this.preSelectedAttribute2);
					this.selectedAttribute3 = ko.observable(this.preSelectedAttribute3);

				}


				// hook when attribute 1 is selected
				ko.computed(function(){

					var selectedAttribute1 = this.selectedAttribute1();

					self.secondDropDownAttributes([]);
					self.thirdDropDownAttributes([]);

					if(selectedAttribute1 != null)
					{
						var dropdownValues = self.filterAttributes(selectedAttribute1);
						self.secondDropDownAttributes(dropdownValues);
					}


				}, this);

				// hook when attribute 2 is selected
				ko.computed(function(){
					var selectedAttribute1 = this.selectedAttribute1();
					var selectedAttribute2 = this.selectedAttribute2();

					self.thirdDropDownAttributes([]);

					if(selectedAttribute2 != null)
					{
						var dropdownValues = self.filterAttributes(selectedAttribute1, selectedAttribute2);
						self.thirdDropDownAttributes(dropdownValues);
					}
					
				}, this);


			},


			filterAttributes: function(attribute1, attribute2){
				var self = this;

				//filter attributes
				var filteredAttributes = ko.utils.arrayFilter(this.attributeSet(), function(item) {
		            
		            if(attribute2 != null)
		            	return item.attribute_1.id == attribute1 && item.attribute_2.id == attribute2;
		            else if(attribute1!=null)
		            	return item.attribute_1.id == attribute1;

		            return true
		        });

				// get unique
				var uniqueAttributes = ko.dependentObservable(function() {

					var attributes = ko.utils.arrayMap(filteredAttributes, function(item) {
						if(attribute2 != null)
							return item.attribute_3;
						else if(attribute1!=null)
							return item.attribute_2;

						return item.attribute_1;

					});
					var seen = [];
					return attributes.filter(function(item) {
						return seen.indexOf(item.id) == -1 && seen.push(item.id) && item.id != null;
					});
				});

				//return sorted list
				return uniqueAttributes().sort(function (l, r) { 
					return parseInt(l.value) > parseInt(r.value) ? 1 : -1 });

			},


			showSearchResults: function(){

				window.location.href = this.storeUrl+"catalogsearch/advanced/result/?"+ this.attributeCode1 +"=" + this.selectedAttribute1() + "&" + this.attributeCode2 + "=" + this.selectedAttribute2() + "&" + this.attributeCode3 + "=" + this.selectedAttribute3();

			},

			defaults: {
				template: 'Navyuginfo_CascadeSearch/widget/search',
			},
		});
	}
);
