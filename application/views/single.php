<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("header", ["title" => $icerik->post_title]); ?>

<div class="container text-center">
	<h1 class="h5"><?php echo $icerik->post_title; ?></h1>
</div>

<div class="container">
	<div>
		<?php echo $icerik->post_content; ?>	
	</div>
</div>

<?php $this->load->view("footer"); ?>