<?php
$this->load->view('framework/header', $header);
?>


<div>
	
    <h1>What have you done! You broke the site!!!</h1>
    
    <p>Just kidding. You're just trying to go to access page that doesn't exist. Head on <a onClick="history.back()">back</a> now.</p>
     
   	

</div>



<?php
$this->load->view('framework/footer');
?>