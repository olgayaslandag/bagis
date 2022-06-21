
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Bianca Stella Bağış - Giriş</title>
<meta name="googlebot" content="noindex, nofollow">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
label{margin-bottom: 5px;}  
.sifreUnuttumButton{text-decoration: none;color: #666;}
.logo{image-rendering: -moz-crisp-edges;image-rendering: -o-crisp-edges;image-rendering: -webkit-optimize-contrast;-ms-interpolation-mode: nearest-neighbor;}
</style>
</head>
<body>

<div id="app">
  <div id="login" class="container">
    <div class="mt-5 text-left col-sm-4 offset-sm-4">
      <img src="<?php echo base_url('assets/img/stella-logo.png'); ?>" class="mb-5 mx-auto d-block logo" height="90">
      <form @submit.prevent="giris()" class="">
        <div id="input-group-1" role="group" class="form-group mb-2">
          <label for="input-1">E-Posta:</label>
            <input id="input-1" type="email" v-model="eposta" placeholder="E-Posta adresinizi girin." required="required" class="form-control" autocomplete="on">
        </div>
        <div id="input-group-2" class="form-group">
          <label for="input-2" class="d-block">Şifre:</label>
          <input id="input-2" type="password" v-model="sifre" placeholder="Şifrenizi girin" required="required" class="form-control" autocomplete="on">
        </div>
        
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-block mt-3 girisButton">Giriş Yap</button>
          <a href="#" class="btn btn-link btn-block sifreUnuttumButton d-none">Şifremi Unuttum</a>
        </div>
        <!-- <button type="button" class="btn btn-secondary btn-block">Şifremi Unuttum</button> -->
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.all.min.js"></script>

<script>
var app = new Vue({
  el: '#app',
  data: {
    url: "<?php echo base_url(); ?>",
    eposta: null,
    sifre: null,
  },

  methods: {
    giris(){
      axios.post(this.url + "admin/login/check", JSON.stringify({
        eposta: this.eposta,
        sifre: this.sifre
      }) ).then(r => {
        console.log(r.data)
        if(r.data.status){
          window.location.href = "<?php echo base_url('admin/dashboard'); ?>"
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            confirmButtonText: 'Tamam',
            text: r.data.message,
          })
        }
      }).catch(e => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            confirmButtonText: 'Tamam',
            text: "sunucuya ulaşılamadı!",
          })
      });

    }
  }
});
</script>
</body>
</html>