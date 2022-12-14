<!-- ==================== Car and Bike Section start=============== -->
<div class="car_bike_section">
    <div class="container">
      <div class="section_second">
      <div class="row">   
          <div class="col-md-5 pull-right">
<div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
</div>
            <div class="find_tyre_sec2">
              <div class="tyre_title" style=" background: #f2f2f2; text-align: center; ">
                <h2>Tyres fitted at your doorstep</h2>
                <p>In Hyderabad, Bangalore & Delhi NCR</p>
              </div>
          <p style="
      text-align: center;
      font-size: 17px;
      border-bottom: 1px solid #f3f3f3;
      padding: .6rem 0;
  ">Tyres home delivered in major cities in india
      </p>
              <div class="row">
                <div class="col-xs-12">
                  <div class="row brd_vichle_1">
                    <p>Search By</p>
                    <div class="col-xs-6">
                      <button data-mode-toggle data-mode="brand" class="vech_btn_1 active">Vehicle Brands</button>
                    </div>
                    <div class="col-xs-6">
                      <button data-mode-toggle data-mode="size" class="vech_btn_1">Tyres Size</button>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="brd_vichle_1 tt1 row">
                    <p>Tyres for?</p>
                    <div class="btn_second col-xs-6">
                      <button data-search-toggle data-state="46" id="bike46" class="vech_btn_2 active tt">Car</button>
                    </div>
                    <div class="btn_first col-xs-6">
                      <button data-search-toggle data-state="42" id="bike42" class="vech_btn_1 tt">Bike</button>
                    </div>
  
                  </div>
                </div>
              </div>
              <div class="col-md-12">
              <div class="select_brand_sec">
                  <label data-label="brand width">Select Brand</label>
                  <select data-selector="brand width"></select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="select_brand_sec">
                  <label data-label="model profile">Select Model</label>
                  <select data-selector="model profile"></select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="select_brand_sec">
                  <label data-label="variant rim">Select Variant</label>
                  <select data-selector="variant rim"></select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="find_tyre_btn" data-search-init>
                  <a data-search-init href="#">Find Tyres</a>
                </div>
              </div>
               <div class="col-md-12">
                <div class="expert_sec">
             <!--     <i class="fa fa-volume-control-phone expert" aria-hidden="true"></i> <a href="#">Talk to our tyres expert</a> -->
                </div>
              </div>
            </div>
          </div>
          <?php echo $this->getLayout()
                                ->createBlock('Magento\Cms\Block\Block')
                                ->setBlockId('buycarbike')
                                ->toHtml();
                                ?>
      </div>
      </div>
    </div>
  </div>
   <!-- ==================Car and Bike Section end================== -->
  <!-- =================How it work section start==================== -->
  <div class="hw_section">
      <?php echo $this->getLayout()
                                ->createBlock('Magento\Cms\Block\Block')
                                ->setBlockId('how_it_works')
                                ->toHtml();
                                ?>
  
  
  </div>
  
  <!-- =====================How it work section end ===================== -->
  
  <!-- =================Tyres brand section satrt================== -->
  <div class="tyrsbrand_section">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
              <div class="hw_tittle">
              <h1><span class="text_color">Tyres</span> By Brands</h1>
              </div>
              <div class="title_img"><img src="https://tyres.clarksfield.com/static/frontend/tyres/clarksfield/en_US/images/xline.png.pagespeed.ic.bs4QTBYEGv.webp"></div>
              </div>
              <ul class="tabs">
              <li class="car_bt"><a class="tab active" rel="#tabcontent1">Car Brands</a></li>
              <li class="bikes_bt"><a class="tab" rel="#tabcontent2">Bikes Brands</a></li>
              </ul>
              <div class="tab_content_container">
              <div id="tabcontent1" class="tab_content tab_content_active">
              <!--car phtml-->
              <div class="brd_col4 bbb_l_r">
               <?php echo $this->getLayout()->createBlock("Magento\Framework\View\Element\Template")->setTemplate("Magento_Theme::html/cars.phtml")->toHtml();?>
              </div>
              <!-- close section -->
              </div>
                <div id="tabcontent2" class="tab_content">
              <div class="brd_col4 bbb_l_r_1">
               <!--Bikes phtml-->
              <?php echo $this->getLayout()->createBlock("Magento\Framework\View\Element\Template")->setTemplate("Magento_Theme::html/bikes.phtml")->toHtml();?>
               <!-- close section -->
              </div>
              </div>
              </div>
              </div>
              </div>
              </div>
      </div>
  
  <!-- ================Tyres brand section end======================== -->
  
  <!-- ========================Top Selling Tyres======================= -->
  <div class="container-fluid">
      <div class="top-selling">
          <div class="container">
           <?php echo $this->getLayout()
                                ->createBlock('Magento\Cms\Block\Block')
                                ->setBlockId('top_seller')
                                ->toHtml();
                                ?>
  
          </div>
      </div>
  </div>
  <!-- ===================top selling tyres end================ -->
  <div class="tyrswiderange_section">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="hw_tittle">
                      <h1><span class="text_color">Our Wide Range</span> Of Tyres Brands</h1>
                  </div>
                  <div class="title_img">
                      <img src="<?php echo $this->getViewFileUrl('images/line.png'); ?>">
                  </div>
              </div>
             <?php echo $this->getLayout()->createBlock("Magento\Framework\View\Element\Template")->setTemplate("Magento_Theme::html/tyres.phtml")->toHtml();?>
          </div>
      </div>
  </div>
  <!-- ======================Try Our Tyer Decision Guide start==================== -->
  <div class="decision_guid_sec">
      <div class="container-fluid">
          <?php /*echo $this->getLayout()
                                ->createBlock('Magento\Cms\Block\Block')
                                ->setBlockId('services_features')
                                ->toHtml();*/
                                ?>
          <div class="row">
                <div class="hw_tittle">
                <h1><span class="text_color">TNM Tyre Care </span>Package</h1>
                <div class="title_img"><img src="https://tyres.clarksfield.com/static/frontend/tyres/clarksfield/en_US/images/xline.png.pagespeed.ic.bs4QTBYEGv.webp"></div>
                <div class="row">
                <div class="srvice_feature_sec">
                <div class="col-md-4 pdd_left">
                <div class="TY_image"><img src="https://tyres.clarksfield.com/static/frontend/tyres/clarksfield/en_US/images/Tyres.jpg"></div>
                </div>
                <div class="col-md-8">
                <div class="TY_care_package">
                <div class="tnm_tittle">
                <ul>
                <li>The TNM tyre care package saves you money. Get the maximum life from your car tyres.</li>
                </ul>
                </div>
                <div class="silver_section">
                <div class="silver_wrrap">
                <div class="silver_tittle">
                <h2>Silver</h2>
                <h3>???699/-</h3>
                </div>
                <div class="silver_text">
                <div class="stext_1">Doorstep Service</div>
                <div class="stext_2">1</div>
                </div>
                <div class="silver_text">
                <div class="stext_1">Transferable</div>
                <div class="stext_2">No.</div>
                </div>
                <div class="silver_text">
                <div class="stext_1">Duration</div>
                <div class="stext_2">6 Months</div>
                </div>
                <div class="silver_text">
                <div class="stext_1">Wheel Balancing</div>
                <div class="stext_2">Yes</div>
                </div>
                <div class="silver_text">
                <div class="stext_1">Tyre Rotation</div>
                <div class="stext_2">Yes</div>
                </div>
                <div class="silver_text">
                <div class="stext_1">Air Pressure Check</div>
                <div class="stext_2">Yes</div>
                </div>
                <?php
                  $id=2795;
                  $objectManager1 = \Magento\Framework\App\ObjectManager::getInstance();

                  $productHelper1 = $objectManager1->get('\Magento\Catalog\Model\Product');
                  // get product object if you are not having
                  $product1 = $productHelper1->load($id);
                  $listBlock1 = $objectManager1->get('\Magento\Catalog\Block\Product\ListProduct');
                 ?>
                <!-- <div class="silver_button1"><a class="silver_btn1" href="<?php  //echo $listBlock1->getAddToCartUrl($product1); ?>">Buy Silver Pack</a></div> -->
                 <form data-role="tocart-form" action="<?php  echo $listBlock1->getAddToCartUrl($product1); ?>" method="post"> 
                  <?php echo $block->getBlockHtml('formkey')?>
                      <button type="submit" title="Buy Gold Pack" class="action tocart silver_btn12 silver_button12">
                          <span>Buy Silver Pack</span>
                      </button> 
               </form>
                </div>
                </div>
                <div class="silver_wrrap1">
                <div class="silver_tittle1">
                <h2>Gold</h2>
                <h3>???1,399/-</h3>
                </div>
                <div class="silver_text1">
                <div class="stext_11">Doorstep Service</div>
                <div class="stext_22">3</div>
                </div>
                <div class="silver_text">
                <div class="stext_11">Transferable</div>
                <div class="stext_22">Yes</div>
                </div>
                <div class="silver_text">
                <div class="stext_11">Duration</div>
                <div class="stext_22">1 Year</div>
                </div>
                <div class="silver_text">
                <div class="stext_11">Wheel Balancing</div>
                <div class="stext_22">Yes</div>
                </div>
                <div class="silver_text">
                <div class="stext_11">Tyre Rotation</div>
                <div class="stext_22">Yes</div>
                </div>
                <div class="silver_text">
                <div class="stext_11">Air Pressure Check</div>
                <div class="stext_22">Yes</div>
                </div>
                <?php
                  $id1=2796;
                  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                  $productHelper = $objectManager->get('\Magento\Catalog\Model\Product');
                  // get product object if you are not having
                  $product = $productHelper->load($id1);
                  $listBlock = $objectManager->get('\Magento\Catalog\Block\Product\ListProduct');
                 ?>
               <!-- <a class="silver_btn12" href="<?php  //echo $listBlock->getAddToCartUrl($product); ?>">Buy Gold Pack</a> -->
                  <form data-role="tocart-form" action="<?php echo $listBlock->getAddToCartUrl($product); ?>" method="post"> 
                  <?php echo $block->getBlockHtml('formkey')?>
                      <button type="submit" title="Buy Gold Pack" class="action tocart silver_btn12 silver_button12">
                          <span>Buy Gold Pack</span>
                      </button> 
               </form>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
      </div>
  </div>
  
  
  <!-- ===================Try Our Tyer Decision Guide end====================== -->
  <!-- ===========================what our custmer speek====================== -->
  <div class="container-fluid">
    <div class="sustom_spk_sec">
    <div class="container">
      <div class="cust_speak">
        <div class="cust_spek_title">
          <h1><span>Customers</span> Speak</h1>
        </div>
        <div class="image_title_botom">
          <img src="<?php echo $this->getViewFileUrl('images/line.png'); ?>">
        </div>
      <!-- <?php //echo $this->getLayout()->createBlock("Clarksfield\Customersspeak\Block\CustomersspeakListData")->setTemplate("Magento_Theme::html/video/list.phtml")->toHtml();?> -->
      </div>
      <div class="cust_speak_bottom">
        <?php echo $this->getLayout()->createBlock("Tyresclarksfield\Testimonials\Block\TestimonialsListData")->setTemplate("Magento_Theme::html/testimonials/list.phtml")->toHtml();?>
        
      </div>
  
    </div>
  </div>
  </div>
  <!-- ======================page bottom======================= -->
  <div class="container-fluid">
     <div class="page-bottom">
        <div class="container">
           <div class="row">
              <div class="col-md-6">
                 <h1 class="page-bottom_title ff_text_new">Faq</h1>
                 <div class="accordion">
                    
                      <?php
                       echo $this->getLayout()->createBlock("Tyres\Faq\Block\FaqListData")->setTemplate("Magento_Theme::html/Faq/list.phtml")->toHtml();
                       ?>
                       
                    </div>
                 </div>
              <div class="col-md-6">
                 <h1 class="page-bottom_title">Our Blog</h1>
                 <div class="blog-section">
                     <?php echo $this->getLayout()->createBlock("Mageplaza\Blog\Block\Post\Listpost")->setTemplate("Magento_Theme::html/post/list.phtml")->toHtml();?>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <?php
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
	$baseurl=$storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
	   ?>
   <input type="hidden" value="<?php echo $baseurl; ?>" id="baseUrl"/> 
  <!-- ================== Shop By Brand Section start ============== -->
  
  
  <!-- ================== Shop By Brand Section end ============== -->
 <!--  <script>
  require(["jquery"],function($){
  $(document).ready(function(){
      $(".tabs li a").click(function() {
  
          // Active state for tabs
          $(".tabs li a").removeClass("active");
          $(this).addClass("active");
  
          // Active state for Tabs Content
          $(".tab_content_container > .tab_content_active").removeClass("tab_content_active").fadeOut(200);
          $(this.rel).fadeIn(500).addClass("tab_content_active");
      });
  });
  /*$('.tt').click(function() {
    $('.tt').removeClass('active')
    $(this).addClass('active')
  });*/
  $(document).ready(function() {
  $("#bike42").click(function () {
      $("#bike46").removeClass("active");
      // $(".tab").addClass("active"); // instead of this do the below
      $("#bike42").addClass("active");
    });
  $("#bike46").click(function () {
      $("#bike42").removeClass("active");
      // $(".tab").addClass("active"); // instead of this do the below
      $("#bike46").addClass("active");
    });
  
  });
  });
  </script>
  
  <style>
      div#tabcontent2 {
      display: none;
  }
  </style>

 <?php /* echo $this->getLayout()
                                ->createBlock('Magento\Cms\Block\Block')
                                ->setBlockId('select_city')
                                ->toHtml();
  */                       ?>
