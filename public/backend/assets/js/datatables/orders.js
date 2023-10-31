(function($) {
    "use strict";

    $('#orders_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + '/orders/get_table_data',
		"columns" : [
			{ data : 'id', name : 'id' },
			{ data : 'created_at', name : 'created_at' },
			{ data : 'customer_name', name : 'customer_name' },
			{ data : 'customer_email', name : 'customer_email' },
			{ data : 'total', name : 'total' },
			{ data : 'status', name : 'status' },
			{ data : 'payment', name : 'payment' },
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

 })(jQuery);       