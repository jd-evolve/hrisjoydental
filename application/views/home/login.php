<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Login Account</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link rel="icon" href="<?= base_url() ?>assets/img/favicon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>
<body class="login">
    <form novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
		<div class="wrapper wrapper-login">
			<div class="container container-login animated fadeIn">
				<div class="panel-heading text-center">
					<h1 class="text-center fw-bold mt-5">Klinik Joy Dental</h1>
					<h5 class="mb-5">Human Resource Information System</h5><hr>
					<h4 class="panel-title text-center fw-bold pb-5"> </h4>
				</div>
				<div class="card-login p-3 mb-3" style="margin-top: -50px;">
				
					<h4 class="fw-bold text-dark-blue text-center mb-3">Login Member</h4>
					<div class="card-sub text-center alert-login mb-2 px-1">Masukkan email & password dengan benar!</div>
					<div class="login-form">
						<div class="form-group form-floating-label">
							<input type="email" class="form-control input-pill" id="email" name="email" placeholder="Email" required>
						</div>
						<div class="form-group">
							<div class="position-relative">
							<input type="password" class="form-control input-pill" id="password" name="password" placeholder="Password" required>
								<div class="show-password">
									<i class="flaticon-interface"></i>
								</div>
							</div>
						</div>
						<div class="form-group pb-0">
							<button type="submit" id="login" class="btn bg-purple btn-rounded btn-block fw-bold">Login</button>
						</div>
					</div>
				</div>
				
				<div class="m-0 mb-2 pt-0 text-12-gray text-center">
					<a href="#" id="lupa_password" class="link text-dark-blue">Lupa Password ?</a>
				</div>
			</div>
		</div>
    </form>
	
	<script src="<?= base_url() ?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
	<script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/ready.js"></script>

	<script>
		$('body').on('click','#lupa_password',function(){
			swal("Hubungi admin untuk merubah password",{
				icon: "info",
			});
		});
		
		$("body").on("click", "#login", function (e) {
			e.preventDefault();
			let email = $('input[name="email"]').val();
			let password = $('input[name="password"]').val();
			if(email == ""){
				swal("Gagal","Email tidak boleh kosong!",{
					icon: "error",
					buttons:{
						confirm:{
							className: "btn btn-danger",
						},
					},
				});
			} else if(password == ""){
				swal("Gagal","Password tidak boleh kosong!",{
					icon: "error",
					buttons:{
						confirm:{
							className: "btn btn-danger",
						},
					},
				});
			} else{
				console.log('ok')
				$.ajax({
					type: "POST",
					url: "home/login",
					dataType: "json",
					data: {
						'email': email,
						'password': password,
					},
					success: function(output){
						let message = output.message;
						let result = output.result;
						
						if(result == 'error'){
							swal("Gagal",message,{
								icon: "error",
								buttons:{
									confirm:{
										className: "btn btn-danger",
									},
								},
							});
						}else{
							document.location.href = message + 'dashboard';
						}
					}
				});
			}
		});
	</script>
</body>
</html>