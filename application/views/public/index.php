<?php
// Get the form data
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>

<body class="body  h-100 front-body" style="overflow:auto !important;">
	<?php $this->load->view('public/components/chatbot') ?>

	<?php $this->load->view('public/components/navbar') ?>

	<!-- End Navbar with links right -->
	<div class="container mt-5">
		<div class="row align-items-center justify-contain-center">
			<!-- Carousel -->
			<div class="col-12 mb-0">
				<div class="card">
					<div class="card-body p-2">
						<div class="bootstrap-carousel">
							<div class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img class="d-block w-100" src="<?= site_url() ?>public/images/slider-img/slider1.png" alt="First slide">
										<div class="carousel-caption d-none d-md-block">
											<h5>First slide label</h5>
											<p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
										</div>
									</div>
									<div class="carousel-item">
										<img class="d-block w-100" src="<?= site_url() ?>public/images/slider4.png" alt="Second slide">
										<div class="carousel-caption d-none d-md-block">
											<h5>Second slide label</h5>
											<p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
										</div>
									</div>
									<div class="carousel-item">
										<img class="d-block w-100" src="<?= site_url() ?>public/images/slider-img/slider2.png" alt="Third slide">
										<div class="carousel-caption d-none d-md-block">
											<h5>Third slide label</h5>
											<p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Search Form -->
						<div id="cover">
							<form method="POST" action="<?= site_url('tracking/track_delivery_order') ?>" class="track-form" id="trackYourPackage" autocomplete="off">
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<div class="tb-deli">
									<div class="td-deli">
										<input type="text" name="waybill_number" id="waybill_number" placeholder="Waybill" class="track-input">
									</div>
									<div class="td-deli" id="s-cover">
										<button type="submit" class="track-button">
											<div id="s-circle"></div>
											<span class="track-style-btn"></span>
										</button>
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
			<!-- About Delivisha -->
			<div class="col-12 mb-0">
				<div class="card">
					<div class="card-body p-4">
						<div class="row">
							<div class="col-12">
								<h4 class="fs-24 font-w800 text-black">Welcome to Deli<span style="color:#c6164f;">Visha</span> Logistics</h4>
								<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl nec aliquam aliquam,
									nunc nisl aliquet nunc, eget aliquam nisl nisl sit amet lorem. Nulla facilisi. Sed euismod, nisl nec aliquam aliquam,
									nunc nisl aliquet nunc, eget aliquam nisl nisl sit amet lorem. Nulla facilisi.</p>
								<p class=""> Sed euismod, nisl nec aliquam aliquam, nunc
									nisl aliquet nunc, eget aliquam nisl nisl sit amet lorem. Nulla facilisi. Sed euismod, nisl nec aliquam aliquam, nunc nisl aliquet
									nunc, eget aliquam nisl nisl sit amet lorem. Nulla facilisi. </p>
								<!-- Signin Link -->
								<div class="row">
									<div class="col-md-6 mb-3">
										<?php if (!$this->session->userdata('logged_in')) : ?>
											<a href="javascript:;" class="btn btn-primary btn-block blinking-button logincustomerbtn">Sign In</a>
										<?php else : ?>
											<a href="<?= site_url() ?>order" class="btn btn-primary btn-block" style="border-radius: 0 !important;"><i class="fa fa-shopping-bag"></i> Place Order</a>
										<?php endif; ?>
									</div>
									<div class="col-md-6">
										<a href="javascript:;" id="loadCalculationModal" style="background:#fff1ef;border-radius: 0 !important;" class="btn btn-block"><i class="fa fa-calculator me-2 fa-lg" style="color:#c6164f;"></i>Calculate Your Delivery Charges</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Action Section -->
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body p-0">

						<div class="row m-0">
							<div class="col-xl-6 col-md-6 sign text-center">
								<div>
									<div class="text-center my-5">
										<!-- <a href="<?= base_url() ?>"><img width="200" src="<?= base_url() ?>public/images/delivisha_logo.png" alt=""></a> -->
									</div>
									<img src="<?= base_url() ?>public/images/landing.svg" class="education-img"></img>
								</div>
							</div>

							<div class="col-xl-6 col-md-6">
								<div class="sign-in-your">
									<div class="mb-5">
										<a href="" class="float-end">
											More <i class="fa fa-arrow-right me-2 fa-lg text-warning"></i>
										</a>
									</div>

									<h4 class="fs-20 font-w800 text-black">Tuna<span style="color:#c6164f;">delivisha</span> Popote ulipo</h4>
									<span class="larger-font">We take care of your delivery need instantly without you having to moving an inch from what you are doing, this way you do not have to worry about the safety of your package we got you covered. <br><br>
										Just let us know what you want us to collect and the place you want it delivered and we shall take care of the rest.</span>
									<div class="login-social">
										<a href="javascript:void(0);" id="requestADelivery" class="btn font-w800 d-block my-4"><i class="fa fa-truck-front me-2 fa-lg" style="color:#c6164f;"></i>Request a Delivery</a>
										<a href="#trackYourPackage" id="trackingPackage" class="btn font-w800 d-block my-4"><i class="fa fa-location-dot me-2 fa-lg" style="color:#c6164f;"></i>Track your Order</a>
										<!-- <a href="<?= site_url('contact') ?>" class="btn font-w800 d-block my-4"><i class="fa fa-phone me-2 fa-lg" style="color:#c6164f;"></i> Contact us Now</a> -->
									</div>

									<div class="text-center">
										<button id="goToLogin" type="submit" login_url="<?= base_url('login') ?>" class="btn btn-primary btn-block blinking-button">Sign Me In</button>
									</div>

									<div class="wrapper1 mt-3">
										<a href="#" class="icon facebook">
											<div class="tooltip">Facebook</div>
											<span><i class="fab fa-facebook-f"></i></span>
										</a>
										<a href="#" class="icon twitter">
											<div class="tooltip">Twitter</div>
											<span><i class="fab fa-twitter"></i></span>
										</a>
										<a href="#" class="icon instagram">
											<div class="tooltip">Instagram</div>
											<span><i class="fab fa-instagram"></i></span>
										</a>
										<!-- <a href="#" class="icon youtube">
											<div class="tooltip">Youtube</div>
											<span><i class="fab fa-youtube"></i></span>
										</a> -->
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Phone Number Verification Modal -->
	<div class="modal animate__animated animate__fadeInLeft" id="requestDeliveryModal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body" style="background:#f1e4e4;">
					<div class="row mb-3 modalImage" align="center">
						<div class="col-md-12">
							<!-- closing icon -->
							<i class="fa fa-times fa-xl float-end cancelPhoneVerification" style="cursor:pointer;"></i>
							<?php if ($this->session->userdata('logged_in')) : ?>
								<img src="<?= site_url("public/images/ordered.svg") ?>" class="" alt="" height="300">
							<?php else : ?>
								<img src="<?= site_url("public/images/unlock.svg") ?>" class="" alt="" height="200">
							<?php endif; ?>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12 loginModalTitle">
							<?php if ($this->session->userdata('logged_in')) : ?>
								<h4 class="fs-20 font-w800 text-black text-center">Request a Delivery</h4>
								<div class="mb-3" align="center">Let us know where you want your consignment delivered, use the button below to request a delivery.</div>
							<?php else : ?>
								<h4 class="text-center fs-20 font-w800" style="color: #c6164f !important;">Please Login to continue</h4>
							<?php endif; ?>
						</div>
						<div id="validationErrorMsg"></div>
						<div class="">
							<!-- Phone number form -->
							<form action="<?= site_url('validate_phone_number') ?>" method="post" id="validateCustomerPhoneNumber" class="number_input">
								<!-- Get CSRF -->
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<div class="mb-3 <?= $this->session->userdata('logged_in') ? 'd-none' : '' ?>">
									<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Please enter your phone number 07XXXXXXXX">
								</div>
								<div class="m-3 <?= $this->session->userdata('logged_in') ? 'd-none' : '' ?>">
									<input type="checkbox" class="form-check-input" id="basic_checkbox_1" name="sendToMe" style="display:inline-block !important;" value="1">
									<label class="form-check-label text-black font-w800" for="basic_checkbox_1">Send OTP to my phone</label>
								</div>
								<div class="row">
									<div class="col-6 col-md-6">
										<div class="mb-3">
											<!-- Button with user lock icon -->
											<button <?= $this->session->userdata('logged_in') ? 'disabled' : '' ?> type="button" id="goToRegistrationPage" class="btn btn-primary btn-block blinking-button">Register <i class="mdi mdi-lock-outline"></i></button>
										</div>
									</div>
									<div class="col-6 col-md-6">
										<div class="mb-3">
											<?php if ($this->session->userdata('logged_in')) : ?>
												<a href="<?= site_url('order') ?>" class="btn btn-danger btn-block blinking-button btn-block">Order Now!</a>
											<?php else : ?>
												<button type="submit" class="btn btn-danger btn-block blinking-button btn-block" id="placeOrder">Place Order</button>
											<?php endif; ?>
										</div>
									</div>
									<?php if (!$this->session->userdata('logged_in')) : ?>
										<div class="g-recaptcha" data-sitekey="<?= $captcha_key ?>"></div>
									<?php endif; ?>
								</div>
							</form>

							<!-- OTP Form -->
							<form class="d-none otp_form" action="<?= site_url('submit_otp') ?>" method="get" id="verify_otp">
								<input id="otp_csrf" type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<div class="col-md-12 bgWhite text-center pt-4 pb-5">
									<div class="title mb-3">
										Verify OTP
									</div>
									<form action="" class="">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 name="code_1">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 name="code_2">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 name="code_3">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 name="code_4">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(5)' maxlength=1 name="code_5">
										<input class="otp input_otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(6)' maxlength=1 name="code_6">

										<div class="row text-center mt-3">
											<div class="offset-2 col-8">
												<button type="submit" class="btn btn-primary btn-block blinking-button" id="verify_otp">Verify OTP</button>
											</div>
										</div>
									</form>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Registration Modal -->
	<div class="modal animate__animated animate__fadeInRight" id="registrationModal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body" style="background:#f1e4e4;">
					<div class="row mb-3">
						<div class="col-md-12">
							<!-- closing icon -->
							<i class="fa fa-times fa-xl float-end cancelRegistrationModal" style="cursor:pointer;"></i>
							<h4 class="text-center fs-20 font-w800 text-black">Please Register to continue</h4>
						</div>
						<div id="customerMessages"></div>
						<div class="">
							<form action="<?= site_url('customer_registration') ?>" method="post" id="registerNewClient" autocomplete="off">
								<!-- Get the csrf token -->
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<div class="mb-3">
												<label>First Name</label>
												<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label>Last Name</label>
												<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label>Email Address</label>
												<input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email address">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label>Phone Number</label>
												<input type="number" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number">
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<button type="submit" class="btn btn-primary blinking-button btn-block">Submit Details</button>
											</div>
											<div class="g-recaptcha" data-sitekey="<?= $captcha_key ?>"></div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Tracking Modal -->
	<div class="modal animate__animated animate__fadeInLeft" id="calculationModal" tabindex="-1" role="dialog" aria-labelledby="trackingModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body" style="background:#f1e4e4;">
					<div class="row">
						<form action="<?= site_url('crud_controller/getShippingRecords') ?>" method="POST" class="calc-rates" id="calc-rates">
							<!-- set token -->
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<div class="col-md-12">
								<!-- closing icon -->
								<i class="fa fa-times fa-xl float-end cancelModal" style="cursor:pointer;"></i>
								<div class="form-group">
									<div class="text-center">
										<label for="tracking_number" class="fs-24 font-w800 text-black mb-3">Calculate Shipping Fee</label>
									</div>

									<div class="calculation__form">
										<div class="form-group">
											<label><strong>Package Type</strong></label>
											<select class="form-control" name="package_types" id="package_types">
												<option value="">Select Package Type</option>
												<option value="Document">Document</option>
												<option value="Parcel">Parcel</option>
												<option value="Box">Box</option>
												<option value="Crate">Crate</option>
												<option value="Pallet">Pallet</option>
												<option value="Other">Other</option>
											</select>
											<div class="package_type_error mt-2"></div>
										</div>
										<div class="form-group mt-3">
											<label><strong>Package Weight</strong> (kgs/gms)</label> <small class="text-danger disabled-input"></small>
											<input type="number" class="form-control package_weight_select" name="package_weight" id="package_weight" placeholder="Enter weight">
											<div class="package_weight_error mt-2"></div>
										</div>
										<div class="form-group mt-3">
											<label><strong>Package urgency</strong></label>
											<select class="form-control" name="package_status" id="package_status">
												<option value="">Select Package Urgency</option>
												<option value="1">Normal</option>
												<option value="2">Urgent</option>
											</select>
											<div class="package_status_error mt-2"></div>
										</div>
										<div class="form-group mt-3 Qty_input d-none">
											<label><strong>Package Quantity</strong> (Pcs)</label> <small class="text-danger disabled-input"></small>
											<input type="number" class="form-control package_quantity_select" name="package_quantity" id="package_quantity" placeholder="Package Quantity">
											<div class="package_quantity_error mt-2"></div>
										</div>
										<div class="form-group mt-3">
											<!-- checkbox for send to my phone -->
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="ship__bulk" value="1" style="display: block !important;">
												<label class="form-check-label" for="flexSwitchCheckDefault">Shipping Bulk</label>
											</div>
										</div>
										<!-- Hint -->
										<div class="mt-3 calc-rates">
											<small class="text-muted">Please note that the rates are only estimates and may vary depending on the actual weight of the package. Also make sure all the required inputs are filled</sma>
										</div>
									</div>

									<div class="calculation__result">
										<div id="calculation_results"></div>
									</div>
								</div>
							</div>
							<div class="col-md-12 mt-3">
								<button type="button" class="btn btn-info float-start" id="calculateAgainModal" style="margin-right: 15px;border-radius: 0 !important;">Calculate Again</button>
								<button type="submit" id="calculate__btn" class="btn btn-primary" style="border-radius: 0 !important;">Calculate</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Error/success messages modal -->
	<div class="modal animate__animated animate__bounce animate__repeat-2" id="waybillErrorModel">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body" style="background:#f1e4e4;">
					<div class="">
						<!-- closing icon -->
						<i class="fa fa-times fa-xl float-end cancelWaybillModal" style="cursor:pointer;"></i>
						<!-- Error/success message -->
						<div id="waybillMessages"></div>
						<div class="text-center my-3">
							<img src="<?= site_url("public/images/tracking.svg") ?>" class="" alt="" height="200">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
