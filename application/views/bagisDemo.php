<?php $this->load->view("header", ["title" => "Simülasyon"]); ?>

<div class="container">
	<form @submit.prevent="gonder" v-if="status">
		<div class="row">
			<div class="col-12 col-sm">
				<div class="form-group mb-2">
					<label>Ad Soyad</label>
					<input type="text" class="form-control" v-model="form.user_adsoyad" required>
				</div>

				<div class="form-group mb-2">
					<label>E-Posta</label>
					<input type="email" class="form-control" v-model="form.user_eposta" required>
				</div>

				<div class="form-group mb-2">
					<label>Telefon</label>
					<input type="number" class="form-control" v-model="form.user_tel" required>
				</div>

				<div class="form-group mb-2">
					<label>TC Kimlik</label>
					<input type="number" class="form-control" v-model="form.user_tc" required>
				</div>

				<div class="mt-4">
					<p>Adınıza bağış yapmamızı istediğiniz Sivil Toplum Kuruluşu'nu seçin.</p>
				</div>
				<div class="form-group firmalarRadio" 
					v-for="(firma, index) in firmalar"
					:key="firma.corp_id" 
					:class="form.instruction_corp == firma.corp_id ? 'selected' : null">
					<label :for="index">
						<input type="radio" :id="index" :value="firma.corp_id" v-model="form.instruction_corp" class="invisible" required>
						<div class="row">
							<div class="col">
								<img src="<?php echo base_url('assets/img/corplogo.png'); ?>" class="img-fluid">
							</div>
							<div class="col">
								<div class="h-100 d-flex justify-content-center align-self-center align-items-center">
									{{firma.corp_name}}	
								</div>
							</div>
						</div>
					</label>
				</div>





				<div class="form-check form-switch mb-2">
				  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
				  <label class="form-check-label" for="flexSwitchCheckDefault">
				  	<a href="#">KVK Politikası</a>, <a href="">Aydınlatma Metni'ni</a> okudum, onaylıyorum
				  </label>
				</div>

				<input type="hidden" v-model="form.qr">
				<input type="hidden" v-model="form.qrId">
				<button class="btn btn-outline-primary btn-lg mt-3">Hemen Bağış Yap</button>
			</div>
			<div class="col-12 col-sm">
				
			</div>
		</div>
	</form>
</div>

<?php $this->load->view("footer"); ?>
<script>
var app = new Vue({
	el: "#app",
	data: {
		status: <?php echo json_encode($status); ?>,
		message: <?php echo json_encode($message); ?>,
		firmalar: <?php echo json_encode($result->firmalar); ?>,
		form: {
			user_adsoyad: null,
			user_eposta: null,
			user_tel: null,
			user_tc: null,
			instruction_corp:null,
		},
		url: <?php echo json_encode(base_url()); ?>
	},

	mounted(){
		if(!this.status){
			window.location.replace(<?php echo json_encode(base_url()); ?>);
		}
	},

	methods: {
		async sendApi(){
			// const result = await axios.post(this.url + "/Api/Instructions/add", JSON.stringify(this.form));
			// Swal.fire({
			// 	icon: result.data.status ? "success" : "error",
			// 	title: result.data.status ? "Tebrikler" : "Oooppsss!",
			// 	text: result.data.message,
			// 	confirmButtonText: "Tamam"
			// }).then(r => r.isConfirmed ? window.location.replace(this.url + "Bagis/sertifika/" + this.qr.qr_code) : null );
			Swal.fire({
				icon: "success",
				title: "Tebrikler!",
				text: "Bağış yapacağınız başarılı bir şekilde yapılmıştır.",
				confirmButtonText: "Tamam"
			});
		},

		gonder(){
			if(this.form.instruction_corp){
				Swal.fire({
					icon: "question",
					title: "Emin Misin?",
					text: "Bilgilerinizin sisteme girilecektir emin misin?",
					showCancelButton: true,
					cancelButtonText: "İptal",
					confirmButtonText: "Evet",
				}).then(r => r.isConfirmed ? this.sendApi() : null);
			} else {
				Swal.fire({
					icon: "error",
					title: "Boş alan bırakılamaz",
					text: "Bağış yapacağınız sivil toplum kuruluşunu seçmelisiniz.",
					confirmButtonText: "Tamam"
				});
			}
		}
	}
});
</script>

<style>
.firmalarRadio {
    border: 2px solid #F1F1F1;
    margin-bottom: 1rem;
    padding: 0.5rem;
    border-radius: 5px;
}
.firmalarRadio.selected{
	border-color: #1a407a;
}
.firmalarRadio label {
    display: block;
}
.firmalarRadio label:hover {
    cursor:  pointer;
}
</style>