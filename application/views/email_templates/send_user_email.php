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
				<h1 style="font-size: 24px; font-weight: 600; color: #000">OTP Verification code.</h1>
			</div>
			<div style="width: 100%; text-align: left; margin-top: 20px">
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Hi <?= $username ?>,</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">We receive your request for reseting your account, here is your one time password <strong><?= $otp ?></strong> to help you change your password.</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">This code will expire in 15 mins please use it before then. Ignore this email if you did not request for password change.</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Alternatively you can you can reset your account here <a href="<?= site_url('reset_password?otp=' . $otp) ?>">Reset Password</a> to avoid malicious users from accessing your account.</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Regards,</p>
				<p style="font-size: 16px; font-weight: 400; color: #5f5f5f">Delivisha Support team.</p>
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
