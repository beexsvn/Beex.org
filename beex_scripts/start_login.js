jQuery(document).ready(function() {

$(".cancel_button").click(function() {
	$(".creation_substep").hide();
	$('#user_registered_yet').show();
});

$(".account_yet").click(function() {
	$("#user_registered_yet").hide();
	if($(this).attr("name") == 'already_have_account') {
		$("#already_registered").show();
		
	}
	else {
		$("#not_registered").show();
		$("#password2").blur(function() {
			if($("#password1").val() == $(this).val() && $(this).val() != '') {
				$("#password_validation").html('');
			}
			else {						
				$("#password_validation").html("Passwords do not match");
			}
		});			
	}
});

$("#register_continue").click(function() {
	var passwords_equal = ($("#password1").val() == $("#password2").val());
	if(passwords_equal) {
			
		var email = $("#email").val();
		var legal_name = $("#legal_name").val();
		var password = $("#password1").val();
		
		if(email && legal_name && password) {
			jQuery.ajax({
				 type: "POST",
				 url: base_url + "ajax/create_user",
				 dataType: "json",
				 data: "email=" + email + "&legal_name=" + legal_name + "&password=" + password,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						//$("#LogIn").hide();
						//$(".itemform").show();						
						window.location = window.location;
					}
					else {
						$("#registration_errors").html(ret['errors']);
					}
				 }
			});
		}
		else {
			$("#registration_errors").html("Please fill out all registration fields");
		}
	}
	else {
		$("#password_validation").html("Password do not match");
	}

});

$("#registered_continue").click(function() {

	var email = $("#login_email").val();
	var password = $("#login_password").val();
	
	if(email && password) {
	
		jQuery.ajax({
			 type: "POST",
			 url: base_url + "ajax/login_user",
			 dataType: "json",
			 data: "email=" + email + "&password=" + password,
			 success: function(ret){
				if(ret['nocode']) {
					window.location = base_url + 'user/entercode/'+ret['nocode'];
				}
				else {
					if(ret['success']) { // advance to the next step. 
						//$("#LogIn").hide();
						//$(".itemform").show();
						window.location = window.location;
				
					}
					else {
						$("#login_errors").html(ret['errors']);
				
					}
				}
			 }
		});
	}
	else {
		$("#login_errors").html('Please fill in the login fields');
	}
});

});