<script>
require(['jquery','js/select2'], (function($) {
	console.log($("#baseUrl").val());
    var local = false;
    var availableModes = {
	"brand": "brand",
	"size": "size"
    };
    var searchMode;
    var brandOrWidthSelector, modelOrProfileSelector, variantOrRimSelector;
    var currentToggleState, _selected, _id, _level, _globalResponse;

    function __ddmap(o) {
	var obj = {
	    id: o.entity_id,
	    text: o.name
	};
	return obj;
    }

    function __find(id) {
	return function(o) {
	    return o.entity_id == id;
	};
    }

    function __formatForSize(level, path, entities) {
        return function(obj) {
            var id = obj[entities[level]];
            var nextPath = path + "/" + id;

            // Get non numerical keys
            var children = Object.keys(obj)
                .filter(function(k) {
                    return !isNaN(parseInt(k));
                })
                .map(function(k) {
                    return obj[k];
                });

            return {
                entity_id: id,
                name: obj.label,
                path: nextPath,
                is_active: "1",
                is_anchor: obj.url ? "1" : "0",
                request_path: obj.url || null,
                childes: children.map(__formatForSize(level + 1, nextPath, entities))
            };
        };
    }

    function formatData(data) {
        if (searchMode === availableModes.brand) {
            return data;
        } else if (searchMode === availableModes.size) {
            var path = "1/375/" + currentToggleState.toString();
            var ientity = currentToggleState == 42 ? "bikeid" : "carid";
            var name = currentToggleState == 42 ? "Bike Search" : "Car Search";
            var wrapper = [{
                entity_id: currentToggleState.toString(),
                name: name,
                path: path,
                is_active: "1",
                is_anchor: "1",
                request_path: "",
                childes: data.map(
                    __formatForSize(0, path, [ientity, "profileid", "rimid"])
                )
            }];
            return wrapper;
        }
    }
    
    function _init(response) {
	if (typeof response === "string") {
	    response = formatData(JSON.parse(response));
	    console.log(response);
	}
	_globalResponse = response;
	_level = 0;
	refresh();
    }

    function fromSelected(level) {
	var ps = _selected.path.split("/");
	ps.shift();
	ps.shift();
	ps.shift();
	var e = _globalResponse.find(__find(currentToggleState));
	for (var i = 0; i < level; i++) {
	    e = e.childes.find(__find(ps[i]));
	}
	return e;
    }

    function switchMode(el) {
	var placeholder = "";
	var mode = el.data('selector');
	switch (mode) {
	    case "brand width":
		if (searchMode === availableModes.brand) {
		    placeholder = "Select Brand";
		} else if (searchMode === availableModes.size) {
		    placeholder = "Select Width";
		}
		break;
	    case "model profile":
		if (searchMode === availableModes.brand) {
		    placeholder = "Select Model";
		} else if (searchMode === availableModes.size) {
		    placeholder = "Select Profile";
		}
		break;
	    case "variant rim":
		if (searchMode === availableModes.brand) {
		    placeholder = "Select Variant";
		} else if (searchMode === availableModes.size) {
		    placeholder = "Select Rim";
		}
		break;
	}
	$('[data-label="' + mode + '"]').html(placeholder);
	el.html("").select2({
	    placeholder: placeholder,
           minimumResultsForSearch: -1
	});
	return placeholder;
    }

    function initSelect(el) {
	var placeholder = switchMode(el);
	return function(_e) {
	    var entry = _e.childes.map(__ddmap);
	    entry.unshift({
		id: "",
		text: ""
	    });
	    el.html("").select2({
		data: entry,
		placeholder: placeholder,
		minimumResultsForSearch: -1
	    });
	    // Trigger Change Event
	    el.trigger("change");
	};
    }

    function refresh() {
	_selected = _globalResponse.find(__find(currentToggleState));
	if (_selected !== undefined) {
	    initSelect(brandOrWidthSelector)(_selected);
	    initSelect(modelOrProfileSelector);
	    initSelect(variantOrRimSelector);
	    _level = 0;
	}
    }

    function submitSearch(e) {
	console.log('submitSearch', e);
	try {
	    e.preventDefault();
	    e.stopPropagation();
	} catch(err) {
	    console.error(err);
	}

	var next = undefined;

	if (_id !== null) {
	    next = _selected.childes.find(__find(_id));
	} else {
	    next = _selected;
	}
	if (next) {
	    window.location.href = next.request_path;
	}
    }

    function toggleState(e) {
	console.log('toggleState', e);
	try {
	    e.preventDefault();
	    e.stopPropagation();
	} catch(err) {
	    console.error(err);
	}
	currentToggleState = $(this).data("state");
	$('[data-state-toggle]').removeClass('active');
	$(this).addClass('active');
	if (searchMode === availableModes.brand) {
	    refresh();
	} else {
	    getData()
		.then(_init);
	}
    }

    function updateSelector(level, nselector) {
	return function(e) {
	    try {
		e.preventDefault();
		e.stopPropagation();
	    } catch {}
	    console.log(_selected);
	    var current = $(this).val();

	    if (current === "") {
		if (nselector !== null && nselector !== undefined) {
		    switchMode(nselector);
		    // $(nselector)
		    //     .html("")
		    //     .select2({
		    //         placeholder: ""
		    //     });
		}
		return;
	    }
	    var next;
	    if (level == _level) {
		next = _selected;
	    } else {
		next = fromSelected(level);
	    }
	    next = next.childes.find(__find(current));

	    if (next !== undefined) {
		_id = next.childes.length > 0 ? current : null;
		_selected = next;
		_level++;
		if (nselector !== null) {
		    initSelect(nselector)(next);
		    console.log(next);
		}
	    } else {
		console.log("Something amiss");
	    }
	};
    }

    function toggleSearchMode(e) {
	console.log('toggleSearchMode',e);
	try {
	    e.preventDefault();
	    e.stopPropagation();
	} catch(err) {
	    console.error(err);
	}
	searchMode = $(this).data("mode");
        $('[data-mode-toggle]').removeClass('active');
	$(this).addClass('active');
	getData()
	    .then(_init);
    }

    function getPath() {
	console.log(currentToggleState);
	if (currentToggleState === 46) {
	    return "Carsearch";
	} else {
	    return "Bikesearch";
	}
    }

    function getData() {
      	return new Promise(function(resolve, reject) {
      	    var url;
      	    var urlPrefix = window.location.origin;
      	    if (local) {
      		/*urlPrefix = "https://tyres.clarksfield.com"*/
              urlPrefix = "https://tyres.clarksfield.com"
      	    }
      	    if (searchMode === availableModes.brand) {
      		url = urlPrefix + "/tyreadvanceserch/index/parentcetegory";
      	    } else if (searchMode === availableModes.size) {
      		url = urlPrefix + "/tyreadvanceserch/index/"+getPath();
      	    } else {
      		reject(new Error("No Mode Available for " + searchMode));
      	    }

      	    $.get(url).then(resolve);
      	});
    }

    // Script Entry Point

    // Dropdowns with Select2
    $("[data-selector]").select2();
    brandOrWidthSelector = $('[data-selector="brand width"]').first();
    modelOrProfileSelector = $('[data-selector="model profile"]').first();
    variantOrRimSelector = $('[data-selector="variant rim"]').first();

    // Add Event Listener on Dropdowns
    brandOrWidthSelector.on(
        "change",
        updateSelector(0, modelOrProfileSelector)
    );
    modelOrProfileSelector.on(
        "change",
        updateSelector(1, variantOrRimSelector)
    );
    variantOrRimSelector.on("change", updateSelector(2, null));

    // Toggle Event Listeners
    $("[data-mode-toggle]").on("click", toggleSearchMode);
    $("[data-search-toggle]").on("click", toggleState);

    // Configure Search Button
    $("[data-search-init]").on("click", submitSearch);

    // Set search Mode
    searchMode = $("[data-mode-toggle].active")
        .first()
        .data("mode");
    // Set current State
    currentToggleState = $("[data-search-toggle].active")
        .first()
        .data("state");

    getData()
        .then(_init);
}));



