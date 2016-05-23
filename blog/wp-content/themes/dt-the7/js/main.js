// additional scripts
jQuery(document).ready(function($) {

	$('.no-touch .trigger-first-post-pp').on('click', function(e) {
		e.preventDefault();

		var $this = $(this),
			$postContainer = $this.parents('article.post').first(),
			$firstPpAnchor = $postContainer.find('a[data-pp^="prettyPhoto"]').first();

		$firstPpAnchor.trigger('click');
		return false;
	});

	var $commentForm = $('#commentform');

	$commentForm.on('click', 'a.clear-form', function (e) {
		e.preventDefault();
		$commentForm.find('input[type="text"], textarea').val('');
		return false;
	});

	$commentForm.on('click', ' a.dt-btn.dt-btn-m', function(e) {
		e.preventDefault();
		$commentForm.find('#submit').trigger('click');
		return false;
	});

	var $container = $('.iso-container');

	// filter
	$('.filter:not(.without-isotope) .filter-categories a').on('click.presscorFilterCategories', function(e) {
		var selector = $(this).attr('data-filter');
		$container.isotope({ filter: selector });
		return false;
	});

	// filter by
	$('.filter:not(.without-isotope) .filter-extras .filter-by a').on('click', function(e) {
		var sorting = $(this).attr('data-by'),
			sort = $(this).parents('.filter-extras').find('.filter-sorting > a.act').first().attr('data-sort');

		$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
		return false;
	});

	// sorting
	$('.filter:not(.without-isotope) .filter-extras .filter-sorting a').on('click', function(e) {
		var sort = $(this).attr('data-sort'),
			sorting = $(this).parents('.filter-extras').find('.filter-by > a.act').first().attr('data-by');

		$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
		return false;
	});

	var $paginator = $('.paginator[role="navigation"]'),
		$dots = $paginator.find('a.dots');
	$dots.on('click', function() {
		$paginator.find('div:hidden').show().find('a').unwrap();
		$dots.remove();
	});

	// search
	$('.widget .searchform .submit').on('click', function(e) {
		e.preventDefault();
		$(this).siblings('input.searchsubmit').click();
		return false;
	});

	// pin it
	$(".soc-ico a.share-button.pinterest").click(function(event){
		event.preventDefault();
	    $("#pinmarklet").remove();
	    var e = document.createElement('script');
	    e.setAttribute('type','text/javascript');
	    e.setAttribute('charset','UTF-8');
	    e.setAttribute('id','pinmarklet');
	    e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e);
	});
	var mtResizeTimeout;

	$(window).on("resize", function() {
		clearTimeout(mtResizeTimeout);
		mtResizeTimeout = setTimeout(function() {
			$(window).trigger( "metroresize" );
		}, 200);
	});
	var addSliderTimeout;
	clearTimeout(addSliderTimeout);	
	//jQuery(".swiper-container").fadeOut();
	addSliderTimeout = setTimeout(function() {
		//var homeSliderH = jQuery(".swiper-container").height();
		
		if( $(".swiper-container").length ){
			var loading_label = jQuery("<div></div>").attr("id", "loading-label").addClass("loading-label").css("position" , "fixed").hide().appendTo(".swiper-container").first();
			loading_label.fadeIn(250);
		
			jQuery(".swiper-wrapper").animate({
				//minHeight : homeSliderH + "px"
				opacity: 1
			}, 500, function() {
			//jQuery(".swiper-container > .swiper-wrapper").fadeIn();
				loading_label.fadeOut(500);
			});
		};
	}, 300);

	/* !Metro slider*/
	$(".swiper-container > .swiper-wrapper > .swiper-slide .preload-me").loaded(null, function() {
		

		if ($('.swiper-container').length > 0) {
			var $mainSwiperContent = $('.swiper-container').not('.swiper-container-horizontal'),
				$mainSwiperContentLength = $mainSwiperContent.find(' > .swiper-wrapper > .swiper-slide').length,
				$mainRightArrow = $mainSwiperContent.find('.arrow-right'),
				$mainLeftArrow = $mainSwiperContent.find('.arrow-left');
			if( $mainSwiperContentLength <= swiperColH){
				$($mainRightArrow).hide();
				$($mainLeftArrow).hide();
			}
			var swiperN1 = $mainSwiperContent.first().swiper({
				slidesPerSlide : swiperColH,
				onTouchMove:function(){
					var posX = swiperN1.getTranslate('x');
					if( posX >= 0 ){
						$mainRightArrow.removeClass('disable');
						$mainLeftArrow.addClass('disable');
					}else if( posX <= -($mainSwiperContent.find('.swiper-wrapper').first().width()-$mainSwiperContent.first().width()) ){
						$mainRightArrow.addClass('disable');
						$mainLeftArrow.removeClass('disable');
					}else{
						$mainLeftArrow.removeClass('disable');
						$mainRightArrow.removeClass('disable');
					}
				},
				onSlideChangeEnd :function(){
					var posX = swiperN1.getTranslate('x');
					if( posX >= 0 ){
						$mainRightArrow.removeClass('disable');
						$mainLeftArrow.addClass('disable');
					}else if( posX <= -($mainSwiperContent.find('.swiper-wrapper').first().width()-$mainSwiperContent.first().width()) ){
						$mainRightArrow.addClass('disable');
						$mainLeftArrow.removeClass('disable');
					}
				}
				
			});
			var swiperN1Length = swiperN1.slides.length;
			
			//Navigation arrows
			$mainLeftArrow.click(function(e) {
			    e.preventDefault();
				swiperN1.swipePrev();
				var swiperN1Index = swiperN1.activeIndex;
				$mainRightArrow.removeClass('disable');
				if( swiperN1Index == 0 ){
					
					$(this).addClass('disable');
				}else{
					$(this).removeClass('disable');
				}
			});
			$mainRightArrow.click(function(e) {
			    e.preventDefault();
				swiperN1.swipeNext();
				var swiperN1Index = swiperN1.activeIndex;
				$mainLeftArrow.removeClass('disable');
				if( (swiperN1Index+swiperColH) >= swiperN1Length ){
					
					$(this).addClass('disable');
				}else{
					$(this).removeClass('disable');
				}
			});

			//Vertical
			var swiperVerticalSlides = [];

			$('.swiper-container.swiper-container-horizontal').each( function() {
				var $subSwiperContent = $(this),
					$subSwiperContentLength = $subSwiperContent.find('.swiper-slide').length,
					$subUpArrow = $subSwiperContent.find('.arrow-top'),
					$subDownArrow = $subSwiperContent.find('.arrow-bottom');
				if( $subSwiperContentLength <= swiperCol){
					$($subUpArrow).hide();
					$($subDownArrow).hide();
				}
				var swiperN2 = $subSwiperContent.first().swiper({
					slidesPerSlide : swiperCol,
					mode: 'vertical',
					onTouchMove:function(){
						var posY = swiperN2.getTranslate('y');
						if( (posY) >= 0 ){
							$subDownArrow.removeClass('disable');
							$subUpArrow.addClass('disable');
						}else if( (posY) <= -($subSwiperContent.find('.swiper-wrapper').first().height() - $subSwiperContent.height()) ){
							$subDownArrow.addClass('disable');
							$subUpArrow.removeClass('disable');
						}else{
							$subUpArrow.removeClass('disable');
							$('.swiper-n2 .arrow-bottom').removeClass('disable');
						}
					},
					onSlideChangeEnd :function(){
						var posY = swiperN2.getTranslate('y');
						if( posY >= 0 ){
							$subDownArrow.removeClass('disable');
							$subUpArrow.addClass('disable');
						}else if( posY <= -($subSwiperContent.find('.swiper-wrapper').first().height()-$subSwiperContent.height()) ){
							$subDownArrow.addClass('disable');
							$subUpArrow.removeClass('disable');
						}
					}
				});

				swiperVerticalSlides.push(swiperN2);

				var swiperN2Length = swiperN2.slides.length;
				// $subUpArrow.addClass('disable');
				$subUpArrow.click(function(e) {
				    e.preventDefault();
					swiperN2.swipePrev();
					var swiperN2Index = swiperN2.activeIndex;
					$subDownArrow.removeClass('disable');
					if( swiperN2Index == 0 ){			
						$(this).addClass('disable');
					}else{
						$(this).removeClass('disable');
					}
				});

				$subDownArrow.click(function(e) {
				    e.preventDefault();
					swiperN2.swipeNext();
					var swiperN2Index = swiperN2.activeIndex;
					$subUpArrow.removeClass('disable');
					if( (swiperN2Index+swiperCol) >= swiperN2Length ){
						
						$(this).addClass('disable');
					}else{
						$(this).removeClass('disable');
					}
				});
			});

			$(window).on("metroresize", function(){
			  //Unset height
				$('.swiper-container').css({height:''});
				
				//Calc Height
				var $images = $mainSwiperContent.find('> .swiper-wrapper > .swiper-slide > img');

				if ( $images.length > 0 ) {
					var heights = $.map( $images, function( o ) { return $(o).height(); } ),
						etalonHeight = Math.min.apply( Math, heights );
				} else {
					etalonHeight = 980;
				}

				$('.swiper-container').css({height: etalonHeight});
				
				swiperN1.reInit();

			  	if ( swiperVerticalSlides.length > 0 ) {
			  		var arrLingth = swiperVerticalSlides.length;
			  		for ( var i=0; i < arrLingth; i++ ) {
			  			swiperVerticalSlides[i].reInit();
			  		}
			  	}
			}).trigger('metroresize');
		};
	});
	/* !Metro slider: end*/

});

