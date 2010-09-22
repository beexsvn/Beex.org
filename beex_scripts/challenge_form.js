var help_column = {
	"LogIn": "Start by logging in or registering a new account.  If you use Facebook, we suggest logging in through Facebook Connect because you can automatically update your Facebook friends from this website.",			
	
	"cluster_id":"Is your challenge part of a greater cluster? If you don't know what this is, then don't worry about it.",
	"challenge_title": "Challenge Title: Name your challenge something cute, clear and clever.",
	"challenge_declaration":"Declaration: What are you going to do?  Just type the action.  BEEx automatically adds the 'I or We will part'",								
	"proof_description":"The proof is one of the most important parts of a challenge.  Explain the type of media (words, pictures, videos, website link, etc) you'll be producing and what that media will contain.  A common example is something like \"A picture of me crossing the finish line.\"  Don't be ordinary. Be Extraordinary!",
	"challenge_goal":"Fundraising Goal: FYI: the average challenge raises about $400 from 12 donors at $33 each.",
	"challenge_npo": "Organization: Make sure you know the tax status of the organization you're raising funds for.  Only 501.c.3 organizations can receive tax-deductible contributions.",				
	"partner_bool": "Do you have a partner?",
	"challenge_location":"Be as precise as possible so that Google Maps can recognize it.",
	"challenge_completion":"Fundraising End Date:  When does the fundraising end?  This might not be the same date you complete your challenge.",
	"challenge_video":"Post a video: You must upload the video to YouTube or Vimeo first, and then add the video's url (not the embed code) here and click 'post.'",
	"challenge_description": "Description:  Make sure you've sufficiently explained the 'what', but focus this space on the 'why'.  For advice on a great description, check out our <a href='http://learn.beex.org/index.php?option=com_wrapper&view=wrapper&Itemid=12' target='_blank'>how-to wiki post.</a>", 
	"challenge_link":"Optional."

	
}

var inputs = new Array();

inputs['challenge_title'] = "* Insert challenge title...";
inputs['challenge_declaration'] = '(insert declaration. 120 characters max)...';
inputs['challenge_goal'] = '* Insert fundraising goal...';
inputs['challenge_description'] = 'Insert challenge description (800 characters max)...';
inputs['proof_description'] = '* Insert proof description (120 characters max)...';
inputs['challenge_video'] = 'Paste video link...';
inputs['challenge_completion'] = 'Click to pick date...'

