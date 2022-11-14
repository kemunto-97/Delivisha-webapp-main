<?php
// Get csrf token
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
// Get the user details
$userDetails = $user_data;
$user_name = $userDetails->first_name . ' ' . $userDetails->last_name;
$user_id = $user_id;
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
										<a href="<?= base_url('login') ?>"><img src="<?= base_url() ?>public/images/delivisha_logo.png" alt=""></a>
									</div>

									<?php if ($token_validity == 1) : ?>
										<div class="alert alert-secondary notification my-2">
											<p class="notificaiton-title mb-2"><strong>Hello <?= $user_name ?></strong></p>
											<p>If you are here that means you forgot your password change it now. 😌</p>
										</div>

										<!-- Reset Password Messages -->
										<div id="resetPasswordMessages" class="my-2 text-left"></div>

										<!-- Change Password inputs -->
										<div class="">
											<h4 class="text-center mb-2">Change Password</h4>
											<div id="usersLoginMessages3" class="mb-2"></div>
											<form action="<?= site_url('backend/authentication/change_password') ?>" method="post" id="userResetPasswordForm">
												<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
												<input type="hidden" name="user_id" value="<?= $user_id ?>">
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
									<?php else : ?>

										<div class="alert alert-warning notification my-2">
											<p class="notificaiton-title mb-2"><strong>Window Exired! </strong></p>
											<p>SORRY! your time has expired, plese send a new request to reset your account password. This process is valid for 15 mins. </p>
										</div>

									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