//console.log(Modernizr)

// dtGlobals is defined in "modernizr.js"

jQuery(document).ready(function($) {
if ($.browser.msie) $("html").removeClass("csstransforms3d");

/* !Beautiful loading */
if (!dtGlobals.isMobile) {
	var showImagesStyle = "<style>html:not(.mobile-true) #main img:not(.animate-element), html:not(.mobile-true) #header img, html:not(.mobile-true) #bottom-bar img { opacity: 1; }</style>";

	dtGlobals.imgLoaded = setTimeout(function() {
		$("body").append(showImagesStyle);
	}, 5000);

	$("#main img:not(.animate-element), #header img, #bottom-bar img").not(".animate-element img, .rev_slider_wrapper img").loaded(
		function () {
			$(this).css("opacity", 1);
		}
	);
};
/* Beautiful loading: end */

/* !Custom touch events */
/* !(we need to add swipe events here) */

dtGlobals.touches = {};
dtGlobals.touches.touching = false;
dtGlobals.touches.touch = false;
dtGlobals.touches.currX = 0;
dtGlobals.touches.currY = 0;
dtGlobals.touches.cachedX = 0;
dtGlobals.touches.cachedY = 0;
dtGlobals.touches.count = 0;
dtGlobals.resizeCounter = 0;

var smartMenu = true;
if (dtGlobals.isMobile && !dtGlobals.isiPad) smartMenu = false;

$(document).on("touchstart",function(e) {
	if (e.originalEvent.touches.length == 1) {
		dtGlobals.touches.touch = e.originalEvent.touches[0];

		// caching the current x
		dtGlobals.touches.cachedX = dtGlobals.touches.touch.pageX;
		// caching the current y
		dtGlobals.touches.cachedY = dtGlobals.touches.touch.pageY;
		// a touch event is detected      
		dtGlobals.touches.touching = true;

		// detecting if after 200ms the finger is still in the same position
		setTimeout(function() {

			dtGlobals.touches.currX = dtGlobals.touches.touch.pageX;
			dtGlobals.touches.currY = dtGlobals.touches.touch.pageY;      

			if ((dtGlobals.touches.cachedX === dtGlobals.touches.currX) && !dtGlobals.touches.touching && (dtGlobals.touches.cachedY === dtGlobals.touches.currY)) {
				// Here you get the Tap event
				dtGlobals.touches.count++;
				//console.log(dtGlobals.touches.count)
				$(e.target).trigger("tap");
			}
		},200);
	}
});

$(document).on("touchend touchcancel",function (e){
	// here we can consider finished the touch event
	dtGlobals.touches.touching = false;
});

$(document).on("touchmove",function (e){
	dtGlobals.touches.touch = e.originalEvent.touches[0];

	if(dtGlobals.touches.touching) {
		// here you are swiping
	}
});


$(document).on("tap", function(e) {
	$(".dt-hovered").trigger("mouseout");
});

/* Custom touch events:end */

/* !Debounced resize event */
var dtResizeTimeout;
if(dtGlobals.isMobile){
	$(window).bind("orientationchange", function(event) {
		/*$(window).on("resize", function() {*/
			clearTimeout(dtResizeTimeout);
			dtResizeTimeout = setTimeout(function() {
				$(window).trigger( "debouncedresize" );
			}, 200);
		/*});*/
	});
}else{
	$(window).on("resize", function() {
		clearTimeout(dtResizeTimeout);
		dtResizeTimeout = setTimeout(function() {
			$(window).trigger( "debouncedresize" );
		}, 200);
	});
}
/* Debounced resize event: end */

/* !jQuery extensions */

/* !- Check if element exists */
$.fn.exists = function() {
	if ($(this).length > 0) {
		return true;
	} else {
		return false;
	}
}

/* !- Check if element is loaded */
$.fn.loaded = function(callback, jointCallback, ensureCallback){
	var len	= this.length;
	if (len > 0) {
		return this.each(function() {
			var	el		= this,
				$el		= $(el),
				blank	= "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

			$el.on("load.dt", function(event) {
				$(this).off("load.dt");
				if (typeof callback == "function") {
					callback.call(this);
				}
				if (--len <= 0 && (typeof jointCallback == "function")){
					jointCallback.call(this);
				}
			});

			if (!el.complete || el.complete === undefined) {
				el.src = el.src;
			} else {
				$el.trigger("load.dt")
			}
		});
	} else if (ensureCallback) {
		if (typeof jointCallback == "function") {
			jointCallback.call(this);
		}
		return this;
	}
};

/* jQuery extensions: end */


/* !Main navigation */
/* We need to fine-tune timings and do something about the usage of jQuery "animate" function */ 

$("#mobile-menu").wrap("<div id='dl-menu' class='dl-menuwrapper wf-mobile-visible' />");

var $mainNav = $("#main-nav, .dl-menu"),
	isDemo = $(".demo-panel").exists();

if (isDemo) {
	$mainNav.find(".page-item-112").removeClass("has-children").find("> .sub-nav").remove();
	$mainNav.find(".page-item-112 > ").attr("onclick", "");
	$mainNav.find(".page-item-112 > a").css("cursor", "pointer").click(function(e) {
		e.preventDefault();
		window.location.href = $(this).attr("href");
	})
}
$(".act", $mainNav).parents("li").addClass("act");

var	$mobileNav = $mainNav.clone();
var backCap = $("#mobile-menu > .menu-back").html();

$mobileNav
	.attr("id", "")
	.attr("class", "dl-menu")
	.find(".sub-nav")
		.addClass("dl-submenu")
		.removeClass("sub-nav")
		.prepend("<li class='dl-back'><a href='#''><span>"+backCap+"</a></li>");

$mobileNav.appendTo("#dl-menu").wrap("<div class='dl-container' />");

if (!$("html").hasClass("old-ie")) $( "#dl-menu" ).dlmenu();


/*if ($mainNav.hasClass("fancy-rollovers") && $("html").hasClass("csstransforms3d")) {
	$("> li > a", $mainNav).each(function() {
		var $this = $(this).css("padding", 0),
			tempHtml = $this.html();

		tempHtml = "<span>"+tempHtml+"<span>"+tempHtml+"</span></span>";
		$this.html(tempHtml);
	});
}*/	

$(".sub-nav", $mainNav).parent().each(function() {
	var $this = $(this);
	if(dtGlobals.isMobile){
		$this.find("> a").on("click", function(e) {
			if (!$(this).hasClass("dt-clicked")) {
				e.preventDefault();
				$mainNav.find(".dt-clicked").removeClass("dt-clicked");
				$(this).addClass("dt-clicked");
			} else {
				e.stopPropagation();
			}

		});
	};

	var menuTimeoutShow,
		menuTimeoutHide;

	$this.on("mouseenter tap", function(e) {
		if(e.type == "tap") e.stopPropagation();

		var $this = $(this);
		$this.addClass("dt-hovered");

		if ($("#page").width() - ($this.children("ul").offset().left - $("#page").offset().left) - 230 < 0) {
			$this.children("ul").addClass("right-overflow");
		}

		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutShow = setTimeout(function() {
			if($this.hasClass("dt-hovered")){
				$this.children('ul').stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 200);
			}
		}, 350);
	});

	$this.on("mouseleave", function(e) {
		var $this = $(this);
		$this.removeClass("dt-hovered");

		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutHide = setTimeout(function() {
			if(!$this.hasClass("dt-hovered")){
				$this.children("ul").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				
				setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.children("ul").removeClass("right-overflow");
					}
				}, 400);
			}
		}, 200);

		$this.find("> a").removeClass("dt-clicked");
	});

});

