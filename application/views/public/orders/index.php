<?php
// Get the csrf token
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>

<body class="body h-100 front-body">
	<?php $this->load->view('public/components/chatbot') ?>

	<?php $this->load->view('public/components/navbar') ?>
	<!-- Main body content -->
	<div class="container mt-4">
		<div class="row h-100 align-items-center justify-contain-center">
			<div class="col-xl-12 mt-3">
				<div class="card">
					<div class="card-body p-0">

						<div class="row m-0">
							<div class="col-xl-6 col-md-6 sign text-center">
								<div class="">
									<div class="mb-3 p-2" align="left" style="border: 1px solid #c6164f;border-radius: 10px;margin-top:20px;">
										<h5 class="fs-20 font-w800 text-black text-center mb-4"><i class="fa fa-info-circle fa-lg" style="color:#c6164f;cursor:pointer;" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="You can pay for your package upon delivery or after placing the order you are free to descide what works for you." title="" data-bs-original-title="Quick Note" aria-describedby="popover634508"></i> Important</h5>
										<p>1. Please make sure to fill in all the required inputs.</p>
										<p>2. The flat rate for deliveries within Nairobi is Ksh. 350/= this might increase depending on the package weight and type.</p>
										<p>3. Make sure to select the "i am not a robot" check-box before you hit the submit order button.</p>
										<p>4. Please NOTE that calculations for your delivery order will be done before the submission of the order and by clicking submit you will pay that very amount upon delivery.</p>
										<p>5. For standard delivery rates select normal, for urgent deliveries you will be charged an extra fee depending on the type and weight of your package.</p>
									</div>
									<img src="<?= base_url() ?>public/images/logistics.svg" class="education-img"></img>
								</div>
							</div>

							<div class="col-xl-6 col-md-6">
								<div class="sign-in-your">
									<div class="mb-5">
										<a href="<?= site_url() ?>" class="float-start">
											<i class="fa fa-arrow-left me-2 fa-lg text-warning"></i> Back
										</a>
										<a href="javascript:;" class="float-end">
											<i class="fa fa-unlock me-2 fa-lg" style="color:#c6164f;" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Lorem ipsum dolor sit amet, \n consectetur adipisicing elit, sed do eiusmod tempor." title="" data-bs-original-title="Hello <?= $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') ?>!" aria-describedby="popover634508"></i>
											<!-- <i class="fa fa-unlock-left me-2 fa-lg" style="color:#c6164f;"></i> -->
										</a>
									</div>

									<h4 class="fs-28 font-w800 text-black">Place <span class="text-warning">Your</span> Order</h4>
									<div class="placeOrderAlert mt-3 mb-3"></div>
									<form action="<?= site_url('order/place_delivery_order') ?>" method="post" id="placeOrderForm" enctype="multipart/form-data" autocomplete="off">
										<!-- Get the csrf name and token -->
										<input type="hidden" name="<?= $csrf['name'] ?>" value="<?= $csrf['hash'] ?>">
										<div class="row">
											<div class="form-group">
												<!-- Hidden Fields -->
												<div class="row">
													<!-- Sender -->
													<div class="col-xl-6 col-md-6">
														<input type="hidden" class="form-control" name="sender_id" value="<?= $this->session->userdata('user_id') ?>" placeholder="Sender Details">
													</div>
													<!-- Delivery Rates -->
													<div class="col-xl-6 col-md-6" id="delivery_rates"></div>
												</div>

												<!-- Sender Address -->
												<div class="row mt-3">
													<!-- Select County -->
													<div class="col-xl-12 col-md-12">
														<label><strong>Sender Address</strong> (Select your county)</label>
														<select class="form-control" name="sender_county" id="sender_county">
															<option value="">Select County</option>
														</select>
													</div>
													<!-- Select a region -->
													<div class="col-xl-12 col-md-12 mt-3">
														<label><strong>Sender Region</strong> (Select your region)</label>
														<select class="form-control" name="sender_region" id="sender_region">
															<option value="">Select a region</option>
														</select>
													</div>
													<!-- Select Sender Street -->
													<div class="col-xl-12 col-md-12 mt-3">
														<label><strong>Sender Street</strong> (Select your street)</label>
														<select class="form-control" name="sender_street" id="sender_street">
															<option value="">Select a street</option>
														</select>
														<input type="hidden" name="sender_street_name" id="sender_street_name">
													</div>
												</div>

												<div class="row mt-3">
													<!-- Reciever Name -->
													<div class="col-xl-6 col-md-6 mb-3">
														<label><strong>Receiver Name</strong></label>
														<input type="text" class="form-control" name="receiver_name" placeholder="Receiver Name">
													</div>
													<!-- Reciever Phone -->
													<div class="col-xl-6 col-md-6">
														<label><strong>Receiver Phone</strong></label>
														<input type="number" class="form-control" name="receiver_phone" placeholder="Receiver Phone">
													</div>
												</div>

												<div class="row mt-3">
													<!-- Package Type -->
													<div class="col-xl-6 col-md-6 mb-3">
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
													</div>
													<!-- Package Weight in Grams and Kgs -->
													<div class="col-xl-6 col-md-6">
														<label><strong>Package Weight</strong> (kgs/gms)</label>
														<input type="number" class="form-control" name="package_weight" id="package_weight" placeholder="Package Weight">
													</div>
												</div>

												<div class="row mt-3 d-none otherInputs">
													<!-- Package Quantity/Number -->
													<div class="col-xl-6 col-md-6">
														<label><strong>Package Quantity</strong> (Pcs)</label>
														<input type="number" class="form-control" name="package_quantity" id="package_quantity" placeholder="Package Quantity">
													</div>

													<!-- Package Urgency -->
													<div class="col-xl-6 col-md-6">
														<label><strong>Package urgency</strong></label>
														<select class="form-control" name="package_status" id="package_status">
															<option value="0">Select Package Urgency</option>
															<option value="1">Normal</option>
															<option value="2">Urgent</option>
														</select>
													</div>
												</div>

												<div class="row mt-3 d-none otherInputs">
													<!-- Package Image -->
													<div class="col-xl-12 col-md-12">
														<label><strong>Package Image</strong></label>
														<input type="file" class="form-control" name="package_image" id="package_image" placeholder="Package Image" oninput="imgPreview.src=window.URL.createObjectURL(this.files[0])">
													</div>
													<img src="<?= site_url('public/images/empty-image.png') ?>" id="imgPreview" class="img-upload-preview mt-3" alt="">
												</div>

												<div class="row my-3 d-none otherInputs">
													<!-- Package Pickup Time -->
													<div class="col-xl-12 col-md-12">
														<label><strong>Package Pickup Time</strong> (Optional)</label>
														<input type="time" class="form-control" name="package_pickup_time" placeholder="Package Pickup Time">
													</div>
												</div>

												<div class="row my-3 d-none otherInputs">
													<!-- Package Description -->
													<div class="col-xl-12 col-md-12">
														<label><strong>Package Description</strong></label>
														<textarea class="form-control" name="package_description" id="package_description" placeholder="Package Description"></textarea>
														<input type="hidden" name="total_delivery_rates" id="total_delivery_rates" value="">
													</div>
												</div>

												<div class="col-md-12 d-none otherInputs">
													<div class="mb-3">
														<button type="submit" class="btn btn-primary blinking-button btn-block" id="placeOrderBtn">Place Order</button>
													</div>
												</div>
												<div class="col-md-12 mt-3">
													<div class="mb-3">
														<button type="button" class="btn btn-warning blinking-button btn-block" id="showOtherInputs">More Inputs</button>
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
		</div>
	</div>
	<!-- End main body content -->
