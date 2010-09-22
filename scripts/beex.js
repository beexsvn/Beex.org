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

function shrinkFeed(type) {
	
	if(type == 'all') {
		var rows = $("#FeedContent .row");
		if(rows.length) {
			$("#FeedContent .more_activity").hide();
			$("#FeedContent .proof_graphic").hide();
			$("#FeedContent .see_more_activity").show();
			$("#FeedContent .see_more_activity").html('&lt;more&gt;');
			$("#FeedContent .row").stop().slideDown('1000');
		}
		else {
			$("#FeedContent .none_box").html("No activity");
		}
	}
	else {
		
		var children = $("#FeedContent").children('.'+type);
		if(children.length) {
			children.children('.more_activity').show();
			children.slideDown('1000');
			$("#FeedContent").children(':not(.'+type+')').slideUp('1000');
		}
		else {
			if(type != 'proof') {
				var word = type+'s';
				if(type == 'join') {
					word = 'challenges declared';
				}
				$("#FeedContent .none_box").html('No ' + word);
				$("#FeedContent .more_activity").hide();
				$("#FeedContent .proof_graphic").hide();
			}
		}
		
		
		
		if(type == 'proof') {
			$("#FeedContent .none_box").html('');
			$("#FeedContent .proof_graphic").show();
			$("#FeedContent .see_more_activity").hide();
		}
	}
	
}

