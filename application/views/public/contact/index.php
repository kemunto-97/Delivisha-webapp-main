<?php
// Get the csrf token
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
?>

<body class="body  h-100 front-body">
	<?php $this->load->view('public/components/chatbot') ?>

	<?php $this->load->view('public/components/navbar') ?>
	<!-- Main body container -->
	<div class="container mt-4">
		<div class="row h-100 align-items-center justify-contain-center">
			<div class="col-xl-12 mt-3">
				<div class="card">
					<div class="card-body p-0">

						<div class="row m-0">
							<div class="col-xl-6 col-md-6 sign text-center">
								<div>
									<div class="text-center my-5">
										<a href="<?= base_url() ?>"><img width="200" src="<?= base_url() ?>public/images/delivisha_logo.png" alt=""></a>
									</div>
									<img src="<?= base_url() ?>public/images/contact.svg" class="education-img"></img>
								</div>
							</div>

							<div class="col-xl-6 col-md-6">
								<div class="sign-in-your">
									<div class="mb-5">
										<a href="<?= site_url() ?>" class="float-start">
											<i class="fa fa-arrow-left me-2 fa-lg text-warning"></i> Back
										</a>
									</div>

									<h4 class="fs-20 font-w800 text-black">Live us <span class="text-warning">a</span> Message</h4>
									<div class="mb-3">
										<span class="">Leave a message and we will get back to you in 24 hours time.</span>
									</div>
									<!-- Error Success Response Messages -->
									<div class="contactResponseMessages mt-3 mb-3"></div>

									<form action="<?= site_url("send_email") ?>" class="comment-form" id="contact_form" method="post">
										<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
										<div class="row">
											<div class="col-lg-12">
												<div class="mb-3">
													<label for="author" class="text-black font-w600 form-label">Full Name <span class="required">*</span></label>
													<input type="text" class="form-control" value="" name="customer_name" placeholder="Please provide your full name here" id="author">
													<span></span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="mb-3">
													<label for="email" class="text-black font-w600 form-label">Email <span class="required">*</span></label>
													<input type="text" class="form-control" value="" placeholder="Enter your email" name="email" id="email">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="mb-3">
													<label for="phone" class="text-black font-w600 form-label">Phone Number <span class="required">*</span></label>
													<input type="number" class="form-control" value="" placeholder="Enter your phone number" name="phone" id="phone">
												</div>
											</div>
											<div class="col-lg-12">
												<div class="mb-3">
													<label for="subject" class="text-black font-w600 form-label">Subject <span class="required">*</span></label>
													<input type="text" class="form-control" value="" name="subject" placeholder="provide a subject" id="subject">
												</div>
											</div>
											<div class="col-lg-12">
												<div class="mb-3">
													<label for="message" class="text-black font-w600 form-label">Message</label>
													<textarea rows="5" class="form-control" name="message" placeholder="Enter your message here" id="message"></textarea>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="mb-3">
													<button type="submit" class="btn btn-primary btn-block blinking-button" id="">Send Message</button>
												</div>
												<div class="g-recaptcha" data-sitekey="<?= $captcha_key ?>"></div>
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
	</div>
	<!-- Main body container End -->
