<?php $this->load->view("header", ["title" => "Bianca Stella - Mutluluğa Dönüştür"]); ?>

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
							<div class="col-6">
								<img :src="'<?php echo base_url('assets/logolar/'); ?>' + firma.corp_logo" class="img-fluid">
							</div>
							<div class="col-6">
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
				  	<a href="<?php echo base_url("Single/index/3"); ?>" target="_blank">KVK Politikası Aydınlatma Metni'ni</a> okudum, onaylıyorum
				  </label>
				</div>

				<input type="hidden" v-model="form.qr">
				<input type="hidden" v-model="form.qrId">
				<input type="hidden" v-model="form.ip">
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
		qr: <?php echo $result->qr ? json_encode($result->qr) : json_encode(null); ?>,
		message: <?php echo json_encode($message); ?>,
		firmalar: <?php echo json_encode($result->firmalar); ?>,
		form: {
			user_adsoyad: null,
			user_eposta: null,
			user_tel: null,
			user_tc: null,
			instruction_corp:null,
			qr: <?php echo $result->qr ? json_encode($result->qr->qr_code) : json_encode(null); ?>,
			qrId: <?php echo $result->qr ? json_encode($result->qr->qr_id) : json_encode(null); ?>,
			ip: <?php echo json_encode($this->input->ip_address()); ?>
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
			const result = await axios.post(this.url + "/Api/Instructions/add", JSON.stringify(this.form));
			console.log(result.data)
			Swal.fire({
				icon: result.data.status ? "success" : "error",
				title: result.data.status ? "Tebrikler" : "Hata!",
				text: result.data.message,
				confirmButtonText: "Tamam"
			}).then(r => {
				if(r.isConfirmed){
					if(result.data.status){
						window.location.replace(this.url + "Bagis/sertifika/" + this.qr.qr_code)	
					}
				}
			} );
		},

		async gonder(){
			if(this.form.instruction_corp){
				const tcResult = await axios.post(this.url + "/Api/TcKimlik/tcNoDogrulama", JSON.stringify({tc_no: this.form.user_tc}));

				if(tcResult.data.status){
					if(this.form.user_tel.length != 11){
						Swal.fire({
							icon: "error",
							title: "Hata!",
							text: "Hatalı telefon numarası formatı girdiniz. Telefon numarasını başında 0 yazarak girmelisiniz!",
							confirmButtonText: "Tamam"
						});	
					} else {
						Swal.fire({
							icon: "question",
							title: "İşleminizi Onaylıyor musunuz?",
							text: "Bilgilerinizin sisteme değiştirilemeyecek şekilde girilecektir, emin misin?",
							showCancelButton: true,
							cancelButtonText: "İptal",
							confirmButtonText: "Evet",
						}).then(r => r.isConfirmed ? this.sendApi() : null);
					}
				} else {
					Swal.fire({
						icon: "error",
						title: "Hata!",
						text: "Hatalı TC kimlik numarası girdiniz!",
						confirmButtonText: "Tamam"
					});	
				}
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
.firma_logo {
	height: 100px;
	max-width: 100%;
}

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