// JavaScript Document

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}

function streamPublish(message, caption, description, picture, name, link, atext, alink, user_prompt, redirect, el) {

	FB.ui(
   	{
	     method: 'stream.publish',
		 display: 'dialog',
	     message: message,
	     attachment: {
	       name: name,
	       caption:  caption,
	       href: link,
		   media: [
			      {
			        type: 'image',
			        href: link,
			        src: picture
			      }
		   ],
	     },
	     action_links: [
	       { text: atext, href: alink }
	     ],
	     user_message_prompt: user_prompt
	   },
	   function(response) {
		  	if (response && response.post_id) {
	       		//successful post
	     	} else {
	       		//unsuccessful post
	     	}
		 
		 	if(redirect == 'note') {
				el.submit();
			}
		 	else {
				window.location = redirect;
			}
	   }
	);
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
			$("#FeedContent .none_box").html('');
			$("#FeedContent .see_more_activity").show();
			$("#FeedContent .see_more_activity").html('&lt;view&gt;');
			$("#FeedContent .row").stop().slideDown('1000');
		}
		else {
			$("#FeedContent .none_box").html("No activity");
			$("#FeedContent .proof_graphic").hide();
		}
	}
	else {
		
		var children = $("#FeedContent").children('.'+type);
		$("#FeedContent .none_box").hide();
		$("#FeedContent").children(':not(.'+type+')').slideUp();
		if(children.length) {
			children.find('.see_more_activity').html('&lt;hide&gt;');
			children.find('.more_activity').show();
			children.slideDown('1000');	
		}
		else {
			if(type != 'proof') {
				var word = type+'s';
				if(type == 'join') {
					word = 'challenges declared';
				}
				$("#FeedContent .more_activity").hide();
				$("#FeedContent .proof_graphic").hide();
				$("#FeedContent .none_box").html('No ' + word).show();
				
			}
			else {
				$("#FeedContent .none_box").html('');
				$("#FeedContent .proof_graphic").show();
				$("#FeedContent .see_more_activity").hide();
			}
		}
	}
	
}function expandFirstNote() {	$("#FeedContent").children(".note:first, .proof:first").children().show();}