/* Main navigation: end */


/* !Navigation widget */
var customTimeoutShow
$(".custom-nav > li > a").click(function(e){
    $menuItem = $(this).parent();
	if ($menuItem.hasClass("has-children")) e.preventDefault();
	
	
	    if ($(this).attr("class") != "active"){
		    	$(".custom-nav > li > ul").stop(true, true).slideUp(400);
		    	$(this).next().stop(true, true).slideDown(500);
		    	$(".custom-nav > li > a").removeClass("active");
		    	$(this).addClass('active');
	    }else{
	    		$(this).next().stop(true, true).slideUp(500);
	    		$(this).removeClass("active");
	    }

		$menuItem.siblings().removeClass("act");
		$menuItem.addClass("act");
});
$(".custom-nav > li > ul").each(function(){
	clearTimeout(customTimeoutShow);
	$this = $(this);
	$thisChildren = $this.find("li");
	if($thisChildren.hasClass("act")){
		$this.prev().addClass("active");
		$this.parent().siblings().removeClass("act");
		$this.parent().addClass("act");
		$(this).slideDown(500);
	}
});


/* Navigation widget: end */

$(".shortcode-tabs").goTabs().css("visibility", "visible");

/* !Royal Slider */
if ($(".rsHomePorthole").exists()) {
	var portholeSlider = {};
		portholeSlider.container = $("#main-slideshow");
		portholeSlider.width = portholeSlider.container.attr("data-width") ? parseInt(portholeSlider.container.attr("data-width")) : 1280;
		portholeSlider.height = portholeSlider.container.attr("data-height") ? parseInt(portholeSlider.container.attr("data-height")) : 720;
		portholeSlider.autoslide = portholeSlider.container.attr("data-autoslide") && parseInt(portholeSlider.container.attr("data-autoslide")) > 999 ? parseInt(portholeSlider.container.attr("data-autoslide")) : 5000;
		portholeSlider.scale = portholeSlider.container.attr("data-scale") ? portholeSlider.container.attr("data-scale") : "fill";
		portholeSlider.paused = portholeSlider.container.attr("data-paused") ? portholeSlider.container.attr("data-paused") : true;
		portholeSlider.hendheld = $(window).width() < 740 && dtGlobals.isMobile ? true : false;
	
	$("#main-slideshow-content").appendTo(portholeSlider.container);

	
	portholeSlider.api = $(".rsHomePorthole").royalSlider({
		autoScaleSlider: true,
		autoScaleSliderWidth: portholeSlider.width,
		autoScaleSliderHeight: portholeSlider.height,
		autoPlay: {
			enabled: !portholeSlider.hendheld,
			stopAtAction: false,
			pauseOnHover: false,
			delay: portholeSlider.autoslide
		},
		imageScaleMode: portholeSlider.scale,
		imageScalePadding: 0,
		numImagesToPreload: 999,
		slidesOrientation: "horizontal",
		disableResponsiveness: false,
		loopRewind: true,
		arrowsNav: false,
		globalCaption: true,
		controlNavigation: !portholeSlider.hendheld ? 'porthole' : 'none',
		thumbs: {
			orientation: 'vertical',
			drag: false,
			touch: false,
			spacing: 10,
			firstMargin: false,
			appendSpan: false
		},
		block: {
			fadeEffect: true,
			moveEffect: 'bottom',
			moveOffset: 5
		}
	}).data("royalSlider");
	var $_this = portholeSlider.container,
		$_this_childs = $_this.find(".rsSlide").size();
	if ($_this_childs < 2) {
		$(".rsThumbs", $_this).hide();
		portholeSlider.api._isMove = false;
		$_this.find(".rsOverflow").css("cursor", "auto")
	};
};

$(".slider-post").each(function(){
	$(this).royalSlider({
		autoScaleSlider: true,
		imageScaleMode: "fit",
		autoScaleSliderWidth: $(this).attr("data-width"),
		autoScaleSliderHeight: $(this).attr("data-height"),
		imageScalePadding: 0,
		numImagesToPreload: 6,
		slidesOrientation: "horizontal",
		disableResponsiveness: false,
		globalCaption:true
	});
});

$(".slider-simple").each(function(){
	$(this).royalSlider({
		autoScaleSlider: true,
		imageScaleMode: "fit",
		autoScaleSliderWidth: $(this).attr("data-width"),
		autoScaleSliderHeight: $(this).attr("data-height"),
		imageScalePadding: 0,
		numImagesToPreload: 6,
		slidesOrientation: "horizontal",
		disableResponsiveness: false,
		globalCaption:true
	});
});

$(".slider-content .preload-me").loaded(null, function() {
	$(".slider-content").each(function(){
		var $this = $(this),
			autoslide = $this.attr("data-autoslide") && parseInt($this.attr("data-autoslide")) > 999 ? parseInt($this.attr("data-autoslide")) : 5000;		
			hendheld = !($(window).width() < 740 && dtGlobals.isMobile) && $this.attr("data-autoslide") ? true : false;

		$this.royalSlider({
			autoPlay: {
				enabled: hendheld,
				stopAtAction: false,
				pauseOnHover: false,
				delay: autoslide
			},
			autoHeight: true,
			controlsInside: false,
			fadeinLoadedSlide: false,
			controlNavigationSpacing: 0,
			controlNavigation: 'bullets',
			imageScaleMode: 'none',
			imageAlignCenter:false,
			loop: false,
			loopRewind: true,
			numImagesToPreload: 6,
			keyboardNavEnabled: true

		}).data("royalSlider");
	});
}, true);

/* Royal Slider: end */



/*!Revolution slider*/
if ($(".rev_slider_wrapper").length > 0){
	$("#main-slideshow").each(function(){
		var $this = $(this);
		if( $this.find("> .rev_slider_wrapper")){
			$this.addClass("fix rv-slider");
		};
		if ($(".rev_slider_wrapper").hasClass("fullscreen-container") || $(".rev_slider_wrapper").hasClass("fullwidthbanner-container")){
			$this.removeClass("fix rv-slider");
		};
	});
};
/* Revolution slider: end */

/*!Instagram*/
function calcPics(maxitemwidth){
	var $collection = $(".instagram-photos");
	if ($collection.length < 1) return false;

	$collection.each(function(){
		var maxitemwidth = maxitemwidth ? maxitemwidth : parseInt($(this).find("> a").css("max-width")),
			itemmarg = parseInt($(this).find("> a").css("margin-left"));
		
		// Cahce everything
		var $container = $(this),
			containerwidth = $container.width(),
			itemperc = (100/(Math.ceil(containerwidth/maxitemwidth)));
	
		$container.find("a").css({ "width": itemperc+'%' });
	});
};

/* Instagram: end */
/*!Full-width scroller*/
$(".fullwidth-slider li").each(function() {
	var $_this = $(this),
		this_img = $_this.find("img").width();
	$_this.css({"width": this_img + 20});
	$(".fs-entry-content").css("opacity", "1")
});
$(".fullwidth-slider").each(function() {
	var	$this = $(this),
		$this_par = $(this).parent(),
		$this_img = $this.find("img").attr("height"),
		$this_top = $this.position().top,
		scroller = $this.theSlider({
			mode: "scroller"
		}).data("theSlider");
	$(".prev, .next", $this_par).css({
		height: $this_img
	});
	$(".related-projects .prev, .related-projects .next").css({
		top: $this_top + "px"
	});
	$(".prev i", $this_par).click(function() {
		if (!scroller.noSlide) scroller.slidePrev();
	});
	$(".next i", $this_par).click(function() {
		if (!scroller.noSlide) scroller.slideNext();
	});


	scroller.ev.on("updateNav sliderReady", function() {
		if (scroller.lockRight) {
			$(".next", $this_par).addClass("disabled");
		}
		else {
			$(".next", $this_par).removeClass("disabled");
		};

		if (scroller.lockLeft) {
			$(".prev", $this_par).addClass("disabled");
		}
		else {
			$(".prev", $this_par).removeClass("disabled");
		};
	});

});
/* Full-width scroller: end */
/*!Make element fullwidth*/
function moveOffset(){
	if( $(".map-container.full").length ){
		var offset_map = $(".map-container.full").position().left;
		$(".map-container.full").css({
			width: $('#main').width(),
			marginLeft: -offset_map
		});
	};
	if( $(".slider-wrapper").length ){
		$(".slider-wrapper.full").each(function(){
			var offset_fs = $(this).position().left;
			var offset_fs_st = $(this).offset().left;
			var $frame = $(this).children(".fullwidth-slider");

			if($(this).parents(".stripe").length > 0){
				$(this).css({
					width: $("#main").width(),
					"margin-left": -$(this).parents(".stripe").position().left
				});
			}else{
				$(this).css({
					width: $("#main").width(),
					"margin-left": -offset_fs
				});
			};

			var scroller = $frame.data("theSlider");
			scroller.update();

		});

		$(".slider-wrapper.full .prev,.slider-wrapper.full .next").css({
			opacity: 1
		});
	};
};
/* Make element fullwidth: end */

