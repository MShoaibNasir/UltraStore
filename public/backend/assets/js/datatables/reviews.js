(function($) {
	"use strict";

	var product_reviews_table =  $('#product_reviews_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + '/product_reviews/get_table_data',
		"columns" : [
			{ data : 'id', name : 'id' },
			{ data : 'user.name', name : 'user.name' },
			{ data : 'product.translation.name', name : 'product.translation.name' },
			{ data : 'rating', name : 'rating' },
			{ data : 'comment', name : 'comment' },
			{ data : 'is_approved', name : 'is_approved' },
			{ data : "action", name : "action" },
		],
		responsive: true,
		"bStateSave": true,
		"bAutoWidth":false,	
		"ordering": false,
		"language": {
		   "decimal":        "",
		   "emptyTable":     $lang_no_data_found,
		   "info":           $lang_showing + " _START_ " + $lang_to + " _END_ " + $lang_of + " _TOTAL_ " + $lang_entries,
		   "infoEmpty":      $lang_showing_0_to_0_of_0_entries,
		   "infoFiltered":   "(filtered from _MAX_ total entries)",
		   "infoPostFix":    "",
		   "thousands":      ",",
		   "lengthMenu":     $lang_show + " _MENU_ " + $lang_entries,
		   "loadingRecords": $lang_loading,
		   "processing":     $lang_processing,
		   "search":         $lang_search,
		   "zeroRecords":    $lang_no_matching_records_found,
		   "paginate": {
			  "first":      $lang_first,
			  "last":       $lang_last,
			  "next":       $lang_next,
			  "previous":   $lang_previous
		   }
		}  
	});

	$( document ).on('ajax-screen-submit', function() {
		product_reviews_table.draw();
	});

	$(document).on('change','#bulk_action', function(){
		if($(this).val() != ""){
			if($(this).val() == 'delete'){
				Swal.fire({
					  	title: $lang_alert_title,
					  	text: $lang_alert_message,
					  	icon: 'warning',
					  	showCancelButton: true,
					  	confirmButtonColor: '#3085d6',
					  	cancelButtonColor: '#d33',
					  	confirmButtonText: $lang_confirm_button_text,
					  	cancelButtonText: $lang_cancel_button_text
				}).then((result) => {
					if (result.value) {
						$("#bulk_action_form").submit();
					}
				});
			}else{
				$("#bulk_action_form").submit();
			}
	
		}
	});

})(jQuery); 