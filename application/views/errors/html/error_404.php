<?php
defined('BASEPATH') or exit('No direct script access allowed');
$ci = new CI_Controller();
// Get the ci instance
$ci = get_instance();
// Load the url helper
$ci->load->helper('url');
// Get the csrf token
$csrf = array(
	'name' => $ci->security->get_csrf_token_name(),
	'hash' => $ci->security->get_csrf_hash()
);
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="Dennis Otieno - email: otienodennis29@gmail.com" />
	<meta name="robots" content="" />
	<meta name="<?= $csrf['name'] ?>" content="<?= $csrf['hash'] ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Some description for the page" />
	<meta property="og:title" content="GetSkills  : GetSkills Online Learning  Admin Laravel Template" />
	<meta property="og:description" content="GetSkills  : GetSkills Online Learning  Admin Laravel Template" />
	<meta property="og:image" content="../../xhtml/social-image.html" />
	<meta name="format-detection" content="telephone=no">
	<title>Delivisha | Page Error 404</title>
	<!-- Favicon icon -->
	<link rel="shortcut icon" type="image/png" href="<?= site_url() ?>public/assets/images/favicon.png">
	<link href="<?= site_url() ?>public/assets/css/style.css" rel="stylesheet">
	<link href="<?= site_url() ?>public/assets/css/main.css" rel="stylesheet">


</head>

<body class="vh-100">
	<div class="authincation h-100">
		<div class="container h-100">
			<div class="row justify-content-center h-100 align-items-center">
				<div class="col-md-7">
					<div class="form-input-content text-center error-page">
						<h1 class="error-text fw-bold">404</h1>
						<h4><i class="fa fa-exclamation-triangle text-warning"></i> The page you were looking for is not found!</h4>
						<p>You may have mistyped the address or the page may have moved.</p>
						<div>
							<a class="btn btn-primary nav-button" href="index.html" onclick="window.history.go(-1); return false;">Back to Home</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--**********************************
        Scripts
    ***********************************-->


	<script src="<?= site_url() ?>public/assets/vendor/global/global.min.js" type="text/javascript"></script>
	<script src="<?= site_url() ?>public/assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js" type="text/javascript"></script>
	<script src="<?= site_url() ?>public/assets/js/custom.min.js" type="text/javascript"></script>
	<script src="<?= site_url() ?>public/assets/js/dlabnav-init.js" type="text/javascript"></script>
	<!-- <script src="<?= site_url() ?>public/assets/js/demo.js" type="text/javascript"></script>
	<script src="<?= site_url() ?>public/assets/js/styleSwitcher.js" type="text/javascript"></script> -->



</body>

</html>