/* require(['jquery','js/select2'], (function($) {
    var modalObj = $('#selectCityModal');
    function openModal() {
        modalObj.css({ display:'block' })
        setTimeout(function() {
            modalObj.addClass('in');
        }, 200);
    }

    function closeModal() {
        modalObj.removeClass('in');
        setTimeout(function() {
            modalObj.css({display:'none'});
        }, 200);
    }

    $(function() {
        modalObj = $('#selectCityModal');
        openModal();
    });
}))();
 */

jQuery('#enquireform').click(function() {
                    jQuery('.popup-right').animate({"margin-right": '220'});
                    jQuery('#pop_button-right').animate({"margin-right": '280'});
    });

</script> -->
<script>
require(['jquery','js/select2'], (function($) {
    console.log($("#baseUrl").val());
    var local = false;
    var availableModes = {
    "brand": "brand",
    "size": "size"
    };
    var searchMode;
    var brandOrWidthSelector, modelOrProfileSelector, variantOrRimSelector;
    var currentToggleState, _selected, _id, _level, _globalResponse;
    function __ddmap(o) {
    var obj = {
        id: o.entity_id,
        text: o.name
    };
    return obj;
    }
    function __find(id) {
    return function(o) {
        return o.entity_id == id;
    };
    }
    function __formatForSize(level, path, entities) {
        return function(obj) {
            var id = obj[entities[level]];
            var nextPath = path + "/" + id;
            // Get non numerical keys
            var children = Object.keys(obj)
                .filter(function(k) {
                    return !isNaN(parseInt(k));
                })
                .map(function(k) {
                    return obj[k];
                });
            return {
                entity_id: id,
                name: obj.label,
                path: nextPath,
                is_active: "1",
                is_anchor: obj.url ? "1" : "0",
                request_path: obj.url || null,
                childes: children.map(__formatForSize(level + 1, nextPath, entities))
            };
        };
    }
    function formatData(data) {
        if (searchMode === availableModes.brand) {
            return data;
        } else if (searchMode === availableModes.size) {
            var path = "1/375/" + currentToggleState.toString();
            var ientity = currentToggleState == 42 ? "bikeid" : "carid";
            var name = currentToggleState == 42 ? "Bike Search" : "Car Search";
            var wrapper = [{
                entity_id: currentToggleState.toString(),
                name: name,
                path: path,
                is_active: "1",
                is_anchor: "1",
                request_path: "",
                childes: data.map(
                    __formatForSize(0, path, [ientity, "profileid", "rimid"])
                )
            }];
            return wrapper;
        }
    }
    function _init(response) {
    if (typeof response === "string") {
        response = formatData(JSON.parse(response));
        console.log(response);
    }
    _globalResponse = response;
    _level = 0;
    refresh();
    }
    function fromSelected(level) {
    var ps = _selected.path.split("/");
    ps.shift();
    ps.shift();
    ps.shift();
    var e = _globalResponse.find(__find(currentToggleState));
    for (var i = 0; i < level; i++) {
        e = e.childes.find(__find(ps[i]));
    }
    return e;
    }
    function switchMode(el) {
    var placeholder = "";
    var mode = el.data('selector');
    switch (mode) {
        case "brand width":
        if (searchMode === availableModes.brand) {
            placeholder = "Select Brand";
        } else if (searchMode === availableModes.size) {
            placeholder = "Select Width";
        }
        break;
        case "model profile":
        if (searchMode === availableModes.brand) {
            placeholder = "Select Model";
        } else if (searchMode === availableModes.size) {
            placeholder = "Select Profile";
        }
        break;
        case "variant rim":
        if (searchMode === availableModes.brand) {
            placeholder = "Select Variant";
        } else if (searchMode === availableModes.size) {
            placeholder = "Select Rim";
        }
        break;
    }
    $('[data-label="' + mode + '"]').html(placeholder);
    el.html("").select2({
        placeholder: placeholder,
           minimumResultsForSearch: -1
    });
    return placeholder;
    }
    function initSelect(el) {
    var placeholder = switchMode(el);
    return function(_e) {
        var entry = _e.childes.map(__ddmap);
        entry.unshift({
        id: "",
        text: ""
        });
        el.html("").select2({
        data: entry,
        placeholder: placeholder,
        minimumResultsForSearch: -1
        });
        // Trigger Change Event
        el.trigger("change");
    };
    }
    function refresh() {
    _selected = _globalResponse.find(__find(currentToggleState));
    if (_selected !== undefined) {
        initSelect(brandOrWidthSelector)(_selected);
        initSelect(modelOrProfileSelector);
        initSelect(variantOrRimSelector);
        _level = 0;
    }
    }
    function submitSearch(e) {
    console.log('submitSearch', e);
    try {
        e.preventDefault();
        e.stopPropagation();
    } catch(err) {
        console.error(err);
    }
    var next = undefined;
    if (_id !== null) {
        next = _selected.childes.find(__find(_id));
    } else {
        next = _selected;
    }
    if (next) {
        window.location.href = next.request_path;
    }
    }
    function toggleState(e) {
    console.log('toggleState', e);
    try {
        e.preventDefault();
        e.stopPropagation();
    } catch(err) {
        console.error(err);
    }
    currentToggleState = $(this).data("state");
    $('[data-state-toggle]').removeClass('active');
    $(this).addClass('active');
    if (searchMode === availableModes.brand) {
        refresh();
    } else {
        getData()
        .then(_init);
    }
    }
    function updateSelector(level, nselector) {
    return function(e) {
        try {
        e.preventDefault();
        e.stopPropagation();
        } catch {}
        console.log(_selected);
        var current = $(this).val();
        if (current === "") {
        if (nselector !== null && nselector !== undefined) {
            switchMode(nselector);
            // $(nselector)
            //     .html("")
            //     .select2({
            //         placeholder: ""
            //     });
        }
        return;
        }
        var next;
        if (level == _level) {
        next = _selected;
        } else {
        next = fromSelected(level);
        }
        next = next.childes.find(__find(current));
        if (next !== undefined) {
        _id = next.childes.length > 0 ? current : null;
        _selected = next;
        _level++;
        if (nselector !== null) {
            initSelect(nselector)(next);
            console.log(next);
        }
        } else {
        console.log("Something amiss");
        }
    };
    }
    function toggleSearchMode(e) {
    console.log('toggleSearchMode',e);
    try {
        e.preventDefault();
        e.stopPropagation();
    } catch(err) {
        console.error(err);
    }
    searchMode = $(this).data("mode");
        $('[data-mode-toggle]').removeClass('active');
    $(this).addClass('active');
    $('#overlay').fadeIn().delay(2000).fadeOut();
    getData()
        .then(_init);
    }
    function getPath() {
    console.log(currentToggleState);
    if (currentToggleState === 46) {
        return "Carsearch";
    } else {
        return "Bikesearch";
    }
    }
    function getData() {
        return new Promise(function(resolve, reject) {
            var url;
            var urlPrefix = window.location.origin;
            if (local) {
            /*urlPrefix = "https://tyres.clarksfield.com"*/
              urlPrefix = "https://tyres.clarksfield.com"
            }
            if (searchMode === availableModes.brand) {
            url = urlPrefix + "/tyreadvanceserch/index/parentcetegory";
            } else if (searchMode === availableModes.size) {
            url = urlPrefix + "/tyreadvanceserch/index/"+getPath();
            } else {
            reject(new Error("No Mode Available for " + searchMode));
            }
            $.get(url).then(resolve);
        });
    }
    // Script Entry Point
    // Dropdowns with Select2
    $("[data-selector]").select2();
    brandOrWidthSelector = $('[data-selector="brand width"]').first();
    modelOrProfileSelector = $('[data-selector="model profile"]').first();
    variantOrRimSelector = $('[data-selector="variant rim"]').first();
    // Add Event Listener on Dropdowns
    brandOrWidthSelector.on(
        "change",
        updateSelector(0, modelOrProfileSelector)
    );
    modelOrProfileSelector.on(
        "change",
        updateSelector(1, variantOrRimSelector)
    );
    variantOrRimSelector.on("change", updateSelector(2, null));
    // Toggle Event Listeners
    $("[data-mode-toggle]").on("click", toggleSearchMode);
    $("[data-search-toggle]").on("click", toggleState);
    // Configure Search Button
    $("[data-search-init]").on("click", submitSearch);
    // Set search Mode
    searchMode = $("[data-mode-toggle].active")
        .first()
        .data("mode");
    // Set current State
    currentToggleState = $("[data-search-toggle].active")
        .first()
        .data("state");
    getData()
        .then(_init);
}));
/* require(['jquery','js/select2'], (function($) {
    var modalObj = $('#selectCityModal');
    function openModal() {
        modalObj.css({ display:'block' })
        setTimeout(function() {
            modalObj.addClass('in');
        }, 200);
    }
    function closeModal() {
        modalObj.removeClass('in');
        setTimeout(function() {
            modalObj.css({display:'none'});
        }, 200);
    }
    $(function() {
        modalObj = $('#selectCityModal');
        openModal();
    });
}))();
 */


