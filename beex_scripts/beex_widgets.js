// JavaScript Document

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}



function moveFeatured(dir) {
	
	var pos = jQuery("#FCWrapper").position();
	var infolength = $(".InfoDisplay").width();
	var len = $(".InfoDisplay").length;
	if(pos) {
		var p = -pos.left/infolength;
	
		if(isInteger(p)) {
	
			if(dir == 'prev') {
				p -= 1;
				if(p < 0) {
					p = len-1
				} 
			}
			else {
				p += 1;
				if(p > len-1) {
					p = 0;
				}
			}
			jQuery(".featured_buttons div").removeClass('on');
			jQuery(".featured_buttons #button" + p).addClass('on');

			$("#FCWrapper").stop().animate({
				left: -($("#Featured"+p).position().left)
			});
		}
	}
}

jQuery(document).ready(function(){
	
	$(".ceebox").ceebox({borderColor:'#DBE7E6', borderWidth:'18px', boxColor:"#ffffff", htmlWidth:360, htmlHeight:360, titles:false, padding:0});
	

	$(".rollover").hover(function() {
		var src = $(this).attr('src');
		var ext = src.substr(src.length-3);
		$(this).attr('src', src.substr(0, src.length-7) + 'on.' + ext);
	}, function() {
		var src = $(this).attr('src');
		var ext = src.substr(src.length-3);
		$(this).attr('src', src.substr(0, src.length-6) + 'off.' + ext);
	})

	
	
	
	
	$("#Buttons div").click(function() {
		if($(this).hasClass('button')) {
			$("#Buttons div").addClass('button');
			$("#Buttons div").removeClass('selected selected_top');
		
			$(this).removeClass('button');
			if(($(this).attr('id') ==  'feed_button_all' && $(this).hasClass('challenge_feed_button')) || $(this).attr('id') ==  'feed_button_join') {
				$(this).addClass('selected_top');
			}
			else {
				$(this).addClass('selected');
			}
		
			shrinkFeed($(this).attr('id').substr(12));
		}
	});


	function changeFeedHeight(new_height) {
		
		if(new_height/1.4 < 1000) {
			time = new_height/1.4;
		}
		else {
			time = 1000;
		}
		
		$('#FeedWrapper').animate({
			height: new_height
		}, time);
		
	}
	
	var rd_scroll_pos = 0;
	var rd_scroll_amount = 2;
	/* See more navigation */

	jQuery(".scrollUp").click(function() {
		
		if(rd_scroll_pos > 0) {
			
			rd_scroll_pos -= rd_scroll_amount;
			
			var p = jQuery('.widget'+rd_scroll_pos);
			if(p.length) {
				var pos = p.position();
				jQuery("#FeedContent").animate({
					top:-pos.top
				}, 600);
			}
		}
	
	});
	
	jQuery(".scrollDown").click(function() {
		rd_scroll_pos += rd_scroll_amount;

		var p = jQuery('.widget'+rd_scroll_pos);
		if(p.length){
			var pos = p.position();
			jQuery("#FeedContent").animate({
				top: -pos.top
			}, 600);
		}
		else {
			rd_scroll_pos -= rd_scroll_amount;
		}
		
	});
		
});

 