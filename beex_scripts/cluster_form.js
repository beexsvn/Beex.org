var help_column = {
	"LogIn": "Start by logging in or registering a new account.  If you use Facebook, we suggest logging in through Facebook Connect because you can automatically update your Facebook friends from this website.",

	"cluster_title":"Title: Give your cluster a clear, recognizable and inviting name.",
	"cluster_goal": "Fundraising Goal: Optional field.  If your entire cluster has a fundraising goal, enter it here.  If each challenge within the cluster has a goal (such as an entrance fee) then you can fill that out in the next page.",
	"cluster_blurb":"Blurb: Short and sweet: what's your cluster all about?",
	"cluster_description":"Description: Make sure you've sufficiently explained the 'what', but focus this space on the 'why'.  For advice on a great description, check out our <a href='http://learn.beex.org/index.php?option=com_wrapper&view=wrapper&Itemid=12' target='_blank'>how-to wiki post</a>",
	"cluster_npo":"Organization: Make sure you know the tax status of the organization you're raising funds for.  Only 501.c.3 organizations can receive tax-deductible contributions.",
	"cluster_video":"Post a video: You must upload the video to YouTube or Vimeo first, and then add the video's url (not the embed code) here and click 'post.'",
	"cluster_completion":"Join Deadline: When is the last day people can join this cluster?",
	"cluster_link":"Website: Add a relevant website or link here.",
	"cluster_location":"Cluster Location: Be as precise as possible so that Google Maps can recognize it.",
	
	"cluster_ch_title": "You already filled out your cluster title but challenges have titles too. If you'd like to control what every challenge is called then type it here. If not then just leave it blank.",
	"cluster_ch_declaration":"Declaration: Everyone who joins your cluster will have to complete the action you fill out in this space.",
	"cluster_ch_goal":"Fundraising Goal:  Setting the minimum fundraising goal for the challenges within your cluster is a great way to charge admission, an entry fee, etc.  FYI: The average challenge raises about $400 from 12 donors at $33 each.",
	"cluster_ch_completion":"Fundraising end date:  Making all challenges end on a specific date is useful for mass action and fundraising events like charity walks.",
	"cluster_ch_link":"Optional",
	"cluster_ch_location":"Location: Be precise so that Google Maps can recognize it.",
	
}
var inputs = new Array();

inputs['cluster_video'] = 'Paste video link...';
inputs['cluster_title'] = "* Insert cluster title...";
inputs['cluster_blurb'] = 'Insert cluster blurb (140 characters max)...';
inputs['cluster_goal'] = 'Insert fundraising goal...';
inputs['cluster_description'] = 'Insert cluster description (2500 characters max)...';
inputs['cluster_completion'] = 'Click to pick date...';

inputs['cluster_ch_completion'] = 'Click to pick date...';
inputs['cluster_ch_title'] = "Insert title for all challenges in this cluster...";
inputs['cluster_ch_declaration'] = '(insert declaration for all challenges in this cluster)...';
inputs['cluster_ch_goal'] = 'Insert fundraising goal...';
inputs['cluster_ch_description'] = 'Insert description for all challenges in this cluster (800 characters max)...';
inputs['cluster_ch_proof_description'] = 'Insert description of the proof for all challengs in this cluster...';
inputs['cluster_ch_video'] = 'Paste video link...';

var seen_message = false;

function checkCluster() {
	
	var cluster_title = $("#cluster_title").val();
	var cluster_description = $("#cluster_description").val();
	var cluster_blurb = $("#cluster_blurb").val();
	var cluster_goal = $("#cluster_goal").val().replace(',', '');  // $123,345 comma thousands			
	var cluster_npo = $("#cluster_npo").val();
	var cluster_link = $("#cluster_link").val();
	var cluster_location = $("#cluster_location").val();
	var cluster_completion = $("#cluster_completion").val();
	
	var cluster_video = escape($("#cluster_video").val());
		
			
	$("#error_field").html("");
	var validation_errors = false;
	
	if(cluster_title == '' || cluster_title == inputs['cluster_title']) {
		$("#error_field").append("<p>Cluster title must be filled out.</p>");
		validation_errors = true;				
	}
	if(cluster_blurb.length > 140 || cluster_blurb == '' || cluster_blurb == inputs['cluster_blurb']) {
		$("#error_field").append("<p>Cluster blurb must be filled out, and no more than 140 characters in length.</p>");
		validation_errors = true;				
	}
	if(cluster_description.length > 2500) {
		$("#error_field").append("<p>Cluster description must be no more than 800 characters in length.</p>");
		validation_errors = true;				
	}
	
	/*
	if(!(!isNaN(challenge_zip)&&parseInt(challenge_zip)==challenge_zip) || challenge_zip.length != 5) {			
		$("#error_field").append("Please enter a valid 5-digit zipcode.<br />");
		validation_errors = true;				
	}
	*/
			
	if(!(!isNaN(cluster_goal)&&parseInt(cluster_goal)==cluster_goal) && cluster_goal != inputs['cluster_goal']) {
		$("#error_field").append("<p>Fundraising goal must be a valid number amount.</p>");
		validation_errors = true;				
	}
	
	if(cluster_description == inputs['cluster_description']) {
		$("#cluster_description").val('');
	}
	
	if(cluster_completion == inputs['cluster_completion']) {
		$("#cluster_completion").val('');
	}			
	
	if(cluster_video == inputs['cluster_video']){
		$("#cluster_video").val('');
	}
	
	return validation_errors;
	
}