/* !-overlap for webkit*/
if ( !$.browser.webkit || dtGlobals.isMobile ){
	$("body").addClass("not-webkit").removeClass("is-webkit");
}else{
	$("body").removeClass("not-webkit").addClass("is-webkit");
	//$(".overlap #main").prepend("<div class='main-gradient'></div>");
	$(".overlap #content").find(">:first-child").css({
		position: "relative",
		"z-index": "4"
	})
	if( $(".overlap #content").find(">:first-child").height() < 36 ){
		$(".overlap #content").find("> :nth-child(2)").css({
			position: "relative",
			"z-index": "4"
		})
	}
};
/**/
/* !Masonry layout: */

var	$isoCollection = $(".iso-container");
var	$gridCollection = $(".wf-container.grid-masonry");
// !- Columns width calculation
function calculateColumns(container) {

	var $isoContainer = container,
		containerWidth = $isoContainer.width(),
		minCol = Math.floor(containerWidth / 12);

	if (minCol*3 >= 200) {

		$("> .iso-item", $isoContainer).each(function() {
			var $this = $(this);
			if ($this.hasClass("wf-1-4")) {
				$this.css("width", minCol*3);
			} else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
				$this.css("width", minCol*6);
			} else if ($this.hasClass("wf-1-3")) {
				$this.css("width", minCol*4);
			} else if ($this.hasClass("wf-2-3")) {
				$this.css("width", minCol*8);
			}
		});

	} else if ( minCol*3 < 200 && minCol*3 > 150) {

		$("> .iso-item", $isoContainer).each(function() {
			var $this = $(this);
			if ($this.hasClass("wf-1-4")) {
				$this.css("width", minCol*6);
			} else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
				$this.css("width", minCol*12);
			} else if ($this.hasClass("wf-1-3")) {
				$this.css("width", minCol*6);
			} else if ($this.hasClass("wf-2-3")) {
				$this.css("width", minCol*12);
			}
		});

	}  else if ( minCol*3 <= 150) {
		$("> .iso-item", $isoContainer).each(function() {
			$(this).css("width", minCol*12);
		});
	}
};

if ($isoCollection.exists()) {

	var $isoPreloader = $('<div class="tp-loader loading-label" style="position: fixed;" />').appendTo("body").hide();
	$isoPreloader.fadeIn(50);

	$isoCollection.each(function() {
		var $isoContainer = $(this);
	
		calculateColumns($isoContainer);
		
		$(".preload-me", $isoContainer).loaded(null, function() {
	
			//alert("Everithing is loaded, bitchez!");
			$isoPreloader.stop().fadeOut(300);
	
			// !- Slider initialization
			$(".slider-masonry", $isoContainer).each(function(){
				var $_this = $(this),
					attrW = $_this.data('width'),
					attrH = $_this.data('height'); 
	
				$_this.royalSlider({
					autoScaleSlider: true,
					autoScaleSliderWidth: attrW,
					autoScaleSliderHeight: attrH,
					imageScaleMode: "fit",
					imageScalePadding: 0,
					slidesOrientation: "horizontal",
					disableResponsiveness: true
				});
			});
	
			// !- Masonry initialization
			$isoContainer.isotope({
				itemSelector : '.iso-item',
				resizable: false,
				layoutMode : 'masonry',
				animationEngine: 'best-available',
				masonry: { columnWidth: 1 },
				getSortData : {
					date : function( $elem ) {
						return $elem.attr('data-date');
					},
					name : function( $elem ) {
						return $elem.attr('data-name');
					}
				}
			});
	
			$(".iso-item", $isoContainer).css("visibility", "visible");
	
			// !- Window resize event
			$(window).on("debouncedresize", function () {
				calculateColumns($isoContainer);
	
				$(".royalSlider", $isoContainer).each(function() {
					$(this).data("royalSlider").updateSliderSize();
				});
	
				$isoContainer.isotope("reLayout");
			});
		}, true);
	});

}

/**/
function calculateGridColumns(container) {

	var $gridContainer = container,
		containerWidth = $gridContainer.width();
		if( $("#main").hasClass("sidebar-none") ){
			minCol = Math.floor(containerWidth / 248);
		}else{			
			minCol = Math.floor(containerWidth / 186);
		}

	if ( minCol == 5) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			if ($this.hasClass("wf-1-4")) {
				$(this).css("width", minCol*5 + "%");
			}else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
				$this.css("width", minCol*10 + "%");
			} else if ($this.hasClass("wf-1-3")) {
				$this.css("width", minCol*6.6666 + "%");
			}
		});
	} else if ( minCol < 5 && minCol >= 4) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			if ($this.hasClass("wf-1-4")) {
				$(this).css("width", minCol*6.25 + "%");
			}else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
				$this.css("width", minCol*12.5 + "%");
			} else if ($this.hasClass("wf-1-3")) {
				$this.css("width", minCol*8.333 + "%");
			}
		});
	}else if ( minCol < 4 && minCol >=3 ) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			if ($this.hasClass("wf-1-4")) {
				$this.css("width", minCol*11.111 + "%");
			}else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
				$this.css("width", minCol*16.667 + "%");
			} else if ($this.hasClass("wf-1-3")) {
				$this.css("width", minCol*11.111 + "%");
			}
		});

	} 
	else if (minCol < 3 && minCol >=2) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			$this.css("width", minCol*25 + "%");						
		});
	}
	else if (minCol < 2 && minCol >=1) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			$this.css("width", minCol*50 + "%");
			
		});
	}
	 if (containerWidth < 360) {
		$("> .wf-cell", $gridContainer).each(function() {
			var $this = $(this);
			$this.css("width", "100%");			
		});
	}
};
$gridCollection.each(function() {
	var $gridContainer = $(this);
	calculateGridColumns($gridContainer);
	$(window).on("debouncedresize", function () {
		calculateGridColumns($gridCollection);
	});
});
// !- Filter
$(".filter-categories > a").on("click", function(e) {
	var $this = $(this);
	
	if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
		arguments.callee.dtPreventD = !$this.parents(".filter").first().hasClass("without-isotope");
	}

	e.preventDefault();

	$this.trigger("mouseleave");
	
	if ($this.hasClass("act") && !$this.hasClass("show-all")) {
		e.stopImmediatePropagation();
		$this.removeClass("act");
		$this.siblings("a.show-all").trigger("click");//.addClass("act");
	} else {
		$this.siblings().removeClass("act");
		$this.addClass("act");

		if ( !arguments.callee.dtPreventD ) {
			window.location.href = $this.attr("href");
		}
	}
});
$(".filter-extras .filter-switch").each(function(){
	var $_this = $(this);
	if($_this.prev('.act')){
		$_this.addClass('left-act');
	}else if($_this.next('.act')){
		$_this.addClass('right-act');
	}else{
		$_this.removeClass('right-act');
		$_this.removeClass('left-act');
	}
});
$(".filter-extras a").on("click", function(e) {
	var $this = $(this);
	
	if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
		arguments.callee.dtPreventD = !$this.parents(".filter").first().hasClass("without-isotope");
	}

	if ( arguments.callee.dtPreventD ) {
		e.preventDefault();
	}

	$this.siblings().removeClass("act");
	$this.addClass("act");

	$(".filter-extras .filter-switch").each(function(){
		var $_this = $(this);
		if($_this.prev($this).hasClass('act')){
			$_this.addClass('left-act');
			$_this.removeClass('right-act');
		}else if($_this.next($this).hasClass('act')){
			$_this.addClass('right-act');
			$_this.removeClass('left-act');
		}else{
			$_this.removeClass('right-act');
			$_this.removeClass('left-act');
		}
	});
});

/* Masonry layout: end */

$(".full-boxed-pricing").each(function(){
	$(this).find(".shortcode-pricing-table").last().addClass("last")
})

/* !Widgets: */

