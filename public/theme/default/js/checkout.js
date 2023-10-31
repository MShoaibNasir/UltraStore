(function($) {
   "use strict";

    $(document).on('click','#create_account',function(){
    	$(".create_account").toggleClass('d-none');
    });

    $(document).on('change','.select-shipping-method',function(event){
        location.href = _url + '/shipping_method/' + $(this).val();
    });

    $(document).on('change','.select-payment-method',function(event){
        var payment_descriptions = $(this).data('description');
        $("#payment-descriptions").html(payment_descriptions);
    });

    $(document).on('click','#add_new_address',function(event){
        event.preventDefault();
        $(".account_details").toggleClass('d-none');
    });

    $(document).on('submit','#create_address_form',function(event){
        event.preventDefault();

        $.ajax({
            url: _url + '/add_new_address',
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function(){
                $("#preloader").fadeIn();
            },success: function(data){
                $("#preloader").fadeOut();
                var json = JSON.parse(JSON.stringify(data));

                if(json['result'] == "success"){ 
                    $('#create_address_form')[0].reset();
                    $("#state").html("");
                    $(".account_details").toggleClass('d-none');

                    var customer = json['data'];
                    $("#select-shipping-address, #select-billing-address").append('<option value="' + customer['id'] + '" data-state="'+ customer['state'] +'">' + customer['address'] + '</option>');
                    $("#select-shipping-address, #select-billing-address").val(customer['id']);

                    $(".alert-box").html('<div class="alert alert-success">' + json['message'] + '</div>');
                }else{
                    if(Array.isArray(json['message'])){
                        $(".alert-box").html("");
                        
                        $.each( json['message'], function( i, val ) {
                           $(".alert-box").append('<div class="alert alert-success">' + val + '</div>');
                        });       
                    }else{
                        $(".alert-box").html('<div class="alert alert-danger">' + json['message'] + '</div>');
                    }
                }
            },error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    });

    //Set Initial Payment Methods
    //$(".payment-methods > ul >li:first-child input").prop('checked',true);
    //var payment_descriptions = $(".payment-methods > ul >li:first-child input").data('description');
    //$("#payment-descriptions").html(payment_descriptions);

    $(document).on('change','.payment-methods input',function(){
        $(this).val() == 'paypal' ? $("#paypal-container").removeClass('d-none') : $("#paypal-container").addClass('d-none');
        $(this).val() == 'stripe' ? $("#stripe-container").removeClass('d-none') : $("#stripe-container").addClass('d-none');
        $(this).val() == 'razorpay' ? $("#razorpay-container").removeClass('d-none') : $("#razorpay-container").addClass('d-none');
        $(this).val() == 'paystack' ? $("#paystack-container").removeClass('d-none') : $("#paystack-container").addClass('d-none');
        $(this).val() == 'cod' ? $("#cod-container").removeClass('d-none') : $("#cod-container").addClass('d-none');
        $(this).val() == 'bank_transfer' ? $("#bank_transfer-container").removeClass('d-none') : $("#bank_transfer-container").addClass('d-none');
    });

    //Apply Initial Tax
    if($("#select-shipping-address").val() != null && $("#select-billing-address").val() != null ){
        //var shipping_state = $("#select-shipping-address").find(':selected').data('state');
        //var billing_state = $("#select-billing-address").find(':selected').data('state');
        
        var shipping_address_id = $("#select-shipping-address").val();
        var billing_address_id = $("#select-billing-address").val();


        $.ajax({
            url: _url + '/apply_tax/' + shipping_address_id + '/' + billing_address_id,
            beforeSend: function(){
                $(".preloader").fadeIn();
            },
            success: function(data){
                $(".preloader").fadeOut();
                $("#cart-contents").html(data);
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    $(document).on('change','#select-shipping-address, #select-billing-address',function(event){
        if($("#select-shipping-address").val() != '' && $("#select-billing-address").val() != '' ){
            var shipping_state = $("#select-shipping-address").find(':selected').data('state');
            var billing_state = $("#select-billing-address").find(':selected').data('state');

            $.ajax({
                url: _url + '/apply_tax/' + shipping_state + '/' + billing_state,
                beforeSend: function(){
                    $(".preloader").fadeIn();
                },
                success: function(data){
                    $(".preloader").fadeOut();
                    $("#cart-contents").html(data);
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
        }
    });

    $(document).on('change','.select-state-no-auth',function(event){
        if($(this).val() != ''){
            var shipping_state = $(this).val();
            var billing_state = $(this).val();

            $.ajax({
                url: _url + '/apply_tax/' + shipping_state + '/' + billing_state,
                beforeSend: function(){
                    $(".preloader").fadeIn();
                },
                success: function(data){
                    $(".preloader").fadeOut();
                    $("#cart-contents").html(data);
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
        }
    });


    $(document).on('click','#proceed_to_checkout',function(event){
        event.preventDefault();

        var validate = true;

        $("#checkout-form input, #checkout-form select").each(function(){               
            if(($(this).val() === null || $(this).val() === '') && $(this).is(":visible")){
                $(this).addClass('border border-danger');
                validate = false;
            }else{
                $(this).removeClass('border border-danger');
            }
        });

        if(validate == true){
            $("#checkout-form").submit();
        }
    });

})(jQuery);  
