<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="<?php echo base_url("assets/style.css?v=".time()); ?>">
<title><?php echo $title ? $title : "Bağış"; ?></title>

<?php if(isset($image)){?>
<meta property="og:image" content="<?php echo $image; ?>.jpg?<?php echo uniqid(); ?>" />
<meta property="og:title" content="<?php echo $title ? $title : "Bağış"; ?>" />
<meta property="og:description" content="" />
<meta property="og:locale" content="tr_TR" />
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:site_name" content="Bianca Stella" />
<meta property="og:image:type" content="image/jpg">
<meta property="og:image:width" content="1024">
<meta property="og:image:height" content="1024">



<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo current_url(); ?>">
<meta name="twitter:title" content="<?php echo $title ? $title : "Bağış"; ?>">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="<?php echo $image; ?>.jpg?"<?php echo uniqid(); ?>>
<?php } ?>



</head>
<body>
<?php $is_home = mb_strtolower($this->router->fetch_class()) === 'home' ? true : false; ?>
<div id="app">
	<header class="bg-transparent <?php echo $is_home ? 'd-absolute' : 'mb-5'; ?>">
		<nav class="navbar navbar-expand-lg navbar-light">
		  <div class="container">
		    <a class="navbar-brand" href="<?php echo base_url(); ?>">
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
		          <a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>">Anasayfa</a>
		        </li>
		        <!-- <li class="nav-item">
		          <a class="nav-link" href="#">Katılım Koşulları</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">Sıkça Sorulan Sorular</a>
		        </li> -->
		        <li class="nav-item">
		          <a class="nav-link" href="<?php echo base_url("Single/iletisim"); ?>">İletişim</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
	</header>