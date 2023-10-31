(function($) {
    "use strict";
    
    $(document).on('click','#add_more_option',function(){
    	var new_option = $("#option").clone();
    	new_option.removeAttr('id');
    	new_option.find('input').val("");
    	new_option.find('input').removeAttr("style");
    	new_option.prepend('<div class="col-md-12"><i class="far fa-times-circle float-right text-danger remove-product-option"></i></div>');
    	$(this).before(new_option);
    });

     $(document).on('click','.remove-product-option',function(){
     	$(this).parent().parent().remove();
     });

     $(document).on('change','#product_type',function(){
     	
     	if($(this).val() == 'digital_product'){
     		$("#digital_file").removeClass('d-none');
     	}else{
     		$("#digital_file").addClass('d-none');
     	}

     	if($(this).val() == 'variable_product'){
     		$(".variable-product").removeClass('d-none');
     	}else{
     		$(".variable-product").addClass('d-none');
     	}
     	
     });

     $(document).on('change','#manage_inventory',function(){
		if($(this).val() == 1){
     		$(".inventory-quantity").removeClass('d-none');
     	}else{
     		$(".inventory-quantity").addClass('d-none');
     	}
     });


     $(document).on('click','#generate_variations',function(e){
		//Validate Input
		var error = false;
		$('.variable-product .product_option').each(function(index, value ) {
            if($(this).val() == ''){
				$(this).css('border','2px solid red');
				error = true;
            }else{
            	$(this).css('border','2px solid #ececec');
            }
		});

		$('.variable-product .product_option_value').each(function(index, value ) {
            if($(this).val() == ''){
				$(this).css('border','2px solid red');
				error = true;
            }else{
            	$(this).css('border','2px solid #ececec');
            }

            var input = "";
            var array = $(this).val().split(",");
			$.each(array,function(i){
			   input += array[i].trim() + ',';
			});
			$(this).val(input.slice(0, -1));
		});

		if(error == true){
			return;
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: _url + '/products/generate_variations',
			method: 'POST',
			data: { 
				'product_option[]': $('input[name="product_option[]"]').serialize(),  
				'product_option_value[]': $('input[name="product_option_value[]"]').serialize() 
			}, 
			beforeSend: function(){

			}, 
			success: function(data){
				var json = JSON.parse(data);

				$("#variations-prices-table > tbody").html("");
				$("#variations-prices-table > thead").html("");


				var header = '';
				$('.variable-product .product_option').each(function(index, value ) {
					header += '<th>'+ $(this).val() +'</th>';
				});
				header += '<th>'+ $lang_price +'</th>';
				header += '<th>'+ $lang_special_price +'</th>';
				header += '<th class="text-center">'+ $lang_is_available +'</th>';
				header += '</th>';

				$("#variations-prices-table > thead").html(header);

				$.each(json,function(index, value){
					var column = '<tr>';
					$.each(value,function(i, v){
						column += '<td>'+ v.replace("%20", " ") +'</td>';
					});
					column += '<td><input type="text" name="variation_price[]" class="form-control" value="'+ $('input[name="price"]').val() +'" placeholder="Regular Price"></td>';
					column += '<td><input type="text" name="variation_special_price[]" class="form-control" value="'+ $('input[name="special_price"]').val() +'" placeholder="Special Price"></td>';
					column += '<td class="text-center"><input type="checkbox" name="is_available[]" value="1" checked></td>';
					column += '</tr>';

					$("#variations-prices-table > tbody").append(column);
				});

			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});
     });

     //Update Product Variations
     $('#update_product .product_option, #update_product .product_option_value, #update_product #variations-prices-table input').prop('disabled',true);

     $(document).on('click','#update_variation',function(){
     	
     	if($(this).is(":checked")){
     		$('#update_product .product_option, #update_product .product_option_value, #update_product #variations-prices-table input').prop('disabled',false);
     	}else{
     		$('#update_product .product_option, #update_product .product_option_value, #update_product #variations-prices-table input').prop('disabled',true);
     	}
     	
     });

 })(jQuery);   