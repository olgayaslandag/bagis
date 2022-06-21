<?php $this->load->view("header", ["title" => "Bianca Stella Bağış Sertifikası", "image" => $status ? $result->resim : null]); ?>

<?php if($status){?>
<div class="container">
	<div class="row">
		<div class="col text-center">
			<img src="<?php echo $result->resim; ?>" alt="<?php echo $result->instruction->user_adsoyad; ?>" class="sertifika-resim">	
		</div>
	</div>

	<div class="row">
		<div class="col text-center">
			<a href="<?php echo $result->resim; ?>" 
				class="btn bg-primary text-white mt-2 mb-5" 
				download="<?php echo $result->instruction->user_adsoyad; ?>.jpg" 
				style="border-radius: 0.6rem;">İndir</a>	
			<div class="addthis_inline_share_toolbox"></div>
		</div>
	</div>
</div>
<?php } else {?>
<div class="container">
	<div class="row">
		<div class="col">
			<p><?php echo $message ? $message : null; ?></p>
		</div>
	</div>
</div>
<?php } ?>

<?php $this->load->view('footer'); ?>
<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-62228a9f35c5da52"></script>
<style>
.sertifika-resim {
	max-width: 100%;
	max-height: 500px;
	height:  auto;
}
</style>