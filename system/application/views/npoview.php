<?php

$this->load->view('framework/header', $header);

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

echo "<h2>".$header['title']."</h2>";

if($edit){
	$attributes = array('id' => 'npoform');
	echo form_open_multipart('npo/process/'.$npo->id, $attributes);
}

echo "<table border=0 cellpadding=0 cellspacing=0>";
if(!$edit) {
	echo "<tr><td colspan=2>".anchor('npo/view/'.$npo->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";
}
echo "<th colspan=2>Organization Infomation</td></tr>
		<tr>";
$data = array('name'=>'ein', 'id'=>'ein', 'size'=>25, 'value'=>$npo->ein);
$cell = ($edit) ? form_input($data) : $npo->ein;
echo "<td>EIN Number</td><td>".$cell."</td>
		</tr>
		<tr>";		
		
$data = array('name'=>'name', 'id'=>'name', 'size'=>25, 'value'=>$npo->name);
$cell = ($edit) ? form_input($data) : $npo->name;
echo "<td>Organization Name</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'address_street', 'id'=>'address_street', 'size'=>25, 'value'=>$npo->address_street);
$cell = ($edit) ? form_input($data) : $npo->address_street;
echo "<td>Mailing Address</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'address_city', 'id'=>'address_city', 'size'=>25, 'value'=>$npo->address_city);
$cell = ($edit) ? form_input($data) : $npo->address_city;
echo "<td>City</td><td>".$cell."</td>
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
$cell = ($edit) ? form_dropdown('address_state', $states, $npo->address_state) : $npo->address_state;
echo "<td>State</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'address_zip', 'id'=>'address_zip', 'size'=>5, 'value'=>$npo->address_zip);
$cell = ($edit) ? form_input($data) : $npo->address_zip;
echo "<td>Zip</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'website', 'id'=>'website', 'size'=>25, 'value'=>$npo->website);
$cell = ($edit) ? form_input($data) : $npo->website;
echo "<td>Website</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'logo', 'id'=>'logo', 'size'=>25);
$cell = ($edit) ? form_upload($data) : $npo->logo;
echo "<td>Logo Image</td><td>".$cell."</td>
		</tr>
		<tr>";


echo "<th colspan=2>Admin Infomation</td></tr>
		<tr>";

$data = array('name'=>'admin_email', 'id'=>'admin_email', 'size'=>25, 'value'=>$npo->admin_email);
$cell = ($edit) ? form_input($data) : $npo->admin_email;
echo "<td>Admin Email</td><td>".$cell."</td>
		</tr>
		<tr>";

if($edit) {
	$data = array('name'=>'admin_emailconf', 'id'=>'admin_emailconf', 'size'=>25, 'value'=>$npo->admin_email);
	$cell = ($edit) ? form_input($data) : $npo->admin_email;
	echo "<td>Confirm Admin Email</td><td>".$cell."</td>
		</tr>
		<tr>";
}
if($edit) {
	
	echo "<td colspan=2>To change your password, enter your password below. To keep it the same, just leave the fields below blank.</td></tr><tr>";
	
	$data = array('name'=>'admin_password', 'id'=>'admin_password', 'size'=>25);
	$cell = ($edit) ? form_input($data) : $npo->address_zip;
	echo "<td>Admin Password</td><td>".$cell."</td>
		</tr>
		<tr>";
		
	$data = array('name'=>'admin_passconf', 'id'=>'admin_passconf', 'size'=>25);
	echo "<td>Confirm Admin Password</td><td>".form_password($data)."</td>
		</tr>
		<tr>";
}
else {
	echo "<td colspan=2 style='text-align:center;'>To change your password, click ".anchor('npo/view/'.$npo->id.'/1', 'here')."</td></tr><tr>";	
}

echo "<th colspan=2>Contact Infomation</td></tr>
		<tr>";

$data = array('name'=>'contact_firstname', 'id'=>'contact_firstname', 'size'=>25, 'value'=>$npo->contact_firstname);
$cell = ($edit) ? form_input($data) : $npo->contact_firstname;
echo "<td>First Name</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'contact_lastname', 'id'=>'contact_lastname', 'size'=>25, 'value'=>$npo->contact_lastname);
$cell = ($edit) ? form_input($data) : $npo->contact_lastname;
echo "<td>Last Name</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'contact_title', 'id'=>'contact_title', 'size'=>25, 'value'=>$npo->contact_title);
$cell = ($edit) ? form_input($data) : $npo->contact_title;
echo "<td>Title</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'contact_email', 'id'=>'contact_email', 'size'=>25, 'value'=>$npo->contact_email);
$cell = ($edit) ? form_input($data) : $npo->contact_email;
echo "<td>Email</td><td>".$cell."</td>
		</tr>
		<tr>";

if($edit) {
	$data = array('name'=>'contact_emailconf', 'id'=>'contact_emailconf', 'size'=>25, 'value'=>$npo->contact_email);
	echo "<td>Confirm Email</td><td>".form_input($data)."</td>
		</tr>
		<tr>";
}

$data = array('name'=>'contact_phone', 'id'=>'contact_phone', 'size'=>25, 'value'=>$npo->contact_phone);
$cell = ($edit) ? form_input($data) : $npo->contact_phone;
echo "<td>Phone Number</td><td>".$cell."</td>
		</tr>
		<tr>";		

echo "<th colspan=2>Profile Infomation (optional)</td></tr>
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
$cell = ($edit) ? form_dropdown('category', $cats, $npo->category) : $npo->category;
echo "<td>Category</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$areas = array("Local"=>"Local",
			  "Regional"=>"Regional",
			  "National"=>"National",
			  "International"=>"International");