jQuery('#clickForm').click(function() {
                    jQuery('.popup-right').animate({"margin-right": '220'});
                    jQuery('#pop_button-right').animate({"margin-right": '280'});
    });
</script>


<style>
  .silver_button12 {
    width: 92%;
    text-align: center;
    padding: 8px;
    background-color: #d31e23;
    cursor: pointer;
    margin: 0% 4%;
    margin-top: 20px;
    box-shadow: none !important;
    border-color: #d31e23;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
}
 .silver_button12:hover {
 background-color: #d31e23;
 border-color: #d31e23;
 color: #fff;
}
</style>

<style>

.center-align {
    text-align: center;
}
.modal-content{
   position: relative;
    background-color: #ffffff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
}
@media (min-width: 768px){
  .modal-content {
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
}
}


@media (min-width: 320px) and (max-width: 480px) {
.citycolumn img {
 /*   height: 75px;*/
}
}

.modal-header {
    padding: 15px;

}
.modal-title {
    margin: 0;
    line-height: 1.42857143;
font-weight: bold;
}

.modal-body {
    position: relative;
    padding: 15px;
}
.modal-footer {
    padding: 15px 15px 0px 15px;
    text-align: right;

}
.citycolumn center{
    border: 1px solid transparent;
    padding: 0 10px;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
}
.modal-footer img{
border-radius: 0px 0px 25px 25px;
}