/*!Scroller show content on click*/
$("img").on("dragstart", function(event) { event.preventDefault(); });
$(".fs-entry-img, .rollover-project .show-content").each(function(){
	var $this = $(this);
	$this.append('<i></i>')
});

$(".no-touch .swiper-slide").each(function() {
	var ent = $(this);
	
	ent.find("> .link").on("mousedown", function(e) {
		var mouseDX = e.pageX,
			mouseDY = e.pageY;

		ent.find("> .link").one("mouseup", function(e) {
			var mouseUX = e.pageX,
				mouseUY = e.pageY;

			if( Math.abs(mouseDX - mouseUX) < 5 ){
				var $thisLink = $(this),
					ent=jQuery(this).parents(".swiper-slide"),
					mi=ent.find("> .swiper-caption");
				$(".swiper-slide > .link").removeClass("act");
				$thisLink.addClass("act");
				$(".swiper-caption").not(mi).fadeOut(300);
				mi.fadeIn(400);					
			}
		})
		
	});
	ent.find(".close-link").on("mousedown tap", function(e) {
		var $this = $(this),
			ent=jQuery(this).parents(".swiper-slide"),
			mi=ent.find("> .swiper-caption");
		
		mi.delay(100).fadeOut(300, function(){
			ent.find("> .link").removeClass("act");
		});
	});
});

$(".fs-entry").not(".shortcode-instagram .fs-entry").each(function() {
	var ent = $(this);

	ent.find(".fs-entry-img").on("mousedown tap", function(e) {
		if( (e.which == 3) ) {}else{
			var mouseDX = e.pageX,
				mouseDY = e.pageY;

			ent.find(".fs-entry-img").one("mouseup tap", function(e) {
				var mouseUX = e.pageX,
					mouseUY = e.pageY;

				if( Math.abs(mouseDX - mouseUX) < 5 ){
					var $thisLink = $(this),
						link = $thisLink.attr('data-dt-link');
					if ( link ) window.location.href = link;
					return true;
				};
			});
		}
	});
});
$(".no-touch .fs-entry-content a").on("click", function(e){
	e.preventDefault();
})

$(".fs-entry-content").each(function() {
	var ent = $(this);

	ent.on("mousedown", function(e) {
		if( (e.which == 3) ) {}else{
			var mouseDX = e.pageX,
				mouseDY = e.pageY;

			ent.one("mouseup", function(e) {
				var mouseUX = e.pageX,
					mouseUY = e.pageY;

				if( Math.abs(mouseDX - mouseUX) < 5 ){
					var $thisLink = $(this).find("a.project-details"),
						link = $thisLink.attr('href');
					if ( link ) window.location.href = link;
					return true;
				};
			});
		}
	});
	ent.find("a.project-link").on("click", function(){
		var this_target = $(this).attr("target"),
			this_href = $(this).attr('href');
		 window.open(this_href, this_target );
		/*window.location.target =$(this).attr("target");
		window.location.href = $(this).attr('href');
		console.log($(this).attr("target"))*/
	})
});


$(".touch .rollover-project a.link.show-content").on("click", function(e){
	e.preventDefault();
})

$(".no-touch .shortcode-instagram .fs-entry").each(function() {
	var ent = $(this);
	ent.on("mousedown tap", function(e) {
		if( (e.which == 3) ) {}else{
			var mouseDX = e.pageX,
				mouseDY = e.pageY;
				
			ent.on("mouseup tap", function(e) {
				var mouseUX = e.pageX,
					mouseUY = e.pageY;
				if( Math.abs(mouseDX - mouseUX) < 5 ){
					ent.on("click.dtPhotos", function(e){
						ent.off("click.dtPhotos");
						$("a[data-pp^='prettyPhoto']", this).trigger('click');
					});

				};
			});
		};
	});
});

$(".rollover-project, .touch .swiper-slide").not(".touch .albums .rollover-project").each(function() {
	var ent=jQuery(this);			
	
	ent.find("> .link").on("mousedown tap", function(e) {
		var mouseDX = e.pageX,
			mouseDY = e.pageY;
		ent.find("> .link").one("mouseup tap", function(e) {
			var mouseUX = e.pageX,
				mouseUY = e.pageY;
			if( Math.abs(mouseDX - mouseUX) < 5 ){
				var $thisLink = $(this),
					ent=jQuery(this).parents(".swiper-slide"),
					mi=ent.find("> .swiper-caption");
				
				$(".swiper-caption").not(mi).fadeOut(200);
				mi.delay(150).fadeIn(300);				
			}
		})
		
	});
	ent.find(".close-link").on("mousedown tap", function(e) {
		var $this = $(this),
			ent=jQuery(this).parents(".swiper-slide"),
			mi=ent.find("> .swiper-caption");
		
		mi.delay(100).fadeOut(200, function(){
		});
	});
});

$(".touch .rollover-project").not(".touch .albums .rollover-project").each(function() {
	var ent = $(this);

	ent.find(".link").on("tap", function(e) {
		e.preventDefault();
		var $this = $(this),
			ent = $(this).parents(".rollover-project"),
			mi = ent.find(".rollover-content");
		
		$(".rollover-project .link").removeClass("act");
		$this.addClass("act");
		$(".rollover-content").not(mi).fadeOut(300);
		mi.delay(150).fadeIn(200);
	});
	
	ent.find(".close-link").on("tap", function() {
		var $this = $(this),
			ent=jQuery(this).parents(".rollover-project"),
			mi=ent.find(".rollover-content");
		
		mi.delay(100).fadeOut(100, function(){
			ent.find(".link").removeClass("act");
		});
	});
});
/* Scroller show content on click: end */

/*!Pretty photo*/
// Albums, exclude featured image from gallery post
$(".no-touch .albums .ignore-feaured-image").on("click", function(e) {
	e.preventDefault();
	$(this).siblings(".dt-prettyphoto-gallery-container").first().find("a[data-pp^='prettyPhoto']").first().click();
	return false;
});

// albums with rollover info
$(".no-touch .albums .rollover-content, .no-touch .media .rollover-content").on("click", function(e){
	if ( $(e.target).is("a") ) return true;
	$(this).siblings("a[data-pp^='prettyPhoto']").first().click();
});


/* Pretty photo: end */

/*!Show rollovers on device*/

$("a.pp_close").on("touchstart touchend", function(e) {
	e.type = "click";
	$(this).trigger(e);
	return false;
});
$(".touch .rollover").each(function(){
	if( $(".rollover-thumbnails", this).length > 0){
		$("body").on("touchend", function(e) {			
			  $(".touch .rollover").removeClass("is-clicked");
		});

		var $this = $(this),
			thisPar = $this.parents(".wf-cell");
		$this.on("touchstart", function(e) {
			origY = e.originalEvent.pageY;
			origX = e.originalEvent.pageX;			
		});
		
		$this.on("touchend", function(e) {
			var touchEX = e.originalEvent.changedTouches[0].pageX,
				touchEY = e.originalEvent.changedTouches[0].pageY;
			if( origY == touchEY || origX == touchEX ){
				if ($this.hasClass("is-clicked")) {
				} else {
					e.preventDefault();
				$(".touch .rollover").removeClass("is-clicked");
					$this.addClass("is-clicked");
					return false;
				};
			};
		});
	};

});
if(dtGlobals.isAndroid){
	$(".shortcode-instagram .fs-entry").each(function() {
		var ent = $(this);
		ent.on("mousedown tap", function(e) {
			if( (e.which == 3) ) {}else{
				var mouseDX = e.pageX,
					mouseDY = e.pageY;
					
				ent.on("mouseup tap", function(e) {
					var mouseUX = e.pageX,
						mouseUY = e.pageY;
					if( Math.abs(mouseDX - mouseUX) < 5 ){
						$("a[data-pp^='prettyPhoto']", this).prettyPhoto();
					};
				});
			};
		});
	});
}else{
	$(".touch .shortcode-instagram .fs-entry").each(function() {
		var ent = $(this),
			$link = ent.find("> .link a");	
		ent.parents(".fullwidth-slider").on("touchstart", function(e) {		
			origY = e.originalEvent.pageY;
			origX = e.originalEvent.pageX;			
		});			
		ent.parents(".fullwidth-slider").on("touchend", function(e) {
			var touchEX = e.originalEvent.changedTouches[0].pageX,
				touchEY = e.originalEvent.changedTouches[0].pageY;
			if( origY == touchEY || origX == touchEX){
				$("a[data-pp^='prettyPhoto']", this).prettyPhoto();				
			}
		});
	});
}

