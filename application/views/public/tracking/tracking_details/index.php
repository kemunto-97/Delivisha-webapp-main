<div class="col-md-6 d-none progress-details">
	<h5 class="card-title mb-4">Tracking Details</h5>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td>Waybill Number</td>
					<td>${ data.waybill }</td>
				</tr>
				<tr>
					<td>Sender</td>
					<td>${ data.sender }</td>
				</tr>
				<tr>
					<td>Receiver</td>
					<td>${ data.receiver }</td>
				</tr>
				<tr>
					<td>Current Location</td>
					<td>${ data.current_location }</td>
				</tr>
				<tr>
					<td>Current Status</td>
					<td>${ data.current_status }</td>
				</tr>
				<tr>
					<td>Delivery Date</td>
					<td>${ data.delivery_date }</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="col-md-6 d-none progress-details">
	<h5 class="card-title mb-4">Tracking History</h5>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Date</th>
					<th>Location</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>${ data.history[0].date }</td>
					<td>${ data.history[0].location }</td>
					<td>${ data.history[0].status }</td>
				</tr>
				<tr>
					<td>${ data.history[1].date }</td>
					<td>${ data.history[1].location }</td>
					<td>${ data.history[1].status }</td>
				</tr>
				<tr>
					<td>${ data.history[2].date }</td>
					<td>${ data.history[2].location }</td>
					<td>${ data.history[2].status }</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="mt-4 tracking-highlits2 d-none progress-details">
		<div class="card-body">
			<div class="profile-blog">
				<h3 class="text-primary d-inline">Today Highlights</h3>
				<img src="<?= site_url('public/images/deliver-img.jpeg') ?>" alt="" class="img-fluid mt-4 mb-4 w-100 rounded">
				<h4><a href="" class="text-black">Delivisha na sisi save time</a></h4>
				<p class="mb-0">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
			</div>
		</div>
	</div>

</div>
