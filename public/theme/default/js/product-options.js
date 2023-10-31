(function($) {
   "use strict";

 	$(document).on('change','.select_product_option',function(){

     	if($(this).val() != ""){
			$.ajax({
				url: $("#product-variation").attr('action'),
				method: "POST",
				data: $("#product-variation").serialize(),
				beforeSend: function(){
					$('.discount').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
				}, 
				success: function(data){
					var result = JSON.parse(data);

					if(result.result == false){
						location.reload();
					}else if(result.result == true){
						
						if(result.is_available == false){
							alert($lang_item_not_available);
							$(".select_product_option").prop("selectedIndex", 0).change();
							return;
						}

						if(result.special_price != ''){
							$('.discount, .ac-price').html(result.special_price);
						}else{
							$('.discount, .ac-price').html(result.price);
						}
					}

				}
			});
     	}
     	 	
    });

 })(jQuery);