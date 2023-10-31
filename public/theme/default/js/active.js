 (function($) {
    "use strict";
     $(document).on('ready', function() {	
		
		/*====================================
			Mobile Menu
		======================================*/ 	
		$('.menu').slicknav({
			prependTo:".mobile-nav",
			duration:300,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			closeOnClick:true,
		});
		
		/*====================================
		03. Sticky Header JS
		======================================*/ 
		jQuery(window).on('scroll', function() {
			if ($(this).scrollTop() > 200) {
				$('.header').addClass("sticky");
			} else {
				$('.header').removeClass("sticky");
			}
		});
		
		/*=======================
		  Search JS JS
		=========================*/ 
		$('.top-search a').on( "click", function(){
			$('.search-top').toggleClass('active');
		});
		
		/*=======================
		  Slider Range JS
		=========================*/ 
		$( function() {
			$( "#slider-range" ).slider({
			  range: true,
			  min: $("#slider-range").data('min'),
			  max: $("#slider-range").data('max'),
			  values: [  $("#slider-range").data('min'), $("#slider-range").data('value') ],
			  slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

				$( "#start_price" ).val(ui.values[ 0 ]);
				$( "#end_price" ).val(ui.values[ 1 ]);
			  }
			});

			$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
			  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
		});
		
		/*=======================
		  Home Slider JS
		=========================*/ 
		$('.home-slider').owlCarousel({
			items:1,
			autoplay:true,
			autoplayTimeout:5000,
			smartSpeed: 400,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			autoplayHoverPause:true,
			loop:true,
			nav:true,
			merge:true,
			dots:false,
			navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
			responsive:{
				0: {
					items:1,
				},
				300: {
					items:1,
				},
				480: {
					items:2,
				},
				768: {
					items:3,
				},
				1170: {
					items:4,
				},
			}
		});
		
		/*=======================
		  Popular Slider JS
		=========================*/ 
		$('.popular-slider').owlCarousel({
			items:1,
			autoplay:true,
			autoplayTimeout:5000,
			smartSpeed: 400,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			autoplayHoverPause:true,
			loop:true,
			nav:true,
			merge:true,
			dots:false,
			navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
			responsive:{
				0: {
					items:1,
				},
				300: {
					items:1,
				},
				480: {
					items:2,
				},
				768: {
					items:3,
				},
				1170: {
					items:4,
				},
			}
		});
		
		/*===========================
		  Quick View Slider JS
		=============================*/ 
		$('.quickview-slider-active').owlCarousel({
			items:1,
			autoplay:true,
			autoplayTimeout:5000,
			smartSpeed: 400,
			autoplayHoverPause:true,
			nav:true,
			loop:true,
			merge:true,
			dots:false,
			navText: ['<i class=" ti-arrow-left"></i>', '<i class=" ti-arrow-right"></i>'],
		});
		
		/*===========================
		  Home Slider 4 JS
		=============================*/ 
		$('.home-slider-4').owlCarousel({
			items:1,
			autoplay:true,
			autoplayTimeout:5000,
			smartSpeed: 400,
			autoplayHoverPause:true,
			nav:true,
			loop:true,
			merge:true,
			dots:false,
			navText: ['<i class=" ti-arrow-left"></i>', '<i class=" ti-arrow-right"></i>'],
		});
		
		/*====================================
		14. CountDown
		======================================*/ 
		$('[data-countdown]').each(function() {
			var $this = $(this),
				finalDate = $(this).data('countdown');
			$this.countdown(finalDate, function(event) {
				$this.html(event.strftime(
					'<div class="cdown"><span class="days"><strong>%-D</strong><p>Days.</p></span></div><div class="cdown"><span class="hour"><strong> %-H</strong><p>Hours.</p></span></div> <div class="cdown"><span class="minutes"><strong>%M</strong> <p>MINUTES.</p></span></div><div class="cdown"><span class="second"><strong> %S</strong><p>SECONDS.</p></span></div>'
				));
			});
		});
		
		/*====================================
		16. Flex Slider JS
		======================================*/
		(function($) {
			'use strict';	
				$('.flexslider-thumbnails').flexslider({
					animation: "slide",
					controlNav: "thumbnails",
				});
		})(jQuery);
		
		/*====================================
		  Cart Plus Minus Button
		======================================*/
		var CartPlusMinus = $('.cart-plus-minus');
		CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
		CartPlusMinus.append('<div class="inc qtybutton">+</div>');
		$(".qtybutton").on("click", function() {
			var $button = $(this);
			var oldValue = $button.parent().find("input").val();
			if ($button.text() === "+") {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				// Don't allow decrementing below zero
				if (oldValue > 0) {
					var newVal = parseFloat(oldValue) - 1;
				} else {
					newVal = 1;
				}
			}
			$button.parent().find("input").val(newVal);
		});
		
		/*=======================
		  Extra Scroll JS
		=========================*/
		$('.scroll').on("click", function (e) {
			var anchor = $(this);
				$('html, body').stop().animate({
					scrollTop: $(anchor.attr('href')).offset().top - 0
				}, 900);
			e.preventDefault();
		});
		
		/*===============================
		10. Checkbox JS
		=================================*/  
		$('input[type="checkbox"]').change(function(){
			if($(this).is(':checked')){
				$(this).parent("label").addClass("checked");
			} else {
				$(this).parent("label").removeClass("checked");
			}
		});
		
		/*==================================
		 12. Product page Quantity Counter
		 ===================================*/
		$('.qty-box .quantity-right-plus').on('click', function () {
			var $qty = $('.qty-box .input-number');
			var currentVal = parseInt($qty.val(), 10);
			if (!isNaN(currentVal)) {
				$qty.val(currentVal + 1);
			}
		});
		$('.qty-box .quantity-left-minus').on('click', function () {
			var $qty = $('.qty-box .input-number');
			var currentVal = parseInt($qty.val(), 10);
			if (!isNaN(currentVal) && currentVal > 1) {
				$qty.val(currentVal - 1);
			}
		});
		
		/*=====================================
		15.  Video Popup JS
		======================================*/ 
		$('.video-popup').magnificPopup({
			type: 'iframe',
			removalDelay: 300,
			mainClass: 'mfp-fade'
		});
		
		/*====================================
			Scroll Up JS
		======================================*/
		$.scrollUp({
			scrollText: '<span><i class="fa fa-angle-up"></i></span>',
			easingType: 'easeInOutExpo',
			scrollSpeed: 900,
			animation: 'fade'
		});  
		
	});
	
	/*====================================
	18. Nice Select JS
	======================================*/	
	$('.nice-select').niceSelect();

	/*=====================================
	 Active Primary Menu
	======================================*/ 
	$('.main-menu li').each(function(index, elem){	
		var nav_link = $(elem).find('a').attr('href');
		if(nav_link == location.href || nav_link + '/' == location.href ){
			$(elem).addClass('active');
		}
	});
	
	/*=====================================
	 Comment Form
	======================================*/ 
	$(document).on('click','.reply-btn-toggle', function(event){
		event.preventDefault();
		
		$(this).parent().next('.reply-form').toggleClass('d-none'); 
	});

	$(document).on('submit','.comment-form', function(event){
		event.preventDefault();
		
		var commentForm = $(this);

    	$.ajax({
    		method: "POST",
    		url: $(commentForm).attr('action'),
    		data: $(commentForm).serialize(),
    		beforeSend: function(){
				$('.preloader').fadeIn();
    		},
    		success: function(data){
				$('.preloader').fadeOut();

				var json = JSON.parse(JSON.stringify(data));
				
				if(json['result'] == true){	
					$("#comment-list").html(json['comments']);	
					$(".comments-count").html(json['total_comments']);	
					$(commentForm)[0].reset();		
				}else{
					if(Array.isArray(json['message'])){
						jQuery.each( json['message'], function( i, val ) {
							$.toast({
								text: val,
								showHideTransition: 'slide',
								icon: 'error',
								position : 'top-right' 
							});
						});

					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});	
					}
				}		
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});
	});

	/*=====================================
	 Reviews Form
	======================================*/ 
	$(document).on('submit','.reviews-form', function(event){
		event.preventDefault();
		
		var reviewsForm = $(this);

    	$.ajax({
    		method: "POST",
    		url: $(reviewsForm).attr('action'),
    		data: $(reviewsForm).serialize(),
    		beforeSend: function(){
				$('.preloader').fadeIn();
    		},
    		success: function(data){
				$('.preloader').fadeOut();

				var json = JSON.parse(JSON.stringify(data));
				
				if(json['result'] == true){	
					$(".total-reviews").html(json['total_reviews']);	
					$(reviewsForm)[0].reset();
					$.toast({
						text: json['message'],
						showHideTransition: 'slide',
						icon: 'success',
						position : 'top-right' 
					});		
				}else{
					if(Array.isArray(json['message'])){
						jQuery.each( json['message'], function( i, val ) {
							$.toast({
								text: val,
								showHideTransition: 'slide',
								icon: 'error',
								position : 'top-right' 
							});
						});

					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});	
					}
				}		
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});
	});

	/*=====================================
	 Add to WishList
	======================================*/ 
	$(document).on('click','.btn-wishlist', function(event){
		event.preventDefault();
		
		var elem = $(this);

    	$.ajax({
    		url: $(elem).attr('href'),
    		beforeSend: function(){
				$('.preloader').fadeIn();
    		},
    		success: function(data){
				$('.preloader').fadeOut();

				var json = JSON.parse(JSON.stringify(data));
				
				if(json['result'] == true){	
					$("#wishlist-count").html(json['total_items']);	
					$.toast({
						text: json['message'],
						showHideTransition: 'slide',
						icon: 'success',
						position : 'top-right' 
					});		
				}else{
					if(Array.isArray(json['message'])){
						jQuery.each( json['message'], function( i, val ) {
							$.toast({
								text: val,
								showHideTransition: 'slide',
								icon: 'error',
								position : 'top-right' 
							});
						});

					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});	
					}
				}		
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});
	});

	/*=====================================
	 Quick Shop
	======================================*/ 
	$(document).on('click','.quick-shop', function(event){
		event.preventDefault();
		
		var elem = $(this);

    	$.ajax({
    		url: $(elem).attr('href'),
    		beforeSend: function(){
				$('.preloader').fadeIn();
    		},
    		success: function(data){
				$('.preloader').fadeOut();

				var json = JSON.parse(JSON.stringify(data));
				
				if(json['result'] == true){	
					var productView = json['productView'];

					$("#quickShop .modal-body").html(productView);	
					$("#quickShop").modal('show')
				}else{
					if(Array.isArray(json['message'])){
						jQuery.each( json['message'], function( i, val ) {
							$.toast({
								text: val,
								showHideTransition: 'slide',
								icon: 'error',
								position : 'top-right' 
							});
						});

					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});	
					}
				}		
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});
	});

	/*=====================================
	Seacrh Products
	======================================*/ 
	$('.search-products').typeahead({
	    highlight: true,
	},
	{
	  name: 'searchProducts',
	  display: 'name',
	  source: function(query, syncResults, asyncResults) {
	  	var sc = $("#search-category").val();
	    $.get(_url + '/shop/search_products?term=' + query + '&category=' + sc, function(data) {
	       asyncResults(data);
	    });
	  },
	  templates: {
		    empty: [].join('\n'),
		    suggestion: function (data) {
		    	var image = data.image.file_path;
		    	if(typeof image === 'undefined'){
					image = 'media/no-image.png';
		    	}
		        return '<div><a href="'+ _url + '/product/' + data.slug + '">'
		        		+'<div class="search-suggestions d-flex align-items-center">'
			        	+ '<div class="image">'
			        		+ '<img src='+ _url + '/storage/app/' + image + '>'
			        	+ '</div>'
			        	+ '<div class="content">'
			        		+ '<h5>' + data.name + '</h5>'
			        	+ '</div>'
		        		+ '</div></a></div>';
	    	}
	  	},
	});

	/*=====================================
	 Shop Category Accordion Active
	======================================*/ 
	$('#sidebar-category li').each(function(index, elem){
		if($(elem).find('a').attr('class') == 'active'){
			$(this).parent().removeClass('collapse').addClass('collapse-in');
		}
	});
		
	/*=====================================
	 Get State By Country
	======================================*/
	$(document).on('change','.customer-country',function(){
		var elem = $(this);
		var country = $(elem).val();

		if(country != ""){
			var country_id = $(this).find(':selected').data('id');
			$.ajax({
				url: _url + '/get_states/' + country_id,
				beforeSend: function(){
					$("#preloader").fadeIn();
				},success: function(data){
					$("#preloader").fadeOut();
					var json = JSON.parse(data);
			    	$('#state').html('<option value="">' + $("#state option:first").text() + '</option>');
			    	$.each(json, function(i, item) {
					    $('#state').append(`<option value="${item.name}">${item.name}</option>`);
					});
					$('select').niceSelect('update');
				}
			});
		}else{
			$('#state').html('<option value="">' + $("#state option:first").text() + '</option>');
		}
	});

	/*=====================================
	 Shop Filter
	======================================*/
	$(document).on('change','.filter',function(){

		var form = document.createElement("form");
		form.setAttribute('method',"get");

		$('.filter').each(function(index, elem){
			var input = document.createElement("input");
			input.setAttribute('type',"hidden");
			input.setAttribute('name',$(elem).attr('id'));
			input.setAttribute('value',$(elem).val());
			form.appendChild(input);
		});
		
		document.getElementsByTagName('body')[0].appendChild(form);
		form.submit();

	});

	$(document).on('click','#filter_by_price',function(){

		var form = document.createElement("form");
		form.setAttribute('method',"get");

		$('.filter').each(function(index, elem){
			var input = document.createElement("input");
			input.setAttribute('type',"hidden");
			input.setAttribute('name',$(elem).attr('id'));
			input.setAttribute('value',$(elem).val());
			form.appendChild(input);
		});
	
		document.getElementsByTagName('body')[0].appendChild(form);
		form.submit();
	});

	$(document).on('click','#sidebar-expander',function(){
		if($('.shop-sidebar').css("margin-left") == "-15px"){
			$(".shop-sidebar").css('margin-left','-500px');
		}else{
			$(".shop-sidebar").css('margin-left','-15px');	
		}
	});

	/*=====================================
	  Print Command
	======================================*/ 
	$(document).on('click','.print',function(event){
		event.preventDefault();
		var div = "#"+$(this).data("print");	
		$(div).print({
			timeout: 1000,
		});		
	});

	
	/*=====================================
	  Preloader JS
	======================================*/ 	
	//After 2s preloader is fadeOut
	$('.preloader').delay(500).fadeOut('slow');
	setTimeout(function() {
	//After 2s, the no-scroll class of the body will be removed
	$('body').removeClass('no-scroll');
	}, 500); //Here you can change preloader time
	 
})(jQuery);