jQuery(document).ready(function(){
	
	$(".ceebox").ceebox({borderColor:'#fff',boxColor:"#fff",htmlWidth:420,htmlHeight:400, titles:false, padding:0});
	
	$(".datepicker").datepicker({minDate:0, showButtonPanel: true, onSelect: function() {$(this).removeClass('italic');}});
	
	jQuery("#new_note").click(function() {
		jQuery('.note_form').slideUp();
		jQuery("#edit_note_form").slideDown();
		//jQuery("#editor_").ckeditor();
		
	});
	
	$(".limited_text").keydown(function() {
		var limit = $(this).attr('maxlength');
		if($(this).val().length > limit) {
			$(this).val($(this).val().substr(0, limit));
		}
	});
	
	$("#user_login_button").click(function() {
		
		$("#HiddenLogIn").fadeIn('fast');
		
	});
	
	$("#hidden_close_button").click(function() {
		
		$("#HiddenLogIn").fadeOut('fast');
		
	});
	
	$("#hidden_login_button").click(function() {

		var email = $("#hidden_login_email").val();
		var password = $("#hidden_login_password").val();

		if(email && password) {

			jQuery.ajax({
				 type: "POST",
				 url: base_url + "ajax/login_user",
				 dataType: "json",
				 data: "email=" + email + "&password=" + password,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						window.location = window.location;
					}
					else {
						$("#hidden_login_errors").html(ret['errors']);

					}
				 }
			});
		}
		else {
			$("#hidden_login_errors").html('Please fill in the login fields');
		}
	});

	$(".rollover").hover(function() {
		var src = $(this).attr('src');
		var ext = src.substr(src.length-3);
		$(this).attr('src', src.substr(0, src.length-7) + 'on.' + ext);
	}, function() {
		var src = $(this).attr('src');
		var ext = src.substr(src.length-3);
		$(this).attr('src', src.substr(0, src.length-6) + 'off.' + ext);
	})
	
	
	// Featured browser buttons 
	/*
	jQuery(".featured_buttons .button").click(function() {	
		jQuery(".featured_buttons div").removeClass('on');
		var id = jQuery(this).attr('id').substr(6);
		jQuery(".featured_buttons #button" + id).addClass('on');
	});
	*/
	
	if($('.featuredbox').length != 0) {
		var featTimerLen = 5000;
		$(document).everyTime(featTimerLen, 'moveFeat', function () {moveFeatured('next'); });
	}
	
	$(".featured_buttons .button").click(function() {
		
		$(document).stopTime('moveFeat');
		
		var id = jQuery(this).attr('id').substr(6);

		jQuery(".featured_buttons div").removeClass('on');
		jQuery(".featured_buttons #button" + id).addClass('on');
		
		
		var pos = jQuery(".featuredbox #Featured"+id).position();
		
		$("#FCWrapper").stop().animate({
			left: -pos.left	
		});
		
	});
	
	$(".featured_buttons .arrow").click(function() {
		
		$(document).stopTime('moveFeat');
		
		var dir = 'next';
		if($(this).hasClass('previous')) {
			dir = 'prev';
		}
		moveFeatured(dir);
		
	});
	
	
	
	var hpSlideSpeed1 = 1500;
	var hpSlideSpeed2 = 1500;
	var hpDelaySpeed = 1500;
	function hpSlideshow() {
		$("#Slide1").fadeIn(hpSlideSpeed1, function() {
			$(this).children('.tagline').fadeIn(hpSlideSpeed1+3000, function() {
			
				$(this).fadeOut(hpSlideSpeed1);
				$("#Slide2").fadeIn(hpSlideSpeed1, function() {
					$(this).fadeOut(hpSlideSpeed1, function() {
						$("#Slide3").fadeIn(hpSlideSpeed1, function() {
							$(this).fadeOut(hpSlideSpeed1);
							$("#Slide4").fadeIn(hpSlideSpeed1, function() {
								$(this).fadeOut(hpSlideSpeed1);
								hpSlideshow();
							});
						});
					});
				});
				
			});
		});
	}
	
	if($("#Slide1").length) {
		$.preLoadImages(
			[
			  '/images/slideshow/1bg.png', 
			  '/images/slideshow/2bg.png', 
			  '/images/slideshow/3bg.png', 
			  '/images/slideshow/4bg.png'
			], function(){
			  hpSlide14(1);
			}
		);
	}
	
	function hpSlide14(id) {
		$("#Slide"+id).fadeIn(hpSlideSpeed1, function() {
			$("#Slide"+id+ ' .tagline').fadeIn(hpSlideSpeed1, function() {
				setTimeout(function() {
					$("#Slide"+id).children().fadeOut(hpSlideSpeed1);	
					$("#Slide"+id).fadeOut(hpSlideSpeed1, function() {
						if(id > 3) {
							hpSlide5();
						}
						else {
							hpSlide14(id+1);
						}
					});
				}, hpDelaySpeed);
			});
		});
	}
	
	function hpSlide5() {
		$("#Slide5").fadeIn(hpSlideSpeed1, function() {
			$("#Slide5 .img1").fadeIn(hpSlideSpeed1, function() {
				$("#Slide5 .img2").fadeIn(hpSlideSpeed1, function() {
					
						setTimeout(function() {
							$("#Slide5 img").fadeOut(hpSlideSpeed1);
							$("#Slide5").fadeOut(hpSlideSpeed1, function() {
								hpSlide7();
							});
						}, hpDelaySpeed+500);
					
				});
			});
		});
	}
	
	function hpSlide6() {
		$("#Slide6").fadeIn(hpSlideSpeed1, function() {
			$("#Slide6 .img1").fadeIn(hpSlideSpeed1, function() {
				$("#Slide6 .img2").fadeIn(hpSlideSpeed1, function() {
					$("#Slide6 .img3").fadeIn(hpSlideSpeed1, function() {
						setTimeout(function() {
							$("#Slide6").children().fadeOut(hpSlideSpeed1);
							$("#Slide6").fadeOut(hpSlideSpeed1, function() {
								hpSlide7();
							});
						}, hpDelaySpeed+500);
					});
				});
			});
		});
	}
	
	function hpSlide7() {
		$("#Slide7").fadeIn('fast', function() {
			$("#Slide7 .img1").fadeIn(hpSlideSpeed1, function() {
				setTimeout(function() {
					$("#Slide7").children().fadeOut(hpSlideSpeed1);
					$("#Slide7").fadeOut(hpSlideSpeed1, function() {
						hpSlide14(1);
					});
				}, hpDelaySpeed+1000);
			});
		});
	}
	
	/* Proof and Note Javascript */
	
	jQuery(".edit_proof_button").click(function() {
	
		var id = jQuery(this).attr('id').substr(10);
		jQuery("#edit_proof_form"+id).show();
	
	});
	
	jQuery(".edit_note_button").click(function() {
		jQuery('.note_form').slideUp();
		var id = jQuery(this).attr('id').substr(9);
		jQuery("#edit_note_form"+id).slideDown();
		jQuery("#editor_"+id).ckeditor();
		
		
	});
	
	jQuery(".reply_note_button").click(function() {
	
		var id = jQuery(this).attr('id').substr(10);
		jQuery("#reply_note_form"+id).show();
		
	});
	
	jQuery(".delete_note_button").click(function() {
		
		var answer = confirm("Are you sure you want to delete this note?");
		if (answer) {
			var id = jQuery(this).attr('id').substr(11);
			jQuery.ajax({
				
				url: base_url + "ajax/delete_note/" + id,
				success: function() {
					jQuery('#note_'+id).remove();
				}
				
			});
		}
		
	});
	
	jQuery(".delete_reply_button").click(function() {
		
		var answer = confirm("Are you sure you want to delete this reply?");
		if (answer) {
			var id = jQuery(this).attr('id').substr(11);
			jQuery.ajax({
				
				url: base_url + "ajax/delete_reply/" + id,
				success: function() {
					jQuery('#reply'+id).remove();
				}
				
			});
		}
		
	});
	
	jQuery(".cancel_button").click(function() {
	
		jQuery(this).closest('form').hide();
		
	});
	
	
	jQuery("#blogprooftoggle").click(function() {
		
		var toggle = 0;
		
		if($("#Notes").css('display') == 'none') {
			toggle = 1;
		}
		
		if(toggle == 1) {
			$("#blogprooftitle").html('The Blog');
			$("#Notes").show();
			$("#Proof").hide();
		}
		else {
			$("#blogprooftitle").html("The Proof");
			$("#Proof").show();
			$("#Notes").hide();
		}	
		 
		
	});
	 

	jQuery(".javapopuplink a").popupWindow({
			width: 600,
			height:800,
			left:100,
			top:100,
			scrollbars:1,
			windowName:'auxpage'

	});
	
	
	$("#Buttons div").click(function() {
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
	
	});
	
	$(".see_more_feed").click(function() {
		
		var new_height = $("#FeedContent").height();
		if(new_height > 370) {
			changeFeedHeight(new_height);
		
			$(this).hide();
			$('.see_less_feed').show();
		}
	});
	
	$(".see_less_feed").click(function() {
	
		var new_height = 370;
		
		changeFeedHeight(new_height);
		
		$(this).hide();
		$('.see_more_feed').show();
	});
	
	$(".see_more_activity").click(function() {
		var id = $(this).attr('id').substr(18);
		
		if($('#more_activity_'+id).css('display') == 'block') {
			$('#more_activity_'+id).slideUp('1000');
			$(this).html('&lt;view&gt;');
		}
		else {
			$('#more_activity_'+id).slideDown('1000');
			$(this).html('&lt;collapse&gt;');
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
	var rd_scroll_amount = 5;
	/* See more navigation */
	
	jQuery(".scrollUp").click(function() {
		
		if(rd_scroll_pos > 0) {
			
			rd_scroll_pos -= rd_scroll_amount;
			
			var p = jQuery('#recently_declared_'+rd_scroll_pos);
			if(p.length) {
				var pos = p.position();
				jQuery("#DeclarationsBox").animate({
					top:-pos.top
				}, 600);
			}
		}
	
	});
	
	jQuery(".scrollDown").click(function() {
		rd_scroll_pos += rd_scroll_amount;

		var p = jQuery('#recently_declared_'+rd_scroll_pos);
		if(p.length){
			var pos = p.position();
			jQuery("#DeclarationsBox").animate({
				top: -pos.top
			}, 600);
		}
		else {
			rd_scroll_pos -= rd_scroll_amount;
		}
		
	});
	
	
	
		
});
 