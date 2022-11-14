<body class="body  h-100 front-body" style="overflow:auto !important;">
	<?php $this->load->view('public/components/chatbot') ?>
	<?php $this->load->view('public/components/navbar') ?>

	<div class="content-body">
		<!-- row -->
		<div class="container p-4" style="background: #f1e4e4 !important;border-radius: 10px;">
			<div class="input-group search-area my-3">
				<span class="input-group-text"><a href="javascript:void(0)"><svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M27.414 24.586L22.337 19.509C23.386 17.928 24 16.035 24 14C24 8.486 19.514 4 14 4C8.486 4 4 8.486 4 14C4 19.514 8.486 24 14 24C16.035 24 17.928 23.386 19.509 22.337L24.586 27.414C25.366 28.195 26.634 28.195 27.414 27.414C28.195 26.633 28.195 25.367 27.414 24.586ZM7 14C7 10.14 10.14 7 14 7C17.86 7 21 10.14 21 14C21 17.86 17.86 21 14 21C10.14 21 7 17.86 7 14Z" fill="var(--secondary)"></path>
						</svg>
					</a></span>
				<input type="text" class="form-control" placeholder="Search for products and shops8765q	q1`1`1`21`...">
			</div>
			<div class="widget-heading d-flex justify-content-between align-items-center">
				<h3 class="m-0">Popular Categories</h3>
			</div>
			<!-- Category Component -->
			<?php $this->load->view('public/shops/components/category') ?>

			<div class="widget-heading d-flex justify-content-between align-items-center">
				<h3 class="m-0">All Shops On Delivisha</h3>
			</div>

			<!-- Shops Component -->
			<?php $this->load->view('public/shops/components/shops') ?>

			<div class="pagination-down">
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<h4 class="sm-mb-0 mb-3">Showing <span>1-6 </span>from <span>100 </span>data</h4>
					<ul>
						<li><a href="javascript:void(0);"><i class="fas fa-chevron-left"></i></a></li>
						<li><a href="javascript:void(0);" class="active">1</a></li>
						<li><a href="javascript:void(0);">2</a></li>
						<li><a href="javascript:void(0);">3</a></li>
						<li><a href="javascript:void(0);"><i class="fas fa-chevron-right"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
