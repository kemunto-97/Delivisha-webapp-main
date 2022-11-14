<!-- This template contains email message with OTP to send to customer -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<div style="
				width: 100%;
				height: 100%;
				background-color: #f3e3e2;
				padding: 20px 0;
			">
		<div style="
					width: 100%;
					max-width: 600px;
					margin: 0 auto;
					background-color: #fff;
					padding: 20px;
				">
			<div style="width: 100%; text-align: center">
				<img src="https://tk9.co.ke/delivisha_logo.png" alt="Delivisha Logo" width="200;" />
			</div>
			<div style="width: 100%; text-align: center; margin-top: 20px">
				<h1 style="font-size: 24px; font-weight: 600; color: #000">Welcome to Delivisha</h1>
			</div>
			<div style="width: 100%; text-align: left; margin-top: 20px">
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Hi <?= $username ?>,</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f"> Welcome to Delivisha Logistics. We are thrilled to see you here! </p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">We are confident that Delivisha Logistics will help you get your consignment to your desired destination safely and fast.</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">We are currently shipping to a few parts of kenya and almost anywhere in Nairobi but with time we will expand to all parts of kenya. Feel free to leave us a suggesting in the link below of what you think about Delivisha.</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f"><a href="<?= site_url('contact') ?>">Leave us a message here...</a></p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">You can also find more of our guides and Deliveries by ckicking on the link below. <br> <a href="<?= site_url('about') ?>">Click here to find more about Delivisha.</a></p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Cheers,</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Delivisha team.</p>
			</div>

			<div style="width: 100%; text-align: center;">
				<h2 style="text-align: center; font-size: 20px; font-weight: 600; color: #fb6f61;">Tunakudelivishia Chap Chap!</h2>
			</div>
			<!-- footer details -->
			<div style="width: 100%; text-align: center; margin-top: 20px; display:flex; justify-content:space-between;">
				<p style="font-size: 12px; font-weight: 400; color: #000; margin-right: 10px;">P.O Box 1234</p>
				<p style="font-size: 12px; font-weight: 400; color: #000; margin-right: 10px;">Nairobi, Kenya</p>
				<p style="font-size: 12px; font-weight: 400; color: #000; margin-right: 10px;">Phone: +254 123 456 789</p>
				<p style="font-size: 12px; font-weight: 400; color: #000; margin-right: 10px;">Website: <a href="https://www.abc.com">www.delivisha.com</a></p>
				</p>
			</div>
		</div>
	</div>
</body>

</html>
