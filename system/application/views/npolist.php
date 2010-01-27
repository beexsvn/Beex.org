<?php

$this->load->view('framework/header', $header);

echo "<h2>".$header['title']."</h2>";

?>

<table>
 <tr>
  <th>Organization Name</th><th>EIN Number</th><th>Contact Name</th>
 </tr>
 <?php echo $output; ?>
</table>

<?php

$this->load->view('framework/footer');

?>