$(".touch .albums .rollover-project, .touch .media .rollover-project").each(function(){
	if( $(".rollover-content", this).length > 0){
		$("body").on("touchend", function(e) {
			$(".touch .rollover-content").removeClass("is-clicked");
		});
		var $this = $(this).find(".rollover-content"),
			thisPar = $this.parents(".wf-cell");
		$this.find(".close-link").on("touchstart", function(){
			$this.removeClass("is-clicked");
			return false;
		});
		$this.on("touchstart", function(e) {
			origY = e.originalEvent.pageY;
			origX = e.originalEvent.pageX;			
		});
		$this.on("touchend", function(e) {
			var touchEX = e.originalEvent.changedTouches[0].pageX,
				touchEY = e.originalEvent.changedTouches[0].pageY;
			if( origY == touchEY || origX == touchEX ){
				if ($this.hasClass("is-clicked")) {
					$this.on("click.dtAlbums", function(e){
						$this.off("click.dtAlbums");
						$(this).siblings("a[data-pp^='prettyPhoto']").first().click();
					});
				} else {
					e.preventDefault();
					$(".touch .rollover-content").removeClass("is-clicked");
					$this.addClass("is-clicked");
					return false;
				};
			};
		});
	};

});

// init prettyPhoto
$("a[data-pp^='prettyPhoto']").not(".touch .shortcode-instagram a[data-pp^='prettyPhoto']").prettyPhoto();

/* Show rollovers on device: end */
$(".touch .shortcode-instagram a").on("click", function(e){
	e.preventDefault();
})
$("#parent-element a").live("touchstart",function(e){
    var $link_id = $(this).attr("id");
    if ($(this).parent().data("clicked") == $link_id) {
        // element has been tapped (hovered), reset 'clicked' data flag on parent element and return true (activating the link)
        $(this).parent().data("clicked", null);
        return true;
    } else {
        $(this).trigger("mouseenter").siblings().trigger("mouseout"); //triggers the hover state on the tapped link (because preventDefault(); breaks this) and untriggers the hover state for all other links in the container.
        // element has not been tapped (hovered) yet, set 'clicked' data flag on parent element to id of clicked link, and prevent click
        e.preventDefault(); // return false; on the end of this else statement would do the same
        $(this).parent().data("clicked", $link_id); //set this link's ID as the last tapped link ('clicked')
    }
});

/*!Skills*//*
$(".skill-value").find("> span").text(0 + '%');
$.fn.animated_skills = function(){
	if(!dtGlobals.isMobile){
		$(".start-animation .skill-value").each(function () {
			var $_this = $(this),
				$this_data = $_this.data("width"),
				current_percent = 0,
				progress = null;
			var progress = setInterval(function(){

				if( current_percent >= $this_data ){
					clearInterval(progress);
				}else{
					current_percent+=1
					var skill_html = parseInt($_this.find("> span").html());
					$_this.css({
						width: current_percent + '%'
					});					
					//$_this.find("> span").delay(2000).fadeOut(200, function(){});
					if( skill_html >= 99 || $_this.data("width") > 99 ){
						$_this.addClass("full");
					}
				}
				//$_this.find("> span").text(current_percent + '%');

			},10);

			var fadeTimeout;
			$_this.hover(function() {
				clearTimeout(fadeTimeout);
				fadeTimeout = setTimeout(function() {
					$_this.find("> span").stop(true, true).fadeIn(200);
				}, 200);
			}, function(){
				clearTimeout(fadeTimeout);
				$_this.find("> span").fadeOut(200);
			});
		});
	};
};
$(".skills").addClass("animation-builder");
function mk_skill_meter() {

	$(".skill-value > span").hide();
	if($(".skill").length > 0 ){
		$(".skill .skill-value").each(function () {
			var $this = $(this);
			if (!$this.hasClass("scroll-animated")) {
				$this.addClass("scroll-animated");
				
				setTimeout(function () {
					$this.css({
						width: $this.data("width") + '%'
					});
					$this.find("> span").delay(2000).fadeOut(200, function(){});
				}, 300);
				var skill_html = parseInt($this.find("> span").html());
				if( skill_html >= 99 || $this.data("width") == 100 ){
					$this.addClass("full");
				}
			};
			
		});
	}
}

if(dtGlobals.isMobile){
	jQuery(document).ready(function($) {
		mk_skill_meter();
	});
	$(window).scroll(function () {
		mk_skill_meter();
	});
}

if (!$("html").hasClass("old-ie")){
}else{
	$(".skill-value").each(function () {
		var $_this = $(this),
			$this_data = $_this.data('width'),
			current_percent = 0,
			progress = null;
		var progress = setInterval(function(){
			if( current_percent >= $this_data ){
				clearInterval(progress);
				$_this.find("> span").delay(2000).fadeOut(200, function(){});			

			}else{
				current_percent+=1
				var skill_html = parseInt($_this.find("> span").html());
				$_this.css({
					width: current_percent + '%'
				});
				if( skill_html >= 99 ){
					$_this.addClass("full");
				}
			}
			$_this.find("> span").text(current_percent + '%');

		},10)

		var fadeTimeout;
		$_this.hover(function() {
			clearTimeout(fadeTimeout);
			fadeTimeout = setTimeout(function() {
				$_this.find("> span").stop(true, true).fadeIn(200);
			}, 200);
		}, function(){
			clearTimeout(fadeTimeout);
			$_this.find("> span").fadeOut(200);
		});
	});
};
*/
/* Skills: end */
/* !- Animated content*//*
function animated_contents() {
	if(!dtGlobals.isMobile){
		var j = -1;
		$(".animate-element:not(.start-animation):in-viewport").each(function () {
			var $this = $(this);
			var animateTimeout;
			if (!$this.hasClass("start-animation") && !$this.hasClass("start-animation-done")) {
				$this.addClass("start-animation-done");
				j++;
				setTimeout(function () {
					$this.addClass("start-animation");
					if($this.hasClass("skills")){
						$this.animated_skills();
					};
				}, 200 * j);
			};
		});
	};
};
$(".tab").on("click", function(){
	if(!dtGlobals.isMobile){
		$(".animate-element").each(function (i) {
			var $this = $(this);
			if (!$this.hasClass("start-animation")) {
				setTimeout(function () {
					$this.addClass("start-animation");
				}, 100 * i);
			}
		});
	}
})

if(!dtGlobals.isMobile){
	$("body").addClass("no-mobile");
};
if(dtGlobals.isiPhone){
	$("body").addClass("is-iphone");	
};

animated_contents();
if (!$("html").hasClass("old-ie")){
	$(window).on("scroll", function () {
		animated_contents();
	});
};*/

/*Animated content: end*/

 

/* !- Accordion Toggle Tooltip */
$(".st-toggle").toggle();
$(".st-accordion").dtAccordion({
	open            : 0,
	oneOpenedItem : true
});
simple_tooltip(".shortcode-tooltip","shortcode-tooltip-content");
/*Accordion Toggle Tooltip: end*/

/* !- Grayscale */
$(".filter-grayscale .slider-masonry").on("mouseenter tap", function(e) {
	if(e.type == "tap") {
		e.stopPropagation();
		//e.preventDefault();
	}
	$(this).addClass("dt-hovered");
});

$(".filter-grayscale .slider-masonry").on("mouseleave", function(e) {
	$(this).removeClass("dt-hovered");
});

/* Grayscale: end */

/* !- Fancy grid */

