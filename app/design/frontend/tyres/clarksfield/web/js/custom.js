define('jquery', function($) {
	$(document).ready(function(){
    var priceDomain = "";
	    let removeSpaceFromMainPrice = function (price) {
            priceDomain = ""+price.charAt(0);
            return price.substr(1);
    }
    let removeSpaceFromCustomPrice = function (price) {
        return price.substr(3);
    }
    let generateText = function (price) {
            return priceDomain+" "+parseFloat(price).toFixed(2);
    }
        $.fn.changePrice = function(){
            try{
                const theElements = document.getElementsByClassName("price-notice");
                const productPricewithcomma = removeSpaceFromMainPrice(document.getElementsByClassName("price")[0].innerText);
		const productPricee = productPricewithcomma.replace(/,/g, '');
		const productPrice = parseFloat(productPricee);
                for(let i=0;i<theElements.length;i++){
                    theElements[i].innerText = generateText((parseFloat(removeSpaceFromCustomPrice(theElements[i].innerText)) + productPrice));
                }
		      elementing = jQuery('.options-list').find('span:first');
        elementing.append('<span class="price-notice">₹'+productPricee+' </span>');
    a = jQuery('.options-list').find('input:first');
        a.prop("checked", true);

            }
            catch (e) {
                console.log(e);
            }
        }
		   });
//    let removeSpaceFromMainPrice = function (price) {
//            priceDomain = ""+price.charAt(0);
//            return price.substr(1);
//    }
//    let removeSpaceFromCustomPrice = function (price) {
//        return price.substr(3);
//    }
//    let generateText = function (price) {
//            return priceDomain+" "+parseFloat(price).toFixed(2);
//    }
    }(jQuery)
);
