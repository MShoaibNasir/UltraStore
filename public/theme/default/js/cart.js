(function($) {
   "use strict";

    $(document).on('click','.add_to_cart',function(event){
    	event.preventDefault();
    	var elem = $(this);
    	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

    	var product_type = $(this).data('type');

    	if(product_type != 'variable_product'){
    		$.ajax({
    			url: $(this).attr("href"),
    			method: "POST",
    			data: { 
					'quantity': typeof $('input[name="quantity"]').val() === "undefined" ? 1 : $('input[name="quantity"]').val()
				}, 
				beforeSend: function(){
					$(elem).find('i').remove();
					$(elem).html($(elem).html() + '<i class="fa fa-circle-o-notch fa-spin ml-2"></i>');
				},success: function(data){
					$(elem).find('i').remove();
					$(elem).html($(elem).html() + '<i class="fa fa-check text-success ml-2"></i>');
					
					var json = JSON.parse(JSON.stringify(data));

					if(json['result'] == true){
						//Update Dropdown Cart
						$("#mini-cart").html(json['data']);
						$("#mobile-cart .total-count").html(json['total_items']);
					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});
					}
	
				},
				error: function (request, status, error) {
					console.log(request.responseText);
				}
    		});
    	}else{
    		$.ajax({
    			url: $(this).attr("href"),
    			method: "POST",
    			data: { 
					'quantity': $('input[name="quantity"]').val(),
					'product_option[]': $('.select_product_option').serialize(),
				}, 
				beforeSend: function(){
					$(elem).find('i').remove();
					$(elem).html($(elem).html() + '<i class="fa fa-circle-o-notch fa-spin ml-2"></i>');
				},success: function(data){
					$(elem).find('i').remove();
					$(elem).html($(elem).html() + '<i class="fa fa-check text-success ml-2"></i>');
					
					var json = JSON.parse(JSON.stringify(data));
					
					if(json['result'] == true){
						//Update Dropdown Cart
						$("#mini-cart").html(json['data']);
						$("#mobile-cart .total-count").html(json['total_items']);
					}else{
						$.toast({
							text: json['message'],
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});
					}
				},
				error: function (request, status, error) {
					console.log(request.responseText);
				}
    		});
    	}

    });

    $(document).on('click','#update-cart',function(event){
    	var elem = $(this);

    	$.ajax({
    		method: "POST",
    		url: $("#shopping-cart-form").attr('action'),
    		data: $("#shopping-cart-form").serialize(),
    		beforeSend: function(){
				$(elem).find('i').remove();
				$(elem).html($(elem).html() + '<i class="fa fa-circle-o-notch fa-spin ml-2"></i>');
    		},
    		success: function(data){
				$(elem).find('i').remove();
				
				var json = JSON.parse(JSON.stringify(data));
				
				if(json['result'] == true){
					//Update Shopping Cart
					$(".shopping-cart").html(json['shopping_cart']);
					$("#mini-cart").html(json['mini_cart']);
					$("#mobile-cart .total-count").html(json['total_items']);
					
					//Trigger Cart Updated event
					$(document).trigger('cart-updated');
				}else{
					$.toast({
						text: json['message'],
						showHideTransition: 'slide',
						icon: 'error',
						position : 'top-right' 
					});

				}
				
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});

    });

    $(document).on('change','.select-shipping-method',function(event){
    	//location.href = _url + '/shipping_method/' + $(this).val();
    	$.ajax({
    		url: _url + '/shipping_method/' + $(this).val(),
    		beforeSend: function(){
				$(".preloader").fadeIn();
    		},
    		success: function(data){
				$(".preloader").fadeOut();
				
				//Update Shopping Cart
				$(".shopping-cart").html(data);
    		},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
    	});
    });

    //Remove Cart Item
    $(document).on('click','.remove-cart-item',function(event){  	
    	event.preventDefault();

    	var elem = $(this);

    	$.ajax({
    		url: $(this).attr('href'),
    		beforeSend: function(){
				$(elem).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
    		},
    		success: function(data){
    			
				var json = JSON.parse(JSON.stringify(data));

    			if(json['result'] == true){
					//Update Shopping Cart
					$(".shopping-cart").html(json['shopping_cart']);
					$("#mini-cart").html(json['mini_cart']);
					$("#mobile-cart .total-count").html(json['total_items']);
					
					//Trigger Cart Updated event
					$(document).trigger('cart-updated');
				}

    		},
			error: function (request, status, error) {
				$(elem).html('<i class="ti-trash remove-icon"></i>');
				console.log(request.responseText);
			}
    	});
    });

    if($('.ratng-bar').length > 0){
    	$('.ratng-bar').barrating({
			theme: 'css-stars',
			initialRating: '5',
		});
    }


})(jQuery);  