<?php $this->load->view("admin/header", ["title" => "Dashboard"]); ?>

<div class="container">
	<div class="row">
		<div class="col text-end">
			<form @submit.prevent="filtrele">
				<ul class="list-inline p-0">
					<li class="list-inline-item">
						<div class="form-group">
							<select class="form-select form-select-sm" v-model="filtre.yil">
								<option :value="null">Yıl Seçin</option>
								<option>2022</option>
							</select>
						</div>	
					</li>
					<li class="list-inline-item">
						<div class="form-group">
							<select class="form-select form-select-sm" v-model="filtre.ay">
								<option :value="null">Ay Seçin</option>
								<option v-for="ay in aylar" :key="ay" :value="ay">{{aylarText[ay]}}</option>
							</select>
						</div>	
					</li>
					<li class="list-inline-item">
						<button class="btn bg-primary btn-sm text-white rounded-3">Filtrele</button>	
					</li>
				</ul>
			</form>
		</div>	
	</div>

	<div class="row">
		<div class="col">
			<div class="table-responsive" v-if="veriler.length > 0">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Ad Soyad</th>
							<th>Kurum</th>
							<th>Tarih</th>
							<th>Detay</th>
							<th>Durum</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(veri, index) in veriler" :key="veri.instruction_id">
							<td>{{veri.instruction_id}}</td>
							<td>{{veri.user_adsoyad}}</td>
							<td>{{veri.corp_name}}</td>
							<td>{{veri.instruction_date}}</td>
							<td><button class="badge badge-sm bg-info border-0" @click="detay(index)" data-bs-toggle="modal" data-bs-target="#detayModal">detay</button></td>
							<td>
								<div class="form-check form-switch">
									<input type="checkbox" class="form-check-input" disabled role="switch" v-model="veri.ib_id">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div v-else>
				<p>Sistemde kayıtlı veri bulunamadı.</p>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="detayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detaylar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" v-if="secilen">
        <ul class="list-unstyled p-0">
        	<li>
        		<strong>Ad Soyad:</strong> {{secilen.user_adsoyad}}
        	</li>
        	<li>
        		<strong>E-Posta:</strong> {{secilen.user_eposta}}
        	</li>
        	<li>
        		<strong>Tel:</strong> {{secilen.user_tel}}
        	</li>
        	<li>
        		<strong>TC Kimlik:</strong> {{secilen.user_tc}}
        	</li>
        	<li>
        		<strong>Kurum:</strong> {{secilen.corp_name}}
        	</li>
        	<li>
        		<strong>Tarih:</strong> {{secilen.instruction_date}}
        	</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary text-white rounded-3" data-bs-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("admin/footer"); ?>

<script>
var app = new Vue({
	el: '#app',
	data(){
		return {
			veriler: <?php echo json_encode($veri); ?>,
			filtre: {
				yil: <?php echo json_encode($yil); ?>,
				ay: <?php echo json_encode($ay); ?>,
			},
			aylarText: ["Ay Seçin", "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
			secilen: null,
		}
	},

	methods: {
		filtrele(){
			window.location.replace("<?php echo base_url('admin/dashboard/index/'); ?>" + this.filtre.yil + "/" + this.filtre.ay);
		},

		cikis(){
			Swal.fire({
				icon: 'question',
				title: "Emin Misin?",
				text: "Sistemden çıkış yapılacaktır.",
				confirmButtonText: "Evet",
				showCancelButton: true,
				cancelButtonText: "Hayır"
			}).then(r => {
				if(r.isConfirmed){
					 window.location.replace("<?php echo base_url('admin/login/logout'); ?>")
				}
			});
		},

		detay(index){
			this.secilen = this.veriler[index];
		}
	},

	computed:{
		aylar(){
			var aylar = [];
			for(var i=1; i<13; i++){
				aylar.push(i);
			}
			return aylar;
		}
	}
});
</script>