$.fn.fancyGrid = function(options) {
	return this.each(function() {

		var	defaults = {
				setWidth: true,
				setHeight: false,
				setLineHeight: false,
				cellsSelector: "",
				contentSelector: "",
				borderBoxSelector: "",
				maintainBorders: false,
				maintainImages: false,
				minColWidth: 150,
				oneByOne: true,
			},
			settings = $.extend({}, defaults, options),
			$gridContainer	= $(this),
			$cells = settings.cellsSelector ? $(settings.cellsSelector, $gridContainer) : $gridContainer.children();


		if ($cells.length < 1) return false;

		var calcWidth = function() {
			var	containerWidth = $gridContainer.width();

			var $this = $($cells[0]),
				curW = $this.width(),
				basicW,
				basicDenom = $gridContainer.data("basicDenom"),
				basicCSS = $gridContainer.data("basicCSS"),
				basicClass =  $gridContainer.data("basicClass");

			if (!basicDenom){
				if ($this.hasClass("wf-1-6")) {
					basicDenom = 6;
					basicCSS = "16.6667%";
					basicClass = "wf-1-6";
				}
				else if ($this.hasClass("wf-1-5")) {
					basicDenom = 5;
					basicCSS = "20%";
					basicClass = "wf-1-5";
				}
				else if ($this.hasClass("wf-1-4")) {
					basicDenom = 4;
					basicCSS = "25%";
					basicClass = "wf-1-4";
				}
				else if ($this.hasClass("wf-1-3")) {
					basicDenom = 3;
					basicCSS = "33.3333%";
					basicClass = "wf-1-3";
				}
				else if ($this.hasClass("wf-2-4") || $this.hasClass("wf-1-2")) {
					basicDenom = 2;
					basicCSS = "50%";
					basicClass = "wf-1-2";
				}
				else if ($this.hasClass("wf-1")) {
					basicDenom = 1;
					basicCSS = "100%";
					basicClass = "wf-1";
				};
			};

			$gridContainer.data("basicDenom", basicDenom);
			$gridContainer.data("basicCSS", basicCSS);
			$gridContainer.data("basicClass", basicClass);

			basicW = containerWidth/basicDenom;

			if (settings.oneByOne) {
				if (basicW < settings.minColWidth) {
					$cells.css({ 'width': 100/Math.floor(containerWidth/settings.minColWidth)+'%' });
				} else {
					$cells.css("width", basicCSS);
				}
			}
			else {
				if (basicW < 150 && containerWidth/2 > 150) {
					$cells.css("width", "50%");
				}
				else if (basicW < 150 && containerWidth/2 <= 150) {
					$cells.css("width", "100%");
				}
				else {
					$cells.css("width", basicCSS);
				};
			};
		};

		var calcHeight = function() {
			var	topPosition = 0,
				totalRows = 0,
				currentRowStart = -1.687, // It's a kinda magic!
				currentRow = -1,
				rows = [],
				tallest =  [];

				$cells.each(function() {
		
					var $this = $(this),
						currentHeight = settings.contentSelector ? $(settings.contentSelector, $this).outerHeight(true) : $this.children().outerHeight(true);

					topPostion = $this.position().top;

//console.log("topPostion: "+topPostion);

					if (currentRowStart != topPostion) {
						// We just came to a new row
						// Set the variables for the new row
						currentRow++;
						currentRowStart = topPostion;
						tallest[currentRow] = currentHeight;
						rows.push([]);
						rows[currentRow].push($this);
//console.log("currentRowStart != topPostion")
		
					} else {					
						if (currentRow < 0) {
							currentRow = 0;
							rows.push([]);

							/*
							console.log("ahtung! topPostion: "+topPostion);
							console.log("currentRowStart = "+currentRowStart);
							*/

						}
						// Another div on the current row. Add it to the list and check if it's taller
						rows[currentRow].push($this);
						tallest[currentRow] = (tallest[currentRow] < currentHeight) ? (currentHeight) : (tallest[currentRow]);
//console.log("currentRowStart == topPostion")
					}

				});

				totalRows = rows.length;


//console.log("Rows : "+totalRows);
//console.log(tallest);

		
				for (i = 0; i < totalRows; i++) {
					var inCurrentRow = rows[i].length;
					
					for (j = 0; j < inCurrentRow; j++) {

						settings.borderBoxSelector ? $(settings.borderBoxSelector, rows[i][j]).css("height", tallest[i]) : rows[i][j].css("height", tallest[i]);

						if (settings.setLineHeight)
						settings.borderBoxSelector ? $(settings.borderBoxSelector, rows[i][j]).css("line-height", tallest[i] + 'px') : rows[i][j].css("line-height", tallest[i] + 'px');

						if (settings.maintainBorders && j == 0) {
							rows[i][j].addClass("border-left-none");
						} else {
							rows[i][j].removeClass("border-left-none");
						}
						
						if (settings.maintainBorders && i == totalRows - 1) {
							rows[i][j].addClass("border-bottom-none");
						} else {
							rows[i][j].removeClass("border-bottom-none");
						}

					}
				}

			}


		if (settings.setWidth) calcWidth();
		if (settings.setHeight || settings.setLineHeight) calcHeight();

		if (settings.maintainImages) {
			$("img", $cells).loaded(null, function() {
				$gridContainer.addClass("grid-ready");
				if (settings.setHeight || settings.setLineHeight) calcHeight();
			}, true);
		} else {
			$gridContainer.addClass("grid-ready");
		}

		$(window).on("debouncedresize", function() { // ! needs to be !changed
			if (settings.setWidth) calcWidth();
			if (settings.setHeight || settings.setLineHeight) calcHeight();
		});

	});
}

$(".items-grid").fancyGrid({
	setWidth: true,
	setHeight: true,
	maintainBorders: true,
	contentSelector: "article",
	borderBoxSelector: ".borders",
	minColWidth: 180
});

$(".benefits-grid").fancyGrid({
	setWidth: true,
	setHeight: true,
	maintainBorders: true,
	maintainImages: true,
	contentSelector: ".borders > div",
	borderBoxSelector: ".borders",
	minColWidth: 200,
	oneByOne: false
});
$(".logos-grid").fancyGrid({
	setWidth: true,
	setHeight: true,
	setLineHeight: true,
	maintainBorders: true,
	maintainImages: true,
	contentSelector: ".borders > a img",
	borderBoxSelector: ".borders",
	minColWidth: 130
});

/* Fancy grid: end */


/* !Sandbox */
/* !Fancy header*/
var fancyFeaderOverlap = $(".transparent #fancy-header").exists();

function fancyFeaderCalc() {
	if (fancyFeaderOverlap) {
		$(".transparent #fancy-header > .wf-wrap").css({
			"padding-top" : $("#header").height()
		});
	}
}

fancyFeaderCalc();

/* Fancy header:end*/
/* !Rolovers*/
$(".rollover, .rollover-video, .post-rollover, .swiper-slide .link").each(function(){
	var $this = $(this);
	$this.append("<i></i>");
});
$(".rollover, .post-rollover").not(".no-avatar").each(function(){
	var $this = $(this);
	if( $("html").hasClass("old-ie") ){
		$this.hover(function(){
			$("> i, .rollover-thumbnails", this).stop(true).fadeIn();
		},function(){			
			$(" > i, .rollover-thumbnails", this).stop(true).fadeOut();
		});
	}
});
$(".fs-entry, .rollover-project .link, .swiper-slide").each(function(){
	var $this = $(this);
	if( $("html").hasClass("old-ie") ){
		$(".fs-entry .link, .rollover-project .link i, .swiper-slide .link").stop(true).fadeOut();
		$this.hover(function(){
			$(" > .link, i", this).css('display', 'block');
		},function(){			
			$(" > .link, i", this).css('display', 'none');
		});
	}
});
/* Rolovers:end*/

/* !Share links*/
$(".entry-share a").each(function(){
	var caroufredselTimeout;
	var $this = $(this);
	$this.find(".share-content").css({
		'margin-left': - $this.find(".share-content").width()/2
	})
	
		$this.hover(function() {
			clearTimeout(caroufredselTimeout);
			caroufredselTimeout = setTimeout(function() {
				$this.find(".share-content").stop(true, true).fadeIn(200);
			}, 200);
		}, function(){
			clearTimeout(caroufredselTimeout);
			$this.find(".share-content").fadeOut(200);
		});
	
});
/*Share links: end*/
function changeFilter(){
	$(".filter-categories").each(function(){
		var width = 0;
		$(".filter-categories a").each(function(){
			var $_this = $(this);
				width += $_this.innerWidth();
		});
		if( width > $(this).width() ){
			$(this).addClass("new-style")
		}else{
			$(this).removeClass("new-style")
		}
	});
};
changeFilter();

/* !Blur */
if(!dtGlobals.isMobile){

	$(".image-blur .fs-entry-img:not(.shortcode-instagram .fs-entry-img), .image-blur .shortcode-instagram a, .image-blur .rollover-project a, .image-blur .rollover, .image-blur .post-rollover, .image-blur .rollover-video").each(function(){
		var $_this = $(this),
			img = $_this.find("> img");
		$_this.addClass('blur-this')
		img.clone().addClass("blur-effect").css('opacity', '').prependTo(this);
				
		var blur_this = $(".blur-effect", this);

		blur_this.each(function(index, element){
			if (img[index].complete == true) {
				Pixastic.process(blur_this[index], "blurfast", {amount:0.3});
			}else {
				blur_this.load(function () {
					Pixastic.process(blur_this[index], "blurfast", {amount:0.3});
				});
			}
		});
	});
};