.citycolumn center a{
color: #000000;
}

.card{
margin-bottom: 10px;
}

a.card-anchor {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.zero-left-right-padding {
    padding-left: 0px;
    padding-right: 0px;
}

#selectCityModal .modal-content {
    border-radius: 25px !important;
}

@media (min-width: 768px){
.mycitymodal .modal-dialog{
    width: 900px !important;
    margin: 30px auto;
}
}

</style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "When should I change my car tyres ?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "A Tread wear indicator is a block of rubber (click to view) in the grooves of the tyre tread.If your tyre tread has worn out uptp or below indicator tyres should be changed.

In case your tyres have got any cuts or damage, uneven wearing out, bumps , you should change them.

In any case you should not use tyres beyond 5 years from the manufacturing year  indicated on the tyre even though they may look in good condition."
    }
  },{
    "@type": "Question",
    "name": "What is the size of the tyre for my car?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Go to the search panel above and input your car brand and model.You will get a list of models to choose from , click on your car model and you will reach the page with details of tyre sizes that fit in this car model.

Question: Is it safe to buy tyres online?

We don???t know about other online tyre sellers, but we are sure about tyresnmore.com ??? IT IS SAFE.

PAY ON DELIVERY , DOORSTEP FITMENT , HOME DELIVERY.

 To see TESTIMONIALS of verified purchasers of tyres from Tyresnmore.com ...read more"
    }
  },{
    "@type": "Question",
    "name": "Which is the best tyre for my car?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Go to the search panel above and input your car brand and model.

You will get a list of models to choose from , click on your car model and you will reach the page with details of features of best  tyres for your car."
    }
  },{
    "@type": "Question",
    "name": "How to take care of car tyres?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Get wheel alignment and balancing at least once a year or at every 5,000 kilometres , whichever is earlier.

Keep your tyres inflated at levels recommended by the car or bike manufacturer.

Drive carefully , so that you use your brakes only when required.

View details of Tyresnmore.com tyre service package. https://tyresnmore.com/all/tyre-care-service-packages"
    }
  },{
    "@type": "Question",
    "name": "Which is the cheapest tyre for my car?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "You will get a list of models to choose from , click on your car model and you will reach the page which features the cheapest  tyre for your car."
    }
  },{
    "@type": "Question",
    "name": "Can I get tyres fitted at home?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Tyresnmore.com gives doorstep fitment Bangalore , Delhi, Faridabad, Noida, Gurgaon and Hyderabad.

For all other cities we will ship the tyres to your address through FEDEX or another reliable courier."
    }
  },{
    "@type": "Question",
    "name": "When will my order for tyres reach my location?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "We have experts with tyreOB changing equipment in the Tyresnmore Vans and they will reach your location , in Hyderabad , Bangalore , Delhi NCR to change tyres at your doorstep.

Orders placed before 3 PM will be fulfilled today* Orders placed after 3 PM will be fulfilled tomorrow *The order fulfillment on same day is subject to availability of tyres in our warehouse. Our team will call you to fix an appointment for changing tyres at your location.

For cities other than those mentioned above , our tyre experts will inform you about the time of delivery and additional shipping charges if any."
    }
  },{
    "@type": "Question",
    "name": "How long does it take to change tyres?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Once our team reaches your location we need parking space for our van next to your vehicle , we have the equipment to change 1 tyre in 20 to 30 minutes and up to 4 tyres in 30 to 60 minutes"
    }
  },{
    "@type": "Question",
    "name": "What are the Payment options , can I pay on delivery or through EMIs?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "You can:

Pay on delivery *

Easy EMI available

Pay 100 % online now

*TnM reserves the right to ask for partial or full advance payment for any orders"
    }
  },{
    "@type": "Question",
    "name": "Will the tyre experts come to my location with debit/credit card machine , in case I am paying on delivery?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Yes the tyre experts will come with debit/credit card machine to your location to enable you to make payment,alternatively you can also pay via cash on delivery. Tyresnmore online private ltd. reserves the right to receive partial or full advance payment for any orders."
    }
  }]
}
</script>
<style>
#overlay {
       background: #ffffff;
    color: #666666;
    position: absolute;
    height: 100%;
    width: 94%;
    z-index: 5000;
    top: 0;
    border-radius: 6px;
    left: 15px;
    bottom: 0;
    opacity: .80;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.spinner {
    margin: 0 auto;
    height: 64px;
    width: 64px;
    animation: rotate 0.8s infinite linear;
    border: 5px solid firebrick;
    border-right-color: transparent;
    border-radius: 50%;
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

