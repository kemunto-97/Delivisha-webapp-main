<?php
// order details
$order_details = $orderDetails;

$time = $order_details->created_date;
?>

<body class="body front-body h-auto">
	<?php $this->load->view('public/components/chatbot') ?>

	<?php $this->load->view('public/components/navbar') ?>
	<!-- Enter Body content -->
	<div class="container mt-4 mb-4">
		<div class="row align-items-center justify-contain-center">
			<div class="col-xl-12 mt-3">

				<div class="card">
					<div class="card-header">
						<h4 class="fs-20 font-w800 text-black tracking-title">Your package progress <?= time_elapsed_string($time) ?></h4>
						<div class="arrow-right">
							<a href="javascript:;" id="moreTrackingInfo" class="float-end">
								More Tracking Details <i class="fa fa-arrow-right me-2 fa-lg text-warning"></i>
							</a>
						</div>
						<div class="arrow-left d-none">
							<a href="javascript:;" id="trackingBack" class="float-start">
								<i class="fa fa-arrow-left me-2 fa-lg text-warning"></i> Back
							</a>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="package-progress">
								<div class="mb-5" align="center">
									<img src="<?php echo base_url('public/images/on-transit.svg') ?>" alt="track" width="" class="img-fluid" />
									<!-- <img src="<?php echo base_url('public/images/on-transit.svg') ?>" alt="track" class="img-fluid" /> -->
								</div>
								<div class="mb-5" align="center">
									<h4 class="fs-20 font-w800" style="color:#c6164f;">Your package is on transit</h4>
								</div>
								<?php echo '
								<ol class="progress-meter">
									<li class="progress-point done">05:20 mins</li><li class="progress-point done">05:10 mins</li><li class="progress-point done">Link</li><li class="progress-point todo">Connect</li>
								</ol>
								'; ?>
							</div>

							<div class="mt-4 tracking-highlits">
								<div class="card-body">
									<div class="profile-blog">
										<h3 class="text-primary d-inline">Today Highlights</h3>
										<img src="<?= site_url('public/images/deliver-img.jpeg') ?>" alt="" class="img-fluid mt-4 mb-4 w-100 rounded">
										<h4><a href="" class="text-black">Delivisha na sisi save time</a></h4>
										<p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
									</div>
								</div>
							</div>

							<!-- Load tracking templated -->
							<?php $this->load->view('public/tracking/tracking_details/index') ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End body content -->
