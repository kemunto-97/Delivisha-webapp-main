<?php
// Get the csrf token
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
// Get session data
$customerName = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
$customerEmail = $this->session->userdata('email');
// Get the customer orders
$orders = get_customer_orders($this->session->userdata('user_id'), 'deli_orders');
// Get the customer orders count
$ordersCount = get_customer_orders_count($this->session->userdata('user_id'), 'deli_orders');

?>

<body class="body h-auto front-body">
	<?php $this->load->view('public/components/chatbot') ?>

	<?php $this->load->view('public/components/navbar') ?>
	<!-- Main body container -->
	<div class="container h-100 mt-4 mb-2">
		<div class="row h-100 align-items-center justify-contain-center">
			<div class="col-xl-12 mt-3">
				<div class="card">
					<div class="card-body p-0">

						<div class="row m-0">
							<div class="col-xl-4 col-md-4 sign text-center d-none d-md-block">
								<div>
									<div class="text-center my-5">
										<h4 class="fs-24 font-w800 text-black">Welcome back!</h4>
									</div>
									<img src="<?= base_url() ?>public/images/profile.svg" class="education-img" style="position:relative;"></img>
									<div class="mt-4">
										<div class="card-body">
											<div class="profile-blog">
												<h5 class="text-primary d-inline">Today Highlights</h5>
												<img src="<?= site_url('public/images/deliver-img.jpeg') ?>" alt="" class="img-fluid mt-4 mb-4 w-100 rounded">
												<h4><a href="" class="text-black">Delivisha na sisi save time</a></h4>
												<p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-8 col-md-8">
								<div class="col-lg-12">
									<div class="profile card card-body px-3 pt-3 pb-0">
										<div class="profile-head">
											<div class="photo-content">
												<div class="cover-photo rounded"></div>
											</div>
											<div class="profile-info">
												<div class="profile-photo">
													<img src="<?= site_url('public/images/profile-avater.png') ?>" class="img-fluid rounded-circle" alt="">
												</div>
												<div class="profile-details">
													<div class="profile-name px-3 pt-2">
														<h4 class="text-primary mb-0"><?= $customerName ?></h4>
														<p>Customer Account</p>
													</div>
													<div class="profile-email px-2 pt-2">
														<h4 class="text-muted mb-0"><?= $customerEmail ?></h4>
														<p>Email</p>
													</div>
													<div class="dropdown ms-auto">
														<a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<circle fill="#000000" cx="5" cy="12" r="2"></circle>
																	<circle fill="#000000" cx="12" cy="12" r="2"></circle>
																	<circle fill="#000000" cx="19" cy="12" r="2"></circle>
																</g>
															</svg></a>
														<ul class="dropdown-menu dropdown-menu-end">
															<li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i> View profile</li>
															<li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to btn-close friends</li>
															<li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to group</li>
															<li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xl-6 col-xxl-6 col-sm-12">
										<div class="card bg-success widget-courses style-2">
											<div class="card-body">
												<div class="align-items-center d-flex justify-content-between flex-wrap">
													<div class="d-flex">
														<img src="<?= site_url('public/images/package1.svg') ?>" alt="" width="50">
														<div class="ms-4">
															<h4 class="fs-18 font-w700">50</h4>
															<span>Total Deliveries</span>
														</div>
													</div>
													<div class="d-inline-block position-relative donut-chart-sale">
														<span class="donut1" data-peity='{ "fill": ["rgba(255, 255, 255, 1)", "rgba(255, 255, 255, 0.1"],   "innerRadius": 15, "radius": 8}'>40/50</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-xl-6 col-xxl-6 col-sm-12">
										<div class="card bg-primary widget-courses style-2">
											<div class="card-body">
												<div class="align-items-center d-flex justify-content-between flex-wrap">
													<div class="d-flex">
														<img src="<?= site_url('public/images/package1.svg') ?>" alt="" width="50">
														<div class="ms-4">
															<h4 class="fs-18 font-w700">10</h4>
															<span>Cancelled Deliveries</span>
														</div>
													</div>
													<div class="d-inline-block position-relative donut-chart-sale">
														<span class="donut1" data-peity='{ "fill": ["rgba(255, 255, 255, 1)", "rgba(255, 255, 255, 0.1"],   "innerRadius": 15, "radius": 8}'>10/50</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-lg-12">
										<div class="card">
											<div class="card-header">
												<h4 class="card-title">Recent Orders</h4>
											</div>
											<div class="card-body">
												<div class="table-responsive">
													<table class="table header-border table-responsive-sm">
														<thead>
															<tr>
																<th>Invoice</th>
																<th>Date</th>
																<th>Amount</th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td><a href="javascript:void();">Order #26589</a>
																</td>
																<td><span class="text-muted">Oct 16, 2017</span>
																</td>
																<td>KES 450.00</td>
																<td><span class="badge badge-success">Delivered</span>
																</td>
															</tr>
															<tr>
																<td><a href="javascript:void();">Order #58746</a>
																</td>
																<td><span class="text-muted">Oct 12, 2017</span>
																</td>
																<td>KES 245.30</td>
																<td><span class="badge badge-info light">Pending</span>
																</td>
															</tr>
															<tr>
																<td><a href="javascript:void();">Order #98458</a>
																</td>
																<td><span class="text-muted">May 18, 2017</span>
																</td>
																<td>KES 380.00</td>
																<td><span class="badge badge-danger">Cancelled</span>
																</td>
															</tr>
														</tbody>
													</table>
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
		</div>
	</div>
	<!-- Main body container End -->