$cell = ($edit) ? form_dropdown('region', $areas, $npo->region) : $npo->region;
echo "<td>Region</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'causetags', 'id'=>'causetags', 'size'=>25, 'value'=>$tags);
$cell = ($edit) ? form_input($data) : $tags;
echo "<td>Cause Tags<br><small>Please seperate tags with commas</small></td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'blurb', 'id'=>'blurb', 'rows'=>2, 'cols'=>'30', 'value'=>$npo->blurb);
$cell = ($edit) ? form_textarea($data) : $npo->blurb;
echo "<td>Blurb</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'mission_statement', 'id'=>'mission_statement', 'rows'=>3, 'cols'=>30, 'value'=>$npo->mission_statement);
$cell = ($edit) ? form_textarea($data) : $npo->mission_statement;
echo "<td>What We Do</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'about_us', 'id'=>'about_us', 'rows'=>10, 'cols'=>30, 'value'=>$npo->about_us);
$cell = ($edit) ? form_textarea($data) : $npo->about_us;
echo "<td>History</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'rss_feed', 'id'=>'rss_feed', 'value'=>$npo->rss_feed);
$cell = ($edit) ? form_input($data) : $npo->rss_feed;
echo "<td>RSS Feed</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'twitter_link', 'id'=>'twitter_link', 'value'=>$npo->twitter_link);
$cell = ($edit) ? form_input($data) : $npo->twitter_link;
echo "<td>Twiiter Address</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'facebook_link', 'id'=>'facebook_link', 'value'=>$npo->facebook_link);
$cell = ($edit) ? form_input($data) : $npo->facebook_link;
echo "<td>Facebook Address</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'youtube_link', 'id'=>'youtube_link', 'value'=>$npo->youtube_link);
$cell = ($edit) ? form_input($data) : $npo->youtube_link;
echo "<td>YouTube Channel</td><td>".$cell."</td>
		</tr>
		<tr>";

if($edit){
	$data = array('class'=>'submit');
	echo "<td colspan=2>".form_submit($data, 'Update NPO')."</td>";
}

echo "</tr>
 	</table>";

if($edit) {
	echo "</form>";
}
	
$this->load->view('framework/footer');

?>