(function($) {
    "use strict";

    var m_type = $('#media_table').data('type');
    var select_type = $('#media_table').data('multiple');

    var _link = _url + '/media/get_table_data';

    if(m_type != ""){
		_link = _link + '/' + m_type;
    }

    if(select_type == true){
    	_link = _link + '/multiple';
    }

	var media_table = $('#media_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _link,
		"columns" : [
			{ data : 'file', name : 'file' },
			{ data : 'filename', name : 'filename' },
			{ data : 'file_type', name : 'file_type' },
			{ data : 'file_size', name : 'file_size' },
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

	$( document ).on('ajax-modal', function() {
		var table = media_table;
		if($("#media-upload").length){
			Dropzone.autoDiscover = false;

			if($("#media-upload").attr('class') == "dropzone dz-clickable"){
				Dropzone.forElement("#media-upload").destroy();
			}

			var myDropzone = new Dropzone("#media-upload");
			myDropzone.on("success", function(file, response) {
			    if(response.result == 'success'){
                    $.toast({
						text: response.message,
						showHideTransition: 'slide',
						icon: 'success',
						position : 'top-right' 
					});
					table.draw();
			    }else{
                   $.each( response.message, function( key, value ) {
					   $.toast({
							text: value,
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});
				   });
				   myDropzone.removeFile(file);
			    }
			});
		}
	});

	$( document ).on('ajax-modal-2', function() {
		if($("#media-upload").length){
			Dropzone.autoDiscover = false;
			if($("#media-upload").attr('class') == "dropzone dz-clickable"){
				Dropzone.forElement("#media-upload").destroy();
			}

			var myDropzone = new Dropzone("#media-upload");
			myDropzone.on("success", function(file, response) {
			    if(response.result == 'success'){
                    $.toast({
						text: response.message,
						showHideTransition: 'slide',
						icon: 'success',
						position : 'top-right' 
					});
					media_table.draw();
			    }else{
                   $.each( response.message, function( key, value ) {
					   $.toast({
							text: value,
							showHideTransition: 'slide',
							icon: 'error',
							position : 'top-right' 
						});
				   });
				   myDropzone.removeFile(file);
			    }
			});

		}
	});


	$(document).on('click', '#media_table .select-media', function(event){
		event.stopImmediatePropagation();
		
		var media_id = $(this).data('id');
		var media_path = _asset_url + 'storage/app/' + $(this).data('path');
		$(document).trigger('select-media', [ media_id, media_path ]);
	});

	$(document).on('click', '#media_table .select-multiple-media', function(event){
		event.stopImmediatePropagation();

		var media_id = $(this).data('id');
		var media_path = _asset_url + 'storage/app/' + $(this).data('path');
		$(document).trigger('select-multiple-media', [ media_id, media_path ]);
	});

})(jQuery);