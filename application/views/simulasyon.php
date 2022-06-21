<?php $this->load->view("header", ["title" => "Simülasyon"]); ?>

<div class="row">
	<div class="col">
		<form @submit.prevent="gonder" v-if="status">
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

			<div class="form-group mb-2">
				<label>Bağış Yapılacak Kurum</label>
				<select class="form-select" v-model="form.instruction_corp" required>
					<option :value="null">Kurum Seçin</option>
					<option v-for="firma in firmalar" :key="firma.corp_id" :value="firma.corp_id">{{firma.corp_name}}</option>
				</select>
			</div>

			<input type="hidden" v-model="form.qr">
			<input type="hidden" v-model="form.qrId">
			<button class="btn btn-info text-white">Gönder</button>
		</form>

		<div v-else class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
			<div class="d-block">{{message}}</div>
		</div>
	</div>
</div>

<?php $this->load->view("footer"); ?>
<script>
var app = new Vue({
	el: "#app",
	data: {
		status: <?php echo json_encode($status); ?>,
		qr: <?php echo json_encode($result->qr); ?>,
		message: <?php echo json_encode($message); ?>,
		firmalar: <?php echo json_encode($result->firmalar); ?>,
		form: {
			user_adsoyad: null,
			user_eposta: null,
			user_tel: null,
			user_tc: null,
			instruction_corp:null,
			qr: <?php echo json_encode($result->qr->qr_code); ?>,
			qrId: <?php echo json_encode($result->qr->qr_id); ?>
		},
		url: <?php echo json_encode(base_url()); ?>
	},

	methods: {
		async sendApi(){
			const result = await axios.post(this.url + "/Api/Instructions/add", JSON.stringify(this.form));
			Swal.fire({
				icon: result.data.status ? "success" : "error",
				title: result.data.status ? "Tebrikler" : "Oooppsss!",
				text: result.data.message,
				confirmButtonText: "Tamam"
			});
		},

		gonder(){
			Swal.fire({
				icon: "question",
				title: "Emin Misin?",
				text: "Bilgilerinizin sisteme girilecektir emin misin?",
				showCancelButton: true,
				cancelButtonText: "İptal",
				confirmButtonText: "Evet",
			}).then(r => {
				if(r.isConfirmed){
					this.sendApi();
				}
			});
		}
	}
});
</script>