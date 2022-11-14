<?php
// Get csrf token
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>

<body class="vh-100">
	<div class="authincation h-100">
		<div class="container h-100">
			<div class="row justify-content-center h-100 align-items-center">
				<div class="col-md-6">
					<div class="authincation-content">
						<div class="row no-gutters">
							<div class="col-xl-12">
								<div class="auth-form">
									<!-- close button -->
									<a href="javascript:;" id="sendOtpCloseBtn" class="float-end sendOtpArea d-none"><i class="fa fa-close fa-xl"></i></a>
									<!-- Company Logo -->
									<div class="text-center mb-3">
										<a href="<?= base_url() ?>"><img src="<?= base_url() ?>public/images/delivisha_logo.png" alt=""></a>
									</div>

									<!-- Login users -->
									<div class="loginArea">
										<h4 class="text-center mb-2">Access Account</h4>
										<div id="usersLoginMessages" class="mb-2"></div>
										<small class="text-center mb-3">Enter your email address and password to access account. Please note that after the second login attempt you will be prompted to reset your password we strongly advice you do that but, you can choose to proceed if you remembered your password.</small>
										<form class="mt-3" action="<?= site_url('backend/authentication/login_users') ?>" method="post" id="userLoginForm1" autocomplete="off">
											<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
											<div class="mb-3">
												<label><strong>Phone or Email</strong></label>
												<input type="text" name="username" class="form-control" value="" placeholder="Please enter email or phone number">
											</div>
											<div class="mb-3">
												<label><strong>Password</strong></label>
												<input type="password" name="password" id="password-field" class="form-control" value="">
												<span toggle="#password-field" style="color: #fd7575;" class="fa fa-fw fa-eye field-icon fa-lg toggle-password"></span>
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-primary btn-block blinking-button">Unlock</button>
											</div>
										</form>
									</div>

									<!-- Send Otp verification -->
									<div class="sendOtpArea d-none">
										<h4 class="text-center mb-2">Send OTP</h4>
										<div style="border: 1px solid #f0a900; padding: 5px; border-radius: 10px;">
											<small class="text-warning">We recommend that you reset your account before it gets locked, you only have one chance left. If you still sure you remember the password feel free to skip this part.</small>
										</div>
										<div id="sendOtpMessages" class="mb-2 mt-2"></div>
										<form action="<?= site_url('backend/authentication/send_otp') ?>" method="post" id="userLoginFormSendOtp">
											<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
											<div class="mb-3">
												<label><strong>Email Address</strong></label>
												<input type="text" name="email" class="form-control" value="" placeholder="Please enter email address">
											</div>
											<!-- checkbox for send to my phone -->
											<div class="mb-3">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="send_to_phone" value="1" style="display: block !important;">
													<label class="form-check-label" for="flexSwitchCheckDefault">Send to my phone</label>
												</div>
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-primary btn-block blinking-button">Send OTP</button>
											</div>
										</form>
									</div>

									<!-- Change Password inputs -->
									<div class="changePasswordArea d-none">
										<h4 class="text-center mb-2">Change Password</h4>
										<div id="usersLoginMessages3" class="mb-2"></div>
										<form action="<?= site_url('backend/authentication/change_password') ?>" method="post" id="userLoginFormChangePassword">
											<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
											<div class="mb-3">
												<label><strong>New Password</strong></label>
												<input type="password" name="password" class="form-control" placeholder="Enter a new password">
											</div>
											<div class="mb-3">
												<label><strong>Confirm Password</strong></label>
												<input type="password" name="confirm_password" class="form-control" placeholder="Confirm the new password">
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-primary btn-block blinking-button">Change Password</button>
											</div>
										</form>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal for OTP verification -->
			<div class="modal" id="verifyLoginOTPModal">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body" style="background:#f1e4e4;">
							<div class="row">
								<div class="col-md-12">
									<!-- closing icon -->
									<i class="fa fa-times fa-xl float-end cancelModalVOTP" style="cursor:pointer;"></i>
									<div class="form-group">
										<div class="text-center">
											<div class="mb-3">
												<img src="<?= site_url('public/images/short-logo.svg') ?>" width="100" alt="Delivisha Logo">
											</div>
										</div>

										<!-- Verify otp inputs -->
										<div class="">
											<h4 class="text-center mb-2">Verify OTP</h4>
											<div id="verifyOtpMessages text-left" class="mb-2"></div>
											<form action="<?= site_url('backend/authentication/verify_otp') ?>" method="post" id="userLoginFormVerifyOtp">
												<div class="row text-center mt-3">
													<div class="offset-1 col-10">
														<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(1)' maxlength=1 name="code_one">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(2)' maxlength=1 name="code_two">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(3)' maxlength=1 name="code_three">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(4)' maxlength=1 name="code_four">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(5)' maxlength=1 name="code_five">
														<input class="otp input_otp_2" type="text" oninput='digitValidate2(this)' onkeyup='tabChange2(6)' maxlength=1 name="code_six">

														<button type="submit" class="btn btn-primary btn-block blinking-button mt-3">Verify OTP</button>
													</div>
												</div>
											</form>
										</div>

										<!-- Hint -->
										<div class="text-center mt-3">
											<small class="text-muted">Please enter the code you have been sent via sms or email to reset your account. This step is active for 15 mins after this the code will be expired and you will have to start a fresh.</sma>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