$(document).ready(function() {
	
	$("input, textarea, select").focus(buzzy_the_paper_clip);
	
	
	var processChallenge = function() { 
		
		$(".save_challenge").unbind('click', processChallenge);
		var new_challenge_id;
		
		//var cluster_id = $("#cluster_id").val();
		
		var challenge_title = $("#challenge_title").val();
		var challenge_declaration = $("#challenge_declaration").val();
		var proof_description = $("#proof_description").val();
		var challenge_goal = $("#challenge_goal").val().replace(',', '');		// $123,345 comma thousands			
		var challenge_npo = $("#challenge_npo").val();
		var partner_bool = $("[name='partner_bool']:checked").val();
		var partner_name = $("#partner_name").val();
		var partner_email = $("#partner_email").val();
		var cluster_id = $("#cluster_id").val();
		
		var challenge_location = $("#challenge_location").val();
		//var challenge_address1 = $("#challenge_address1").val();
		//var challenge_city = $("#challenge_city").val();
		//var challenge_state = $("[name='challenge_state']").val();
		//var challenge_zip = $("#challenge_zip").val();
		//var challenge_attend = $("#challenge_attend").val();
		//var challenge_fr_completed = $("#challenge_fr_completed").val();
		var challenge_completion = $("#challenge_completion").val();
		//var challenge_proof_upload = $("#challenge_proof_upload").val();
		
		var challenge_link = $("#challenge_link").val();
		var challenge_description = $("#challenge_description").val();
		//var challenge_whydo = $("#challenge_whydo").val();
		//var challenge_whycare = $("#challenge_whycare").val();
		var challenge_video = $("#challenge_video").val();
			
				
		$("#error_field").html("");
		var validation_errors = false;
		
		if(challenge_title == '' || challenge_title == inputs['challenge_title']) {
			$("#error_field").append("<p>Challenge title must be filled out.</p>");
			validation_errors = true;				
		}
		if(challenge_declaration.length > 120 || challenge_declaration == '' || challenge_declaration == inputs['challenge_declaration']) {
			$("#error_field").append("<p>Challenge declaration must be filled out, and no more than 120 characters in length.</p>");
			validation_errors = true;				
		}
		if(proof_description.length > 120 || proof_description == '' || proof_description == inputs['proof_description']) {
			$("#error_field").append("<p>Proof description must be filled out, and no more than 120 characters in length.</p>");
			validation_errors = true;				
		}
		
		/*
		if(!(!isNaN(challenge_zip)&&parseInt(challenge_zip)==challenge_zip) || challenge_zip.length != 5) {			
			$("#error_field").append("Please enter a valid 5-digit zipcode.<br />");
			validation_errors = true;				
		}
		*/
		if(challenge_completion == '' || challenge_completion == inputs['challenge_completion']) {
			$("#error_field").append("<p>Please enter a date for your fundraising completion.</p>");
			validation_errors = true;
		}
		
		if(!(!isNaN(challenge_goal)&&parseInt(challenge_goal)==challenge_goal) || challenge_goal == '') {
			$("#error_field").append("<p>Fundraising goal must be a valid numerical format.</p>");
			validation_errors = true;				
		}
		
		if(challenge_description.length > 800) {
			$("#error_field").append("<p>Challenge description must be less than 800 characters</p>");
			validation_errors = true;
		}
		
		if(challenge_description == inputs['challenge_description']) {
			challenge_description = '';
		}
		
		if(challenge_video == inputs['challenge_video']){
			challenge_video = '';
		}
		
		
		if(validation_errors) {
			$("#error_field").prepend("<p>ERRORS</p>");
			$(".save_challenge").bind('click', processChallenge);
			return false;
		}
		
		//Process challenge video
		challenge_video = escape(challenge_video);
		
		jQuery.ajax({
			 type: "POST",
			 url: base_url + "/ajax/process_challenge",
			 dataType: "json",
			 data: 	"challenge_title=" + challenge_title + 
					"&challenge_declaration=" + challenge_declaration + 
					"&proof_description=" + proof_description + 
					"&challenge_goal=" + challenge_goal + 
					"&challenge_npo=" + challenge_npo + 
					"&challenge_link=" + challenge_link + 
					"&partner_bool=" + partner_bool + 
					"&partner_name=" + partner_name + 
					"&partner_email=" + partner_email + 
					"&challenge_location=" + challenge_location + 
					"&cluster_id=" + cluster_id + 
					"&challenge_video=" + challenge_video +
					'&challenge_completion=' + challenge_completion + 
					"&challenge_description=" + challenge_description,				
			 success: function(ret){
				
				if(ret['success']) { // advance to the next step. 
					new_challenge_id = ret['challenge_id'];
					
					if(fb_user) {	
						var npo = $("#challenge_npo option:selected").text();
						if(!npo) {
							npo = $("#challenge_npo_at").text();
						}
											
						/* publish to the news feed */
						var caption = "Support {*actor*}'s fundraiser on BEEx.org!";
						var message = 'I will ' + challenge_declaration + ' if $' + challenge_goal + ' is raised for ' + npo + '.';
						var link = base_url + 'challenge/view/'+ new_challenge_id + '/';
						var name = challenge_title;
						var picture = "http://www.beex.org/images/defaults/challenge_default.png";
						
						if(typeof ret['challenge_image'] !== "undefined" && ret['challenge_image']) {
							picture = "http://sandbox.beex.org/media/challenges/"+new_challenge_id+'/sized_'+ret['challenge_image'];
						}
						
						var user_prompt = 'Would you like to share your challenge on Facebook?'
						var redirect = base_url + '/challenge/view/' + new_challenge_id;
						//streamPublish(message, caption, '', picture, name, link, 'Donate', link, user_prompt, redirect);
						
						var fu_webkit = false;
						
						if($.browser.webkit) {
							FB.getLoginStatus(function(response) {
							  if (response.session) {
							    // logged in and connected user, someone you know
							
							  } else {
							    // no user session available, someone you dont know
							
								fu_webkit = true;
							  }
							});
						}
							
						
						if(!fu_webkit) {
							FB.ui(
						   	{
							     method: 'stream.publish',
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
							       { text: 'Donate', href: link }
							     ],
							     user_message_prompt: 'Would you like to share your challenge on Facebook?'
							   },
							   function(response) {
								  if (response && response.post_id) {
							       //successful post
							     } else {
							       //unsuccessful post
							     }
								 window.location = redirect;	
						
							   }
							);
					 	}
						else {
							window.location = redirect + '/fb_add';
						}
						//window.location = base_url + '/challenge/view/' + new_challenge_id;
					
						/*
						FB.api('/'+fb_user+'/feed', 'post', { message: message, link:link, name:name, caption:caption, picture:picture }, function(response) {
						  if (!response || response.error) {
						    alert('Error occured');
						  } else {
						    alert('Post ID: ' + response);
						  }
						});
						
						FB.api(
						  {
						    method: 'stream.publish',
						    message: message,
							
							target_id: fb_user,
							uid: fb_user
						  },
						  function(response) {
						    alert(
						      'Total: ' + (response[0].total_count + response[1].total_count));
						  }
						);
						*/
				
							
						//publishCallback();
					} 
					else {						
						window.location = base_url + '/challenge/view/' + new_challenge_id;											
					}										
				}
				else {
					
					$("#login_errors").html(ret['errors']); // change this to a universal error field ..? hmm?
					$(".save_challenge").bind('click', processChallenge);
				}
			 }
		});
		
		function publishCallback(a,b) {
			window.location = base_url + '/challenge/view/' + new_challenge_id;
			
		}
				
	}
	
	$(".save_challenge").bind('click', processChallenge);
	
	
	$("#partner_next").click(function() {
		var email = $("#partner_email").val();
		var name = $("#partner_name").val();
		
		if(email.length && name.length) {
			if(echeck(email)) {
				$(".partner_info_cntr").hide();
				$(".declare_pronoun").html('We');
				$(".declare").prepend('<p>Partner added successfully</p>').show();
			}
			else {
				$("#partner_errors").html('<p>Please enter a valid email address for your partner</p>');
			}
		} 
		else {
			$("#partner_errors").html('<p>Please fill out the partner fields, or select "No" partner</p>');
		}
		
	});
	
	$("[name='partner_bool']").click(function() {
		if($(this).val() == 'no') {
			$(".partner_info_cntr").hide();
			$(".partner_info_cntr input").val('');
			$('.declare_pronoun').html('I');
			$(".declare").show();
		}
		else {
			$(".declare").hide();
			$("#partner_errors").html('');
			$(".partner_info_cntr").show();
		}
	});
	
});