$(document).ready(function() {
	
	$("input, textarea, select").focus(buzzy_the_paper_clip);
	
	function changeMenuItem(el) {
		
		if(!$("#section_"+el.attr('id')).is(":visible")) {
			$('.help_section').slideUp();
			$('#section_'+el.attr('id')).slideDown();
		}
	}
	
	
	$(".help_title:not(#challenge_template)").click(function() {
		changeMenuItem($(this));
	});
	
	$("#NextButton, #challenge_template").click(function() {
		
		//var cluster_id = $("#cluster_id").val();
		
		var validation_errors = checkCluster();
		
		if(validation_errors) {
			return false;
		}
		
		$(".cluster_form_tab").hide();
		$("#ch_npo_cell").html($("#cluster_npo :selected").text());
		changeMenuItem($("#challenge_template"));
		/*
		$(".help_title").html('Challenge Template');
		$('.help_description').html("Step 2: Create the Template.  Set parameters for all challenges within your cluster.  Your cluster's members can edit fields you leave blank.");
		*/
		$("#ClusterFormCH").show();
		
		if(new_cluster && !seen_message) {
			var message = '<h2 style=\'padding:5px 24px; text-align:center;\'>\
			In the next section, you set the conditions people must meet to join your cluster by filling out fields that every challenge within your cluster will share.  Challenger can fill out the fields you leave blank.\
			<br /><br />\
			For example: If you fill out the fundraising end date in the challenge template, every challenge in your cluster will automatically have that same end date.</h2>\
			<img style="text-align:center; margin:0px auto; width:95px; display:block;" onClick="$.fn.ceebox.closebox()" onMouseover="this.src=\''+true_base_url+'images/buttons/reg-next-on.png\'" onMouseout="this.src=\''+true_base_url+'images/buttons/reg-next-off.png\'" src="'+true_base_url+'images/buttons/reg-next-off.png" class="rollover" />';
		
			$.fn.ceebox.popup(message, {borderColor:'#DBE7E6', borderWidth:'18px', width:600, height:370, boxColor:"#ffffff", titles:false, padding:0});
			seen_message = true;
		}
	});
	
	$(".back_button, #start_cluster").click(function() {
		$(".cluster_form_tab").hide();
		/*
		$(".help_title").html('Start a Cluster');
		$('.help_description').html("Step 1: Describe the Cluster. Describe your cluster and set required parameters. Read the Help Editor below for more information about each field.");
		*/
		//chanegeMenuItem($("#start_cluster"));
				
		$("#clusterinfo").show();
	});
	
	$(".back_button").click(function() {
		changeMenuItem($("#start_cluster"));
	});
	
	$("#create_widgets").click(function() {
		$(".cluster_form_tab").hide();
		$("#ClusterWidgets").show();
	});
	
	$("#cluster_challengers").click(function() {
		$(".cluster_form_tab").hide();
		$("#ClusterChallengers").show();
	});
	
	var processCluster = function() { // last step.. fin!
		
		$(".save_cluster").unbind('click', processCluster);
		
		var new_cluster_id;
		
		//var cluster_id = $("#cluster_id").val();
		
		var cluster_title = $("#cluster_title").val();
		var cluster_description = $("#cluster_description").val();
		var cluster_blurb = $("#cluster_blurb").val();
		var cluster_goal = $("#cluster_goal").val().replace(',', '');		// $123,345 comma thousands			
		var cluster_npo = $("#cluster_npo").val();
		var cluster_link = $("#cluster_link").val();
		var cluster_location = $("#cluster_location").val();
		var cluster_completion = $("#cluster_completion").val();
		var cluster_video = $("#cluster_video").val();
					
		var cluster_ch_title = $("#cluster_ch_title").val();
		var cluster_ch_declaration = $("#cluster_ch_declaration").val();
		var cluster_ch_goal = $("#cluster_ch_goal").val();
		var cluster_ch_video = $("#cluster_ch_video").val();
		var cluster_ch_description = $("#cluster_ch_description").val();
		var cluster_ch_link= $("#cluster_ch_link").val();
		var cluster_ch_location = $("#cluster_ch_location").val();
		var cluster_ch_proof_description = $("#cluster_ch_proof_description").val();
		var cluster_ch_completion = $("#cluster_ch_completion").val();	
				
		$("#error_field").html("");
		var validation_errors = false;
	
		if(!(!isNaN(cluster_ch_goal)&&parseInt(cluster_ch_goal)==cluster_ch_goal) && cluster_ch_goal != '') {
			$("#error_field").append("<p>Fundraising goal must be a valid number amount.</p>");
			validation_errors = true;				
		}
		
		if(cluster_ch_declaration != '' && cluster_ch_declaration.length > 120) {
			$("#error_field").append("<p>Challenge declaration must be less than 120 characters long");
			validation_errors = true;
		}
		
		if(cluster_ch_description != '' && cluster_ch_description.length > 800) {
			$("#error_field").append("<p>Challenge description must be less than 800 characters long");
			validation_errors = true;
		}
		
		if(cluster_ch_title == inputs['cluster_ch_title']) {
			cluster_ch_title = '';				
		}
		if(cluster_ch_declaration == inputs['cluster_ch_declaration']) {
			cluster_ch_declaration = '';				
		}
		if(cluster_ch_description == inputs['cluster_ch_description']) {
			cluster_ch_description = '';	
		}
		
		if(cluster_ch_completion == inputs['cluster_ch_completion']) {
			cluster_ch_completion = '';	
		}
		
		if(cluster_goal == inputs['cluster_goal']) {
			cluster_goal = '';
		}
		
		if(cluster_ch_goal == inputs['cluster_ch_goal']) {
			cluster_ch_goal = '';
		}		
		
		if(cluster_ch_video == inputs['cluster_ch_video']){
			cluster_ch_video = '';
		}

		if(cluster_video == inputs['cluster_video']){
			cluster_video = '';
		}
		
		cluster_ch_video = escape(cluster_ch_video);
		cluster_video = escape(cluster_video);
		
		
		
		if(validation_errors) {
			$(".save_cluster").bind('click', processCluster);
			return false;
		}
		
		jQuery.ajax({
			 type: "POST",
			 url: base_url + "ajaxforms/process_cluster_basic/" + edit_id,
			 dataType: "json",
			 data: 	"cluster_title=" + cluster_title + 
					"&cluster_description=" + cluster_description + 
					"&cluster_blurb=" + cluster_blurb + 
					"&cluster_goal=" + cluster_goal + 
					"&cluster_npo=" + cluster_npo + 
					"&cluster_link=" + cluster_link + 
					"&cluster_location=" + cluster_location + 
					"&cluster_video=" + cluster_video + 
					"&cluster_completion=" + cluster_completion + 
					"&cluster_ch_title=" + cluster_ch_title +  
					"&cluster_ch_declaration=" + cluster_ch_declaration + 
					"&cluster_ch_description=" + cluster_ch_description +
					"&cluster_ch_proof_description=" + cluster_ch_proof_description + 
					"&cluster_ch_goal=" + cluster_ch_goal + 
					"&cluster_ch_link=" + cluster_ch_link + 
					"&cluster_ch_location=" + cluster_ch_location + 
					'&cluster_ch_video=' + cluster_ch_video + 
					'&cluster_ch_completion=' + cluster_ch_completion,
			 success: function(ret){
				
				if(ret['success']) { // advance to the next step. 
					new_cluster_id = ret['cluster_id'];
					var redirect = base_url + 'cluster/view/' + new_cluster_id;
					if(fb_user) {	
					
						/* publish to the news feed */
						var message = "Check out my fundraising cluster on BEEx.org!";
						var caption = cluster_blurb;
						var link = base_url + 'cluster/view/'+ new_cluster_id + '/';
						var join = base_url + 'cluster/joina/' + new_cluster_id + '/';
						var name = cluster_title;
						var picture = "http://www.beex.org/images/defaults/cluster_default.png";
						
						if(typeof ret['cluster_image'] !== "undefined" && ret['cluster_image']) {
							picture = "http://sandbox.beex.org/media/clusters/"+new_cluster_id+'/sized_'+ret['cluster_image'];
						}
						
						var redirect = base_url + 'cluster/view/' + new_cluster_id;
						
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
							       //description: caption,
							       href: link,
								   media: [
									      {
									        type: 'image',
									        href: link,
									        src: picture
									      }
								   ],
							     },
							     /*action_links: [
							       { text: 'Join My Cluster', href: join }
							     ],*/
							     user_message_prompt: 'Would you like to share your cluster on Facebook?'
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
							window.location = redirect;
						}
					 	
					} 
					else {						
						window.location = redirect;										
					}
														
				}
				else {
					$("#login_errors").html(ret['errors']); // change this to a universal error field ..? hmm?
					$(".save_cluster").bind('click', processCluster);
				}
			 }
		});
		
		function publishCallback(a,b) {
			window.location = base_url + 'index.php/cluster/view/' + new_cluster_id;
			
		}
		
	}
	
	$(".save_cluster").bind('click', processCluster);
	
});