$(document).ready(function() {
	
	$('.cluster_search_button').click(function() {
		
		var id = $(this).attr('id').substr(21);
		var term = $('#cluster_search_term').val();
		
		$.ajax({
			type: "POST",
			url: base_url + "ajaxsearch/cluster_search",
			dataType: "json",
			data: "cluster_id=" + id + "&term=" + term,
			beforeSend: function () {
				$(".beex-loading").fadeIn();
			},
			success: function(ret){
				$(".beex-loading").fadeOut();
				if(ret) {
					
					if(ret['success']) {
						$("#FeedContent").children(":not(.cluster_search_cntr)").fadeOut();
						if(ret['results'].length > 0) {
							$("#FeedContent").find("#join_no_results").html('');
							for(var k = 0; k < ret['results'].length; k++) {
								$("#FeedContent").find("#join"+ret['results'][k]).fadeIn();
							}
						}
						else {
							$("#FeedContent").find("#join_no_results").html('No results found for "'+term+'"').fadeIn();
						}
					}
				}
				else {
				
				}
			}
		});
		
	});
	
	$('#view_all_challenges').click(function() {
		shrinkFeed('join');
	});
	
	$('.go_blank').focus(function() {
		$(this).val('');
	});
	
});