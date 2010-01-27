<?php

$new = true;



if($new)
	$edit = true;

if($edit){
	$attributes = array('id' => 'clusterform', 'class'=>'itemform');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
}



?>

<div id="RightColumn">
<?php
	if($message) {
		echo "<p class='message'>".$message."<span class='val_errors'>";
		echo validation_errors();
		echo "</span></p>";
	}
?>
	<div class="featuredbox">

        <?php if(@$freshcluster) : ?>
        <p class='youdidit'>Congratulations!</p>
        <p class='youdiditsub'>You've successfully created a cluster.  You can view your cluster <?php anchor('cluster/view/'.$id, 'here'); ?> or invite people to join it below.  You can always invite more people to join from the cluster editor.</p>
        <?php endif; ?>
    </div>

    <div class="module">
    	<div class="tabs">
        	<a id="challengers" class="button">Challengers</a>
        </div>
        <h2 class="title titlebg">Challengers</h1>
        <div class="InfoDisplay FormBG">
<?php


if($id){

	echo form_open_multipart('cluster/add_challengers/'.$id, $attributes);
}
?>


          		<h2 class="title">Add Challengers</h2>
            	<table>
                	<tr>
	                	<td colspan=2><h5>Invite</h5></td>
                    </tr>
                    <tr>
	                    <td class="label"><label>E-mail(s):<br /><span style="font-size:9px;">Seperate multiple emails with commas.</span></label></td>
                        <td><?php echo generate_input('emails', 'text', true, ''); ?></td>
                    </tr>
                    <!--
                    <tr>
                    	<td class="label"><label>Import via CSV file<br /><a>Learn More</a>:</label></td>
                        <td><input type="file" /></td>
                    </tr>
                    -->

                    <tr>
                    	<td class="label"><label>E-mail Message:<br /><br /><span style="font-size:9px; font-style:italic;">**Invites contain a cluster access code. When this code is entered into a "Join a Cluster" field on the website, the user will be prompted to fill out the form below. You (cluster admin) can accept or reject anyone who fills out the form on the <a>admin dashboard page</a>.</span></label></td>
                        <td><?php echo generate_input('personal_message', 'text', true, '', 'big_text');  ?></td>
                    </tr>

                    <!--
                    <tr>
	                	<td colspan=2><h5>Join Cluster Form</h5></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><a>+ Add questions</a><br />Max 3 questions</td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Question 1</label></td>
                        <td><input /></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Question 2</label></td>
                        <td><input /></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Question 3</label></td>
                        <td><input /></td>
                    </tr>
                    -->
                    <tr>
                    	<td colspan="2"><input type="image" src="/beex/images/buttons/send.gif" style="width:auto;" /></td>
                    </tr>


                </table>


            </form>


        </div>
    </div>

</div>

</div>
<div style="clear:both;"></div>