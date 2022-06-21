<?php $this->load->view("header", ["title" => "Bianca Stella - Mutluluğa Dönüştür"]); ?>

<div class="mb-3">
	<img src="<?php echo base_url('assets/img/banner.jpeg'); ?>" class="d-block w-100" alt="...">
</div>

<div class="container mb-5">
	<div class="row main-logos d-flex align-items-center text-center">
		<div class="col">
			<img src="<?php echo base_url('assets/img/stella-logo.png'); ?>" class="stella">
		</div>
		<div class="col">
			<img src="<?php echo base_url('assets/img/logo.png'); ?>" class="mutluluk">
		</div>
	</div>
</div>

<div class="container mt-5 mb-5 content-area">
	<div class="row">
		<div class="col-md-6 offset-md-3 text-center">
			<h2>Sizin seçtiğiniz bir sivil toplum kuruluşuna sizin adınıza anında 5 TL bağış yapalım.</h2>
			<hr  class="d-inline-block" />
			<h3>Evinizdeki dönüşümü mutluluğa dönüştürün.</h3>
			<button class="btn btn-outline-primary btn-lg mt-3" @click="bagisYap">Hemen Bağış Yap</button>
		</div>
	</div>
</div>

<?php $this->load->view("footer"); ?>

<script>
var app = new Vue({
	el: '#app',
	data:{
		url: <?php echo json_encode(base_url()); ?>,
		result: <?php echo json_encode($result); ?>,
		status: <?php echo json_encode($status); ?>,
		message: <?php echo json_encode($message); ?>,
	},

	mounted(){
		if(!this.status){
			Swal.fire({
				icon: 'info',
				title: 'Önemli Uyarı!',
				text: this.message,
				confirmButtonText: 'Tamam'
			});
		}
	},

	methods: {
		bagisYap(){
			if(this.status){
				window.location.replace(this.url + "Bagis/index/" + this.result);
			}else{
				console.log(this.result)
				Swal.fire({
					icon: 'info',
					title: 'Önemli Uyarı!',
					text: this.message,
					confirmButtonText: 'Tamam'
				});
			}
		}
	}
});
</script>