<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Joy Dental HRIS | <?= $title ?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">
	
	<!-- Favicons -->
	<link rel="icon" href="<?= base_url() ?>assets/img/icon.png" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
	<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/family.css" media="all"> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css" media="all">

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/morris.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/datepicker.css">
  	<link rel="stylesheet" href="<?= base_url() ?>assets/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.signature.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/color.calender.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/loader.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css?v=<?= $vrs ?>">

</head>
<body>
	
<!-- Loading Load -->
<input type="hidden" name="login-sess" value="<?= $this->session->userdata('login') ?>">
<?php 
	$show_lod = "";
	if($this->session->userdata('login')){
		?><div class="wait"><div class="loader-load"><div class="loader__ball"></div><div class="loader__ball"></div><div class="loader__ball"></div></div></div><?php 
		$show_lod = "none";
	}else{
		$show_lod = "";
	}
	$this->session->set_userdata('login', false); 
?>

<div class="load <?= $show_lod ?>">
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header">
				<a href="<?= base_url('dashboard') ?>" class="logo">
					<img src="<?= base_url() ?>assets/img/logo.svg" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">
				<div class="container-fluid">
					<div class="collapse left-nav">
						<a onClick="window.location.href=window.location.href" class="logo pointer">
							<span class="loading-trans text-base fw-bold text-12-gray shadow" id="realtime"> xx xxx xxxx xxxxxxxx xx </span>
						</a>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="far fa-bell"></i>
								<span class="notification">4</span>
							</a>
							<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
								<li>
									<div class="dropdown-title">You have 4 new notification</div>
								</li>
								<li>
									<div class="notif-center">
										<a href="#">
											<div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
											<div class="notif-content">
												<span class="block">
													New user registered
												</span>
												<span class="time">5 minutes ago</span> 
											</div>
										</a>
										<a href="#">
											<div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
											<div class="notif-content">
												<span class="block">
													Rahmad commented on Admin
												</span>
												<span class="time">12 minutes ago</span> 
											</div>
										</a>
										<a href="#">
											<div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
											<div class="notif-content">
												<span class="block">
													Farrah liked Admin
												</span>
												<span class="time">17 minutes ago</span> 
											</div>
										</a>
									</div>
								</li>
								<li>
									<a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
								</li>
							</ul>
						</li>

						<li class="nav-item dropdown hidden-caret"></li>
						<?php
							if($account['foto'] == NULL || $account['foto'] == ''){ $photo = 'profile.jpg'; }
							else{ $photo = $account['foto']; }
						?>
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4><?= strlen($account['nama']) > 18 ?  substr($account['nama'],0,18).'..' : $account['nama'] ?></h4>
												<p class="text-muted"><?= strlen($account['email']) > 20 ?  substr($account['email'],0,20).'..' : $account['email'] ?></p>
												<a href="<?= base_url('logout') ?>" class="btn btn-xs btn-danger btn-sm mb-0">Logout</a>
											</div>
										</div>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>

		<?php require_once('sidebar.php'); ?>

        <div class="main-panel">
			<div class="content">
<!-- ========================== Batas Header ========================== -->