/* Blur: end */
$(window).on("debouncedresize", function( event ) {
	dtGlobals.resizeCounter++;
	calcPics();
	moveOffset();
	fancyFeaderCalc();
	changeFilter();
	$(".slider-wrapper").not(".full").each(function(){
		var scroller = $(this).children(".frame").data("theSlider");
		scroller.update();
	});

}).trigger( "debouncedresize" );

/* !Beautiful loading */
/*
dtGlobals.imgLoaded = setTimeout(function() {
	$("body").append("<style>img {opacity: 1}</style>");
}, 20000);

$("img").not(".no-touch .animate-element, .no-touch .animate-element img, .rev_slider_wrapper img").loaded(
	function () {
		$(this).css("opacity", 1);
	},
	function () {
		clearTimeout(dtGlobals.imgLoaded);
	},
	true
);*/

/* Beautiful loading: end */


/* !Smart floating menu */

if (smartMenu) {
	var scrTop = 0,
		scrDir = 0,
		scrUp = false,
		scrDown = false,
		$header = $("#main-nav"),
		$parent = $header.parent(),
		$phantom = $('<div id="phantom" />').appendTo("body"),
		$headerH = $header.height(),
		isMoved = false,
		breakPoint = 0,
		threshold = $("#header").offset().top + $("#header").height(),
		doScroll = false;

	if ($("#wpadminbar").exists()) { $phantom.css("top", "28px"); };

	$(window).on("debouncedresize", function() {
		$headerH = $header.height();
	});

	$(window).on("scroll", function() {
		var tempCSS = {},
			tempScrTop = $(window).scrollTop();

		scrDir = tempScrTop - scrTop;


		if (tempScrTop > threshold && isMoved === false) {
			$phantom.css("opacity", 1);
			$header.appendTo($phantom);
			isMoved = true;
		}
		else if (tempScrTop <= threshold && isMoved === true) {
			$header.appendTo($parent);
			$phantom.css("opacity", 0);
			isMoved = false;
		};
		scrTop = $(window).scrollTop();
	});
}
/*$(".logo-left #navigation .mini-search").insertAfter(".logo-left #navigation").css("visibility","visible");*/
/* Smart floating menu: end */

$("#header .mini-search .field").fadeOut(100, function(){
	$("#header .mini-search .field").css("visibility", "visible")
});
$('body').on("click", function(e){
	var target = $(e.target);
	if(!target.is("#header .mini-search .field")) {
		$("#header .searchform .submit").removeClass("act");
		$("#header .mini-search .field").fadeOut(100);
	}
})
$("#header .searchform .submit").on("click", function(e){
	e.preventDefault();
	e.stopPropagation();
	var $_this = $(this);
	if($_this.hasClass("act")){
		$_this.removeClass("act");
		$_this.siblings(".searchform-s").fadeOut(200);
	}else{
		$_this.addClass("act");
		$_this.siblings(".searchform-s").fadeIn(250);
	}
});

 $(window).scroll(function () {
	if ($(this).scrollTop() > 500) {
		$('.scroll-top').removeClass('off').addClass('on');
	}
	else {
		$('.scroll-top').removeClass('on').addClass('off');
	}
});
$(".scroll-top").click(function(e) {
	e.preventDefault();
	$("html, body").animate({ scrollTop: 0 }, "slow");
	return false;
});
if(!dtGlobals.isMobile){
	$('.stripe-parallax-bg, .fancy-parallax-bg').each(function(){
		var $_this = $(this),
			speed_prl = $_this.data("prlx-speed");
		$(this).parallax("50%", speed_prl);
		$('.stripe-parallax-bg').addClass("parallax-bg-done");
	});
}
//Shopping cart top bar

	var menuTimeoutShow,
		menuTimeoutHide;

	$(".shopping-cart").on("mouseenter tap", function(e) {
		if(e.type == "tap") e.stopPropagation();

		var $this = $(this);
		$this.addClass("dt-hovered");
		if ($("#page").width() - ($this.children('.shopping-cart-inner').offset().left - $("#page").offset().left) - 230 < 0) {
			$this.children('.shopping-cart-inner').addClass("right-overflow");
		}

		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutShow = setTimeout(function() {
			if($this.hasClass("dt-hovered")){
				$this.children('.shopping-cart-inner').stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 200);
			}
		}, 350);
	});

	$(".shopping-cart").on("mouseleave", function(e) {
		var $this = $(this);
		$this.removeClass("dt-hovered");

		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutHide = setTimeout(function() {
			if(!$this.hasClass("dt-hovered")){
				$this.children('.shopping-cart-inner').stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.children('.shopping-cart-inner').removeClass("right-overflow");
					}
				}, 400);
				
			}
		}, 200);

	});

if(!dtGlobals.isMobile){
	var j = -1;
	$("#fancy-header .fancy-title:not(.start-animation), #fancy-header .fancy-subtitle:not(.start-animation), #fancy-header .breadcrumbs:not(.start-animation)").each(function () {
		var $this = $(this);
		var animateTimeout;
		if (!$this.hasClass("start-animation") && !$this.hasClass("start-animation-done")) {
			$this.addClass("start-animation-done");
			j++;
			setTimeout(function () {
				$this.addClass("start-animation");
				
			}, 300 * j);
		};
	});
};

/* Sandbox: end */

});



/* !Animation Core */

/*
 * Viewport - jQuery selectors for finding elements in viewport
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *  http://www.appelsiini.net/projects/viewport
 *
 */

(function($) {

	$.belowthefold = function(element, settings) {
		var fold = $(window).height() + $(window).scrollTop();
		return fold <= $(element).offset().top - settings.threshold;
	};
	$.abovethetop = function(element, settings) {
		var top = $(window).scrollTop();
		return top >= $(element).offset().top + $(element).height() - settings.threshold;
	};
	$.rightofscreen = function(element, settings) {
		var fold = $(window).width() + $(window).scrollLeft();
		return fold <= $(element).offset().left - settings.threshold;
	};
	$.leftofscreen = function(element, settings) {
		var left = $(window).scrollLeft();
		return left >= $(element).offset().left + $(element).width() - settings.threshold;
	};
	$.inviewport = function(element, settings) {
		return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
	};

	$.extend($.expr[':'], {
		"below-the-fold": function(a, i, m) {
			return $.belowthefold(a, {threshold : 0});
		},
		"above-the-top": function(a, i, m) {
			return $.abovethetop(a, {threshold : 0});
		},
		"left-of-screen": function(a, i, m) {
			return $.leftofscreen(a, {threshold : 0});
		},
		"right-of-screen": function(a, i, m) {
			return $.rightofscreen(a, {threshold : 0});
		},
		"in-viewport": function(a, i, m) {
			return $.inviewport(a, {threshold : -30});
		}
	});

})(jQuery);


jQuery(document).ready(function($) {

	if(!dtGlobals.isMobile){
		$("body").addClass("no-mobile");
	};
	if(dtGlobals.isiPhone){
		$("body").addClass("is-iphone");
	};

	// !- Skills
	$.fn.animateSkills = function() {
		$(".skill-value", this).each(function () {
			var $this = $(this),
				$this_data = $this.data("width");

			$this.css({
				width: $this_data + '%'
			});
		});
	};

	// !- Animation "onScroll" loop
	function doAnimation() {
		if(!dtGlobals.isMobile){
			var j = -1;
			$(".animate-element:not(.start-animation):in-viewport").each(function () {
				var $this = $(this);
	
				if (!$this.hasClass("start-animation") && !$this.hasClass("animation-triggered")) {
					$this.addClass("animation-triggered");
					j++;
					setTimeout(function () {
						$this.addClass("start-animation");
						if($this.hasClass("skills")){
							$this.animateSkills();
						};
					}, 200 * j);
				};
			});
		}
		else {
			$(".skills").animateSkills();
		};
		if($("html").hasClass("old-ie")){
			$(".skills").animateSkills();
		};
	};


	// !- Fire animation
	doAnimation();
	if (!dtGlobals.isMobile && !$("html").hasClass("old-ie")){
		$(window).on("scroll", function () {
			doAnimation();
		});
	};

	// !... and ensute it will work in tabs
	$(".tab").on("click", function(){
		if(!dtGlobals.isMobile){
			$(".animate-element", this).each(function (i) {
				var $this = $(this);
				if (!$this.hasClass("start-animation")) {
					setTimeout(function () {
						$this.addClass("start-animation");
					}, 100 * i);
				}
			});
		}
	});

});