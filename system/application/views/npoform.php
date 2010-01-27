<?php



$this->load->view('framework/header', $header);



if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";

	echo validation_errors();

	echo "</span></p>";

}







echo "<h2>".$header['title']."</h2>";

$attributes = array('id' => 'npoform');

echo form_open_multipart('npo/add', $attributes);

echo "<table border=0 cellpadding=0 cellspacing=0>";

echo "<th colspan=2>Organization Infomation</td></tr>

		<tr>";

$data = array('name'=>'ein', 'id'=>'ein', 'size'=>25);

echo "<td>EIN Number</td><td>".form_input($data)."</td>

		</tr>

		<tr>";





$data = array('name'=>'paypal_email', 'id'=>'paypal_email', 'size'=>25);

echo "<td>Paypal Email</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'name', 'id'=>'name', 'size'=>25);

echo "<td>Organization Name</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'address_street', 'id'=>'address_street', 'size'=>25);

echo "<td>Mailing Address</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'address_city', 'id'=>'address_city', 'size'=>25);

echo "<td>City</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$states = array(

            'AL'=>"Alabama",

            'AK'=>"Alaska",

            'AZ'=>"Arizona",

            'AR'=>"Arkansas",

            'CA'=>"California",

            'CO'=>"Colorado",

            'CT'=>"Connecticut",

            'DE'=>"Delaware",

            'DC'=>"District Of Columbia",

            'FL'=>"Florida",

            'GA'=>"Georgia",

            'HI'=>"Hawaii",

            'ID'=>"Idaho",

            'IL'=>"Illinois",

            'IN'=>"Indiana",

            'IA'=>"Iowa",

            'KS'=>"Kansas",

            'KY'=>"Kentucky",

            'LA'=>"Louisiana",

            'ME'=>"Maine",

            'MD'=>"Maryland",

            'MA'=>"Massachusetts",

            'MI'=>"Michigan",

            'MN'=>"Minnesota",

            'MS'=>"Mississippi",

            'MO'=>"Missouri",

            'MT'=>"Montana",

            'NE'=>"Nebraska",

            'NV'=>"Nevada",

            'NH'=>"New Hampshire",

            'NJ'=>"New Jersey",

            'NM'=>"New Mexico",

            'NY'=>"New York",

            'NC'=>"North Carolina",

            'ND'=>"North Dakota",

            'OH'=>"Ohio",

            'OK'=>"Oklahoma",

            'OR'=>"Oregon",

            'PA'=>"Pennsylvania",

            'RI'=>"Rhode Island",

            'SC'=>"South Carolina",

            'SD'=>"South Dakota",

            'TN'=>"Tennessee",

            'TX'=>"Texas",

            'UT'=>"Utah",

            'VT'=>"Vermont",

            'VA'=>"Virginia",

            'WA'=>"Washington",

            'WV'=>"West Virginia",

            'WI'=>"Wisconsin",

            'WY'=>"Wyoming"

);



$data = array('name'=>'address_state', 'id'=>'address_state');

echo "<td>State</td><td>".form_dropdown('address_state', $states, 'Alabama')."</td>

		</tr>

		<tr>";



$data = array('name'=>'address_zip', 'id'=>'address_zip', 'size'=>5);

echo "<td>Zip</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'website', 'id'=>'website', 'size'=>25);

echo "<td>Website</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'logo', 'id'=>'logo', 'size'=>25);

echo "<td>Logo Image</td><td>".form_upload($data)."</td>

		</tr>

		<tr>";



echo "<th colspan=2>Admin Infomation</td></tr>

		<tr>";



$data = array('name'=>'admin_email', 'id'=>'admin_email', 'size'=>25);

echo "<td>Admin Email</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'admin_emailconf', 'id'=>'admin_email', 'size'=>25);

echo "<td>Confirm Admin Email</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'admin_password', 'id'=>'password', 'size'=>25);

echo "<td>Admin Password</td><td>".form_password($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'admin_passconf', 'id'=>'password', 'size'=>25);

echo "<td>Confirm Admin Password</td><td>".form_password($data)."</td>

		</tr>

		<tr>";



echo "<th colspan=2>Contact Infomation</td></tr>

		<tr>";



$data = array('name'=>'contact_firstname', 'id'=>'contact_firstname', 'size'=>25);

echo "<td>First Name</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'contact_lastname', 'id'=>'contact_lastname', 'size'=>25);

echo "<td>Last Name</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'contact_title', 'id'=>'contact_title', 'size'=>25);

echo "<td>Title</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'contact_email', 'id'=>'contact_email', 'size'=>25);

echo "<td>Email</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'contact_email', 'id'=>'contact_email', 'size'=>25);

echo "<td>Confirm Email</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'contact_phone', 'id'=>'contact_phone', 'size'=>25);

echo "<td>Phone Number</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



echo "<tr><th colspan=2>Profile Infomation (optional)</th></tr>

		<tr>";



$cats = array ("Animal Rights"=>"Animal Rights",

			   "Justice"=>"Justice",

			   "Education"=>"Education",

			   "Health"=>"Health",

			   "Abuse"=>"Abuse",

			   "Discrimination"=>"Discrimination",

			   "Environment"=>"Environment",

			   "Homelessness"=>"Homelessness",

			   "Relief Efforts"=>"Relief Efforts",

			   "Food Justice"=>"Food Justice",

			   "Politics"=>"Politics",

			   "Arts"=>"Arts",

			   "Development"=>"Development",

			   "Social Enterprise"=>"Social Enterprise",

			   "Poverty"=>"Poverty",

			   "Water"=>"Water",

			   "Peace"=>"Peace",

			   "Journalism"=>"Journalism",

			   "Religious"=>"Religious"

			   );



echo "<td>Category</td><td>".form_dropdown('category', $cats, 'Animal Rights')."</td>

		</tr>

		<tr>";



$areas = array("Local"=>"Local",

			  "Regional"=>"Regional",

			  "National"=>"National",

			  "International"=>"International");



echo "<td>Region</td><td>".form_dropdown('region', $areas, 'Local')."</td>

		</tr>

		<tr>";



$data = array('name'=>'causetags', 'id'=>'causetags', 'size'=>25);

echo "<td>Cause Tags<br><small>Please seperate tags with commas</small></td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'blurb', 'id'=>'blurb', 'rows'=>2, 'cols'=>'30');

echo "<td>Blurb</td><td>".form_textarea($data)."</td>

		</tr>

		<tr>";





$data = array('name'=>'mission_statement', 'id'=>'mission_statement', 'rows'=>3, 'cols'=>30);

echo "<td>What We Do</td><td>".form_textarea($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'about_us', 'id'=>'about_us', 'rows'=>10, 'cols'=>30);

echo "<td>History</td><td>".form_textarea($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'rss_feed', 'id'=>'rss_feed');

echo "<td>RSS Feed</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'twitter_link', 'id'=>'twitter_link');

echo "<td>Twiiter Address</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'facebook_link', 'id'=>'facebook_link');

echo "<td>Facebook Address</td><td>".form_input($data)."</td>

		</tr>

		<tr>";



$data = array('name'=>'youtube_link', 'id'=>'youtube_link');

echo "<td>YouTube Channel</td><td>".form_input($data)."</td>

		</tr><tr>";



$data = array('class'=>'submit');

echo "<td colspan=2>".form_submit($data, 'Add NPO')."</td>";



echo "</tr>

	</table>

	</form>";



$this->load->view('framework/footer');



?>