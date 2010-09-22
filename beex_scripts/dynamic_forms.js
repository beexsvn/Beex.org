function buzzy_the_paper_clip() {
	// Adjusts help column text as appropriate
	$("#help_column, .help_column").html(help_column[$(this).attr('id')]);

}

$(document).ready(function() {
	
	function form_input_is_int(input){
  		return !isNaN(input)&&parseInt(input)==input;
	}

	$('.dyna_input').each(function() {
	
		if(!$(this).val() || $(this).val() == inputs[$(this).attr('id')]) {
			$(this).addClass('italic');
			$(this).val(inputs[$(this).attr('id')]);
		}
		else {
			$(this).addClass('dark_gray');
		}
	});

	$('.dyna_input').focus(function() {
	
		if($(this).val() == inputs[$(this).attr('id')]) {
			$(this).removeClass('italic');
			$(this).addClass('dark_gray');
			$(this).val('');
		}
	});

	$('.dyna_input').blur(function() {
	
		if(!$(this).val() || $(this).val() == inputs[$(this).attr('id')]) {
			$(this).addClass('italic');
			$(this).removeClass('dark_gray');
			$(this).val(inputs[$(this).attr('id')]);
		}
	});

	$('.datepicker').click(function() {
		$(this).addClass('dark_gray');
	});

	
	$(".ajax_upload").each(function () {
		var btnUpload = $(this);
		var id = $(this).attr('id').substr(7);
		
		var status = $("#status_"+id);
		
		new AjaxUpload(btnUpload, {
			action: base_url + 'ajax/new_ajax_upload/'+id,
			//Name of the file input box
			name: 'uploadfile',
			responseType: "json",
			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
	                  // check for valid file extension
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
				
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');

				//Add uploaded file to list
				if(response['success']) {
					if(response['start']) {
						$('#MediaHolder_' + id).html('<img src="'+response['file']+'" alt="" />').show();
						$('#CancelButton_' + id).show();
					}
					else {
						$('.image .picture img').attr('src', response['file']);
						var button_text = $('.upload_button').text().substr(6);
						$('.upload_button').text('Change '+button_text);
						
					}
				}
				else {
					if(response['error']) {
						status.text(response['error']);
					}
					else {
						status.text('There was a problem with your upload');
					}
				}
			}
		});
	});
	
	
	
	$(".video_input").focus(function() {
		$(".status_video").html('');
	});
		
	$(".post_video_button").click(function() {
	
		var id = $(this).attr('id').substr(16);
		var video = $("#"+ id + "_video").val();
		
		if(video && video != inputs[id + '_video']) {
			$.ajax({
				url: base_url + 'ajaxforms/process_fresh_video',
				type: 'POST',
				data: 'video='+video,
				success: function(ret) {
					if(ret == 'fail') {
						alert('didnt work');
					}
					else if(ret == 'wrong_type') {
						$("#status_video_"+id).html('Unable to read video link');
						$("#"+id+"_video").val('');
					}
					else {
						$('#MediaHolder_'+id).html(ret).show();
						$("#CancelButton_"+id).show();
					}
				}
			});
		}
		
	});
	
	$(".cancelbutton").click(function() {
		var id = $(this).attr('id').substr(13);

		$("#"+ id + "_video").val(inputs[id + '_video']);
		$("#"+ id + "_video").addClass('italic');
		$("#" + id + "_video").removeClass('dark_gray');
		$.ajax({
			url: base_url + 'ajaxforms/clear_media/'+ id + '/' + edit_id,
			success: function(ret) {
				$("#MediaHolder_"+id).html('').hide();
				$("#CancelButton_"+id).hide();
			}
		});
	});
	
});