<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/css/app.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/notifications/css/lobibox.min.css" />
	<title><?= title() ?></title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">LOGIN</h3>
										<!-- <p>Anda belum memiliki akun ? <a href="#">Daftar Disini</a> -->
										</p>
									</div>
									<div class="login-separater text-center mb-4"> <span>LOGIN</span>
										<hr />
									</div>
									<div class="form-body">
										<form class="row g-3" id="form_">
											<div class="col-12">
												<label for="inputEmailOrUsername" class="form-label">Email / Username</label>
												<div class="form-input">
													<input type="text" class="form-control" id="inputEmailOrUsername" placeholder="Email / Username" name='email' required>
												</div>
											</div>
											<div class="col-12">
												<label for="password" class="form-label">Password</label>
												<div class="form-input">
													<input type="password" class="form-control" id="password" name='password' placeholder="Password" required>
												</div>
											</div>
											<div class="col-12">
												<div class="g-recaptcha" data-sitekey="6LflfkUcAAAAAPUTNY54rotjywnatBfJa6PNumJP"></div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<div class="col-md-6 text-end"> <a href="#">Forgot Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="button" id="submitLogin" class="btn btn-primary"><i class="fa fa-user"></i> Login</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="<?= base_url() ?>assets/plugins/notifications/js/lobibox.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/notifications/js/notification-custom-script.js"></script>
	<script src="<?= base_url() ?>assets/plugins/notifications/js/notifications.min.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function() {
			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="<?= base_url() ?>assets/js/app.js"></script>
	<script src="<?= base_url('assets/') ?>plugins/jquery-validation/jquery.validate.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script>
		$('#submitLogin').click(function() {
			// Swal.fire('Any fool can use a computer')
			$('#form_').validate({
				highlight: function(element, errorClass, validClass) {
					var elem = $(element);
					if (elem.hasClass("select2-hidden-accessible")) {
						$("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass);
					} else {
						$(element).parents('.form-input').addClass('has-error');
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					var elem = $(element);
					if (elem.hasClass("select2-hidden-accessible")) {
						$("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
					} else {
						$(element).parents('.form-input').removeClass('has-error');
					}
				},
				errorPlacement: function(error, element) {
					var elem = $(element);
					if (elem.hasClass("select2-hidden-accessible")) {
						element = $("#select2-" + elem.attr("id") + "-container").parent();
						error.insertAfter(element);
					} else {
						error.insertAfter(element);
					}
				}
			})
			var values = new FormData($('#form_')[0]);
			if ($('#form_').valid()) // check if form is valid
			{
				$.ajax({
					beforeSend: function() {
						$('#submitLogin').html('<i class="fa fa-spinner fa-spin"></i> Process');
						$('#submitLogin').attr('disabled', true);
					},
					enctype: 'multipart/form-data',
					url: '<?= site_url('auth/login') ?>',
					type: "POST",
					data: values,
					processData: false,
					contentType: false,
					// cache: false,
					dataType: 'JSON',
					success: function(response) {
						if (response.status == 1) {
							window.location = response.url;
						} else {
							round_error_noti(response.pesan);
							$('#submitLogin').attr('disabled', false);
						}
						$('#submitLogin').html('<i class="fa fa-user"></i> Login');
					},
					error: function() {
						round_error_noti('Telah terjadi kesalahan. Silahkan refresh halaman');
						$('#submitLogin').html('<i class="fa fa-user"></i> Login');
						$('#submitLogin').attr('disabled', false);

					}
				});
			} else {
				round_error_noti('Silahkan tentukan field yang wajib diisi')
			}
		})
	</script>
</body>

</html>