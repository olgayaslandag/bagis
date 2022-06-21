<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="<?php echo base_url("assets/style.css?v=".time()); ?>">
<title><?php echo $title ? $title : "Bianca Stella Bağış"; ?></title>

</head>
<body>
<?php $is_home = $this->router->fetch_class() === 'Home' ? true : false;?>
<div id="app">
	<header class="bg-transparent <?php echo $is_home ? 'd-absolute' : 'mb-5'; ?>">
		<nav class="navbar navbar-expand-lg navbar-light">
		  <div class="container">
		    <a class="navbar-brand" href="<?php echo base_url('admin/dashboard'); ?>">
		    	<?php if(!$is_home):?>
		    	<img src="<?php echo base_url('assets/img/logo.png'); ?>" class="site-logo">
		    	<?php endif; ?>
		    </a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" aria-current="page" href="<?php echo base_url('admin/dashboard'); ?>">Anasayfa</a>
		        </li>
		        <li class="nav-item">
		          <a @click="cikis" class="nav-link" href="#">Çıkış Yap</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
	</header>