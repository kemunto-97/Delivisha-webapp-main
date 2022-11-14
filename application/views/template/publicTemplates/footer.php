<?php
// Get the form data
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'customer_account' || $this->uri->segment(1) == 'order_tracking' || $this->uri->segment(1) == 'contact' || $this->uri->segment(1) == 'shop' || $this->uri->segment(1) == 'products') : ?>
	<!-- footer with social links -->
	<div class="text-center" style="background:#474646;">
		<div class="container">
			<div class="row" style="padding: 10px 0">
				<div class="offset-md-3 col-md-6">
					<ul class="list-unstyled">
						<img src="<?= site_url('public/images/delivisha_dark.png') ?>" alt="" width="200">
						<p>&copy; Copyright 2022 - <?= date('Y') ?> all rights reserved.</p>
					</ul>
				</div>
			</div>

		</div>
	</div>
	<!-- footer with social links -->
<?php endif; ?>

<!-- Login Modal -->
<div class="modal animate__animated animate__backInUp" id="LoginModal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body" style="background:#f1e4e4;">
				<div class="">
					<!-- closing icon -->
					<i class="fa fa-times fa-xl float-end cancelLoginModal" style="cursor:pointer;"></i>
					<h4 class="text-center mb-4 fs-20 font-w800 text-black">Access Account</h4>
					<div id="loginResponseMessage"></div>

					<!-- Login Form -->
					<form action="<?= site_url('login_customer') ?>" method="post" id="userLoginForm2">
						<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
						<input type="hidden" name="g-recaptcha-response" id="">
						<div class="mb-3">
							<label><strong>Phone Number</strong></label>
							<input type="number" class="form-control" value="" name="phone_number" placeholder="Please provide your phone number 07XXXXXXXX">
						</div>
						<div class="mb-3">
							<input type="checkbox" class="form-check-input" id="" name="sendToMe2" style="display:inline-block !important;" value="1">
							<label class="form-check-label text-black font-w800" for="basic_checkbox_2">Send OTP to my phone</label>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-block blinking-button">Sign In</button>
						</div>
						<!-- Google recaptcha -->
						<div class="g-recaptcha" data-sitekey="<?= $captcha_key ?>"></div>
						<!-- link to register form -->
						<div class="new-account mt-3">
							<p class="displayRegistrationLink">Don't have an account? <a class="text-primary" href="javascript:;" id="showRegistrationForm">Sign up</a></p>
						</div>
					</form>

					<!-- Registration Form -->
					<form class="d-none" action="<?= site_url('new_customer_registration') ?>" method="post" id="registerNewCustomer" autocomplete="off">
						<!-- Get the csrf token -->
						<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
						<div class="row">
							<div class="form-group">
								<div class="col-md-12">
									<div class="mb-3">
										<label>First Name</label>
										<input type="text" class="form-control" id="first_name1" name="first_name1" placeholder="First Name">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label>Last Name</label>
										<input type="text" class="form-control" id="last_name1" name="last_name1" placeholder="Last Name">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label>Email Address</label>
										<input type="text" class="form-control" id="emailAddress1" name="emailAddress1" placeholder="Enter email address">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label>Phone Number</label>
										<input type="number" class="form-control" id="phoneNumber1" name="phoneNumber1" placeholder="Enter phone number">
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<button type="submit" class="btn btn-primary blinking-button btn-block">Submit Details</button>
										<div class="g-recaptcha" data-sitekey="<?= $captcha_key ?>"></div>
									</div>
								</div>
								<!-- Link to Login -->
								<div class="new-account mt-3">
									<p>Already have an account? <a class="text-primary" href="javascript:;" id="showLoginForm">Sign in</a></p>
								</div>
							</div>
						</div>
					</form>

					<!-- Verify OTP inputs -->
					<div class="row d-none animate__animated animate__backInDown" id="verifyOTP">
						<div class="col-md-12 bgWhite text-center">
							<div class="title">
								Verify OTP
							</div>
							<form action="<?= site_url('verify_cuatomer_otp') ?>" class="mt-3 mb-5" id="verifyCustomerOtp">
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(1)' maxlength=1 name="code1">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(2)' maxlength=1 name="code2">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(3)' maxlength=1 name="code3">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(4)' maxlength=1 name="code4">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(5)' maxlength=1 name="code5">
								<input class="otp input_otp1" type="text" oninput='digitValidate1(this)' onkeyup='tabChange1(6)' maxlength=1 name="code6">

								<div class="row text-center mt-3">
									<div class="offset-2 col-8">
										<button type="submit" class="btn btn-primary btn-block blinking-button">Verify OTP</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>public/assets/vendor/global/global.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/vendor/jquery-steps/build/jquery.steps.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/vendor/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/js/plugins-init/jquery.validate-init.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/vendor/swiper/js/swiper-bundle.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/js/dlab.carousel.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>public/assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/js/custom.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/js/dlabnav-init.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/assets/js/demo.js" type="text/javascript"></script>
<!-- <script src="<?= base_url() ?>public/assets/js/styleSwitcher.js" type="text/javascript"></script> -->
<script src="<?= base_url() ?>public/custom-files/jquery_convform.js" type="text/javascript"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<!-- Added -->
<script src="<?= base_url() ?>public/assets/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js" type="text/javascript"></script>

<script>
	var rollbackTo = false;
	var originalState = false;

	function storeState(stateWrapper, ready) {
		rollbackTo = stateWrapper.current;
		console.log("storeState called: ", rollbackTo);
		ready();
	}

	function rollback(stateWrapper, ready) {
		console.log("rollback called: ", rollbackTo, originalState);
		console.log("answers at the time of user input: ", stateWrapper.answers);
		if (rollbackTo != false) {
			if (originalState == false) {
				originalState = stateWrapper.current.next;
				console.log('stored original state');
			}
			stateWrapper.current.next = rollbackTo;
			console.log('changed current.next to rollbackTo');
		}
		ready();
	}

	function restore(stateWrapper, ready) {
		if (originalState != false) {
			stateWrapper.current.next = originalState;
			console.log('changed current.next to originalState');
		}
		ready();
	}

	$(document).ready(function() {
		const convform = $('#chat').convform({
			selectInputStyle: 'disable'
		});
		console.log(convform);
	});

	// This function formats numbers with thousands separators
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
</script>

<!-- Include the javascript files -->
<?php $this->load->view('javascript.php') ?>

</body>

</html>