jQuery(document).ready(function(){
	$(".ceebox").ceebox({borderColor:'#DBE7E6', borderWidth:'18px', boxColor:"#ffffff", htmlWidth:360, htmlHeight:360, titles:false, padding:0});
	$(".subscription_ceebox").ceebox({borderColor:'#DBE7E6', borderWidth:'18px', boxColor:"#ffffff", htmlWidth:360, htmlHeight:460, titles:false, padding:0});
	
	$(".jcrop_pop").ceebox({borderColor:'#DBE7E6', borderWidth:'18px', boxColor:"#ffffff", titles:false, htmlHeight:570, htmlWidth:550, html:true});
	
	$(".datepicker").datepicker({minDate:0, showButtonPanel: true, onSelect: function() {$(this).removeClass('italic'); $(this).addClass('dark_gray');}});
	$(".rollover_css").hover(function() {
		    var base;
			var classList = $(this).attr('class').split(/\s+/);		
			$.each(classList, function(index, item){			
				if (item.indexOf('background_') === 0) {
					base = item.substr(11);	
					
			}		
		});			
		var newbg = 'url("' + true_base_url + 'images/buttons/' + base + '-on.png' + '")';			
		$(this).css('backgroundImage', newbg);		
	}, function() {
		var base;			
		var classList = $(this).attr('class').split(/\s+/);	
		$.each(classList, function(index, item){		
			if (item.indexOf('background_') === 0) {			 
		  		base = item.substr(11);		
			}	
		});				
		var src = $(this).css('backgroundImage');		
		var ext = src.substr(src.length-5);				
		var newbg = 'url("' + true_base_url + 'images/buttons/' + base + '-off.png' + '")';				
		$(this).css('backgroundImage', newbg);
	});
		
	jQuery(".new_note").click(function() {
		jQuery('.form').slideUp();
		jQuery("#edit_note_form").slideDown();
		//jQuery("#editor_").ckeditor();
	});
	
	jQuery("#new_proof").click(function() {
		jQuery('.form').slideUp();
		jQuery("#edit_proof_form").slideDown();
		//jQuery("#editor_").ckeditor();
		
	});
	
	$(".limited_text").keypress(function(event) {
		var limit = $(this).attr('maxlength')-1;
		if(event.keyCode != '8' || event.keyCode != '46') {
			if($(this).val().length > limit) {
				$(this).val($(this).val().substr(0, limit));
			}
		}
	});
	
	$("#HiddenLogIn input").keyup(function(event) {
		if(event.keyCode == '13') {
			var email = $("#hidden_login_email").val();
			var password = $("#hidden_login_password").val();
			hiddenLogIn(email, password);
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
		hiddenLogIn(email, password);
		
	});
	
	function hiddenLogIn(email, password) {
		
		if(email && password) {

			$.ajax({
				 type: "POST",
				 url: base_url + "ajax/login_user",
				 dataType: "json",
				 data: "email=" + email + "&password=" + password,
				 success: function(ret){
					if(ret) {
						if(ret['success']) {
							window.location = window.location;
						}
						else {
							if(ret['nocode']) { // advance to the next step. 
								window.location = base_url + 'user/entercode/'+ret['nocode'];
							}
							else {
								$("#hidden_login_errors").html(ret['errors']);
							}
						}
					}
					else {
						window.location = base_url + 'user/login';
					}
				 }
			});
		}
		else {
			$("#hidden_login_errors").html('Please fill in the login fields');
		}
	}

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
	
	$(".link_to_long").tipTip();
	
	

	
	/* Proof and Note Javascript */
	
	/*
	
	Turning off the facebook feature
	
	
	$('.note_form').submit(function() {
		var note = $(this).find("[name='note']").val();
		var title = $(this).find("[name='title']").val();
		var id = $(this).attr('id').substr(14);
		if(note && title) {
			if(typeof fb_user != 'undefined') {
				var well = fbAddNote(this, note, title, $(this).find("[name='proof']:checked").val());
				return well;
			}
			else {
				return true;
			}
		}
		else {
			$("#note_errors"+id).html('<p>Title and Note are both required</p>');
			return false;
		}
	});
	
	$('.proof_form').submit(function() {
		var note = $(this).find("[name='caption']").val();
		var title = $(this).find("[name='name']").val();
		var id = $(this).attr('id').substr(15);
		if(note && title) {
			if(typeof fb_user != 'undefined') {
				var well = fbAddNote(this, note, title, true);
				return well;
			}
			else {
				return true;
			}
		}
		else {
			$("#proof_errors"+id).html('<p>Title and Note are both required</p>');
			return false;
		}
	});
	*/
	
	$('.note_form').submit(function() {
		var note = $(this).find("[name='note']").val();
		var title = $(this).find("[name='title']").val();
		var id = $(this).attr('id').substr(14);
		if(note && title) {
			return true;
			
		}
		else {
			$("#note_errors"+id).html('<p>Title and Note are both required</p>');
			return false;
		}
	});
	
	$('.proof_form').submit(function() {
		var note = $(this).find("[name='caption']").val();
		var title = $(this).find("[name='name']").val();
		var id = $(this).attr('id').substr(15);
		if(note && title) {
			return true;
		}
		else {
			$("#proof_errors"+id).html('<p>Title and Note are both required</p>');
			return false;
		}
	});
	
	
	jQuery(".edit_proof_button").click(function() {
		
		var id = jQuery(this).attr('id').substr(10);
		$('.form').slideUp();
		jQuery("#edit_proof_form"+id).slideDown();
	
	});
	
	jQuery(".delete_proof_button").click(function() {
		
		var answer = confirm("Are you sure you want to delete this proof?");
		if (answer) {
			var id = jQuery(this).attr('id').substr(12);
			if(id) {
				jQuery.ajax({
				
					url: base_url + "ajax/delete_proof/" + id,
					success: function() {
						jQuery('#note_'+id).fadeOut('fast', function() {
							jQuery('#note_'+id).remove();
						});
					}
				
				});
			}
			else {
				alert("Invalid ID");
			}
		}
		
	});
	
	
	jQuery(".edit_note_button").click(function() {
		jQuery('.form').slideUp();
		var id = jQuery(this).attr('id').substr(9);
		jQuery("#edit_note_form"+id).slideDown();
		//jQuery("#editor_"+id).ckeditor();
		
		
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
					jQuery('#note_'+id).fadeOut('fast', function() {
						jQuery('#note_'+id).remove();
					});
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
	
		jQuery(this).closest('form').slideUp();
		
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
			$(this).html('&lt;hide&gt;');
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

