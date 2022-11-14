<!-- ========================================= -->
<!--            JAVASCRIPT CODE                 -->
<!-- ========================================= -->
<?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'customer_account' || $this->uri->segment(1) == 'order_tracking' || $this->uri->segment(1) == 'contact' || $this->uri->segment(1) == 'order' || $this->uri->segment(1) == 'shop' || $this->uri->segment(1) == 'products') : ?>
	<script>
		$(document).on('click', '.chatboat__icon', function() {
			$('.chatboat__icon').toggleClass('animate__animated animate__pulse');
			$('.chatboat__container').toggleClass('active');
		});

		// Submit chatbot form
		$(document).on('submit', '.chatBot__Conversation', function(e) {
			e.preventDefault();
			var form = $(this);
			var url = form.attr('action');
			var data = {
				'name': form.find('input[name="name"]').val(),
				'email': form.find('input[name="email"]').val(),
				'phone': form.find('input[name="phone"]').val(),
				'phone2': form.find('input[name="phone2"]').val(),
				'bussiness': form.find('input[name="bussiness"]').val(),
				'partner': form.find('input[name="partner"]').val(),
				'vendor_thought': form.find('input[name="vendor_thought"]').val(),
				'rider_thought': form.find('input[name="rider_thought"]').val(),
				'reaction': form.find('input[name="reaction"]').val(),
				'reaction2': form.find('input[name="reaction2"]').val(),
				'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>'
			};

			$.ajax({
				url: url,
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function(response) {
					if (response.status == 'success') {
						$('.chatBot__Conversation').trigger('reset');
						// Append the message
						$('.chatBot__Conversation').append(`<select data-conv-question="${ response.message }" id="chatbot__endConv"></select>`);
						// Refresh the token
						$('input[name="csrf_test_name"]').val(response.token);
					} else {
						$('.chatBot__Conversation').trigger('reset');
						// Append the message
						$('.chatBot__Conversation').append(`<select data-conv-question="${ response.message }" id="chatbot__endConv"></select>`);
						// Refresh the token
						$('input[name="csrf_test_name"]').val(response.token);
					}
				}
			});
		});

		// Making the navigation menu sticky
		window.onscroll = function() {
			myFunction()
		};

		var navbar = document.getElementById("navbar");
		var sticky = navbar.offsetTop;

		function myFunction() {
			if (window.pageYOffset >= sticky) {
				navbar.classList.add("sticky")
			} else {
				navbar.classList.remove("sticky");
			}
		}

		// OTP input form 1
		let digitValidate = function(ele) {
			console.log(ele.value);
			ele.value = ele.value.replace(/[^0-9]/g, '');
		}

		let tabChange = function(val) {
			let ele = document.querySelectorAll('.input_otp');
			if (ele[val - 1].value != '') {
				ele[val].focus()
			} else if (ele[val - 1].value == '') {
				ele[val - 2].focus()
			}
		}

		// OTP input form 2
		let digitValidate1 = function(ele) {
			console.log(ele.value);
			ele.value = ele.value.replace(/[^0-9]/g, '');
		}

		let tabChange1 = function(val) {
			let ele = document.querySelectorAll('.input_otp1');
			if (ele[val - 1].value != '') {
				ele[val].focus()
			} else if (ele[val - 1].value == '') {
				ele[val - 2].focus()
			}
		}

		// *********** Launch the customer login modal ***********
		$(document).on('click', '.logincustomerbtn', function(e) {
			e.preventDefault();
			// Show the modal
			$('#LoginModal').modal('show');
		});

		// *********** Register New Customer ***********
		$(document).ready(function() {
			// Create new customer
			$("#registerNewClient").on('submit', function(e) {
				e.preventDefault();
				// Get the form data
				var formData = $(this).serialize();
				// Get the form action
				var formAction = $(this).attr('action');
				// Validate form fields
				$(this).validate({
					rules: {
						first_name: {
							required: true,
							minlength: 3,
							maxlength: 20
						},
						last_name: {
							required: true,
							minlength: 3
						},
						emailAddress: {
							required: true,
							email: true
						},
						phoneNumber: {
							required: true,
							minlength: 10,
							maxlength: 10
						}
					},
					messages: {
						first_name: {
							required: "Please enter your first name",
							minlength: "Your first name must be at least 3 characters long",
						},
						last_name: {
							required: "Please enter your last name",
							minlength: "Your last name must be at least 3 characters long"
						},
						emailAddress: {
							required: "Please enter your email address",
							email: "Please enter a valid email address"
						},
						phoneNumber: {
							required: "Please enter your phone number",
							minlength: "Your phone number must be at least 10 characters long",
							maxlength: "Your phone number must be at most 10 characters long"
						}
					}
				});

				// Check if the form is valid
				if ($(this).valid()) {
					// Send the data to the server
					$.ajax({
						url: formAction,
						method: 'POST',
						data: formData,
						dataType: 'json',
						beforeSend: function() {
							// Disable the submit button
							$('#registerNewClient button[type="submit"]').attr('disabled', true);
							// Button with loading icon
							$('#registerNewClient button[type="submit"]').html(`
								<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
								<span class="visually-hidden">Loading...</span>
							`);
						},
						success: function(data) {
							console.log(data);
							// Check if the data is true
							if (data.status === 'success') {
								// Show success message
								$("#customerMessages").html(`
								<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-check-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">Congratulations!</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
								// Reset form fields
								$("#registerNewClient")[0].reset();
								// Button with success icon
								$('#registerNewClient button[type="submit"]').html('Regustration Successfull <i class="mdi mdi-check"></i>');
								// Enable the submit button
								$('#registerNewClient button[type="submit"]').attr('disabled', false);
								// Get the csrf token
								$('input[name="csrf_test_name"]').val(data.token);
								// Hide the modal after 3 seconds
								setTimeout(function() {
									$('#registrationModal').modal('hide');
								}, 3000);
							} else if (data.status === 'error') {
								// Show error message
								$("#customerMessages").html(`
								<div class="alert alert-danger left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-close-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2 text-white">Error Encountered!</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);

								// Enable the submit button
								$('#registerNewClient button[type="submit"]').attr('disabled', false);
								// Button with error icon
								$('#registerNewClient button[type="submit"]').html('Error Registering <i class="mdi mdi-close"></i>');
								// Get the csrf token
								$('input[name="csrf_test_name"]').val(data.token);
							}
						}
					});
				}
			});

			// Register New Client
			$('#registerNewCustomer').on('submit', function(e) {
				e.preventDefault();
				// Get the form data
				var formData = $(this).serialize();
				// Get the form action
				var formAction = $(this).attr('action');
				// Validate form fields
				$(this).validate({
					rules: {
						first_name1: {
							required: true,
							minlength: 3,
							maxlength: 20
						},
						last_name1: {
							required: true,
							minlength: 3
						},
						emailAddress1: {
							required: true,
							email: true
						},
						phoneNumber1: {
							required: true,
							minlength: 10,
							maxlength: 10
						}
					},
					messages: {
						first_name1: {
							required: "Please enter your first name",
							minlength: "Your first name must be at least 3 characters long",
						},
						last_name1: {
							required: "Please enter your last name",
							minlength: "Your last name must be at least 3 characters long"
						},
						emailAddress1: {
							required: "Please enter your email address",
							email: "Please enter a valid email address"
						},
						phoneNumber1: {
							required: "Please enter your phone number",
							minlength: "Your phone number must be at least 10 characters long",
							maxlength: "Your phone number must be at most 10 characters long"
						}
					}
				});

				// Check if the form is valid
				if ($(this).valid()) {
					// Send the data to the server
					$.ajax({
						url: formAction,
						method: 'POST',
						data: formData,
						dataType: 'json',
						beforeSend: function() {
							// Disable the submit button
							$('#registerNewCustomer button[type="submit"]').attr('disabled', true);
							// Button with loading icon
							$('#registerNewCustomer button[type="submit"]').html(`
								<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
								<span class="visually-hidden">Loading...</span>
							`);
						},
						success: function(data) {
							console.log(data);
							// Check if the data is true
							if (data.status === 'success') {
								// Show success message
								$("#loginResponseMessage").html(`
								<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-check-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">${ data.title }</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
								// Reset form fields
								$("#registerNewCustomer")[0].reset();
								// Button with success icon
								$('#registerNewCustomer button[type="submit"]').html('Regustration Successfull <i class="mdi mdi-check"></i>');
								// Enable the submit button
								$('#registerNewCustomer button[type="submit"]').attr('disabled', false);
								$('input[name="csrf_test_name"]').val(data.token);
								// Hide the modal after 3 seconds
								setTimeout(function() {
									$('#LoginModal').modal('hide');
								}, 3000);
							} else if (data.status === 'error') {
								// Show error message
								$("#loginResponseMessage").html(`
								<div class="alert alert-outline-danger left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-close-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">${ data.title }</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);

								// Enable the submit button
								$('#registerNewCustomer button[type="submit"]').attr('disabled', false);
								// Button with error icon
								$('#registerNewCustomer button[type="submit"]').html('Error Registering <i class="mdi mdi-close"></i>');
								// Get the csrf token
								$('input[name="csrf_test_name"]').val(data.token);
							}
						}
					});
				}
			});
		});

		// Cancel login modal function
		$(document).on('click', '.cancelLoginModal', function() {
			$("#LoginModal").modal('hide');
		})

		// *********** Show registration form ***********
		$(document).on('click', '#showRegistrationForm', function(e) {
			e.preventDefault();
			$('#userLoginForm2').addClass('d-none');
			$('#registerNewCustomer').removeClass('d-none');
		});

		// *********** Show login form ***********
		$(document).on('click', '#showLoginForm', function(e) {
			e.preventDefault();
			$('#registerNewCustomer').addClass('d-none');
			$('#userLoginForm2').removeClass('d-none');
		});
	</script>
<?php endif; ?>
<!-- ================ BACKEND LOGIN SCRIPTS ===================== -->
<?php if ($this->uri->segment(1) == 'login') : ?>
	<script>
		$(document).on("click", ".toggle-password", function() {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});

		// OTP input form 3
		let digitValidate2 = function(ele) {
			console.log(ele.value);
			ele.value = ele.value.replace(/[^0-9]/g, '');
		}

		let tabChange2 = function(val) {
			let ele = document.querySelectorAll('.input_otp_2');
			if (ele[val - 1].value != '') {
				ele[val].focus()
			} else if (ele[val - 1].value == '') {
				ele[val - 2].focus()
			}
		}

		// Exit the send otp form
		$(document).on('click', '#sendOtpCloseBtn', function() {
			$('.sendOtpArea').addClass('d-none');
			$('.loginArea').removeClass('d-none');
			$('#userLoginForm1 button[type="submit"]').attr('disabled', false);
			$('#userLoginForm1 button[type="submit"]').html('Unlock Account <i class="mdi mdi-alert-circle-outline"></i>');
		});

		// Login user function
		$(document).on('submit', '#userLoginForm1', function(e) {
			e.preventDefault();
			// validate form fields
			$(this).validate({
				rules: {
					username: {
						required: true,
					},
					password: {
						required: true,
					}
				},
				messages: {
					username: {
						required: 'Please enter your email address or phone number',
					},
					password: {
						required: 'Please enter your password',
					}
				}
			});
			// if form is valid
			if ($(this).valid()) {
				// get form data
				const formData = new FormData($(this)[0]);
				const errorField = $('#usersLoginMessages');
				// send ajax request
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						// Find button and insert loading icon
						$('#userLoginForm1 button[type="submit"]').html(`
							<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
							<span class="visually-hidden">Loading...</span>
						`);
						// Disable button
						$('#userLoginForm1 button[type="submit"]').attr('disabled', true);
					},
					success: function(response) {
						// Check if login attempt is 2 and load the otp form
						if (response.status == 'success') {
							// Show success message
							errorField.html(`
								<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-check-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">Sent Successfully!</h5>
											<p class="mb-0">${ response.message }</p>
										</div>
									</div>
								</div>`);

							// Remove the loading icon
							$('#userLoginForm1 button[type="submit"]').html('Login Successful');

							$('#userLoginForm1 button[type="submit"]').attr('disabled', false);
							// Change buttong color to green
							$('#userLoginForm1 button[type="submit"]').css({
								'background-color': '#28a745',
								'border-color': '#28a745',
								'color': '#fff',
								'cursor': 'not-allowed',
								'border-radius': '0.25rem',
								'text-transform': 'uppercase',
							});
							$('#userLoginForm1 button[type="submit"]').removeClass('blinking-button');
							// Set the csrf token
							$('input[name="csrf_test_name"]').val(response.token);
							// redirect to dashboard
							setTimeout(function() {
								window.location.href = response.url;
							}, 3500);
						} else if (response.status == 'error' && response.attempts == 3) {
							$(".loginArea").addClass("d-none");
							$(".sendOtpArea").removeClass("d-none");
							$('input[name="csrf_test_name"]').val(response.token);
						} else if (response.status == 'error') {
							// Show error message
							errorField.html(`
									<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
										</button>
										<div class="media">
											<div class="alert-left-icon-big">
												<span><i class="mdi mdi-email-alert"></i></span>
											</div>
											<div class="media-body">
												<h6 class="mt-1 mb-2">${ response.title }</h6>
												<p class="mb-0">${ response.message }</p>
											</div>
										</div>
									</div>`);
							// Disable the submit button
							$('#userLoginForm1 button[type="submit"]').attr('disabled', false);
							$('input[name="csrf_test_name"]').val(response.token);
							// Button with warning icon
							$('#userLoginForm1 button[type="submit"]').html('Error Loging in <i class="mdi mdi-alert-circle-outline"></i>');
						}

					},
					error: function(error) {
						$('.blinking-button').html('Unlock');
						// show error message
						errorField.html(`
							<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-email-alert"></i></span>
									</div>
									<div class="media-body">
										<h6 class="mt-1 mb-2">Error!</h6>
										<p class="mb-0">Something went wrong. Please try again later.</p>
									</div>
								</div>
							</div>`);
						// Disable the submit button
						$('#userLoginForm1 button[type="submit"]').attr('disabled', false);
						$('#userLoginForm1 button[type="submit"]').html('Error Loging in <i class="mdi mdi-alert-circle-outline"></i>');
						$('input[name="csrf_test_name"]').val(response.token);
					}
				});
			}
		})

		// Cancell verification OTP modal
		$(document).on('click', '.cancelModalVOTP', function(e) {
			e.preventDefault();
			$("#verifyLoginOTPModal").modal('hide');
		})

		// This function is for users to send otp
		$(document).on('submit', '#userLoginFormSendOtp', function(e) {
			e.preventDefault();
			const errorField = $('#sendOtpMessages');
			// Validate the form input
			$(this).validate({
				rules: {
					email: {
						required: true,
					},
				},
				messages: {
					email: {
						required: "Please enter your email address",
					},
				}
			});
			// Check if the form is valid
			if ($(this).valid()) {
				// Send ajax request
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						// Disable the submit button
						$('#userLoginFormSendOtp button[type="submit"]').attr('disabled', true);
						// Button with loading icon
						$('#userLoginFormSendOtp button[type="submit"]').html(`
							<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
							<span class="visually-hidden">Loading...</span>
						`);
					},
					success: function(response) {
						// Check if the response status is success
						if (response.status == 'success') {
							// Show success message
							errorField.html(`
								<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-check-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">${ response.title }</h5>
											<p class="mb-0">${ response.message }</p>
										</div>
									</div>
								</div>`);
							// Enable the submit button
							$('#userLoginFormSendOtp button[type="submit"]').attr('disabled', false);
							// Button with success icon
							$('#userLoginFormSendOtp button[type="submit"]').html('OTP Sent successfully <i class="mdi mdi-check"></i>');

							setTimeout(function() {
								// Show the verify otp modal
								$("#verifyLoginOTPModal").modal('show');
							}, 3500);
							// Change the form token
							$('input[name="csrf_test_name"]').val(response.token);
						} else {
							// Show error message
							errorField.html(`
							<div class="alert alert-outline-danger left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-close-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ response.title }</h5>
										<p class="mb-0">${ response.message }</p>
									</div>
								</div>
							</div>`);
							// Enable the submit button
							$('#userLoginFormSendOtp button[type="submit"]').attr('disabled', false);
							// Button with error icon
							$('#userLoginFormSendOtp button[type="submit"]').html('Send OTP <i class="mdi mdi-close"></i>');
							$('input[name="csrf_test_name"]').val(response.token);
						}
					},
				});
			};
		})

		// This function verifies the otp is correct from the database
		$(document).on('submit', '#userLoginFormVerifyOtp', function(e) {
			e.preventDefault();
			const errorField = $('#verifyOtpMessages');
			const formData = $(this).serialize();
			const url = $(this).attr('action');
			// Send ajax request
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
					// Disable the submit button
					$('#userLoginFormVerifyOtp button[type="submit"]').attr('disabled', true);
					// Button with loading icon
					$('#userLoginFormVerifyOtp button[type="submit"]').html(`
						<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
						<span class="visually-hidden">Loading...</span>
					`);
				},
				success: function(response) {
					// Check if the response status is success
					if (response.status == 'success') {
						// Show success message
						errorField.html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ response.title }</h5>
										<p class="mb-0">${ response.message }</p>
									</div>
								</div>
							</div>`);
						// Enable the submit button
						$('#userLoginFormVerifyOtp button[type="submit"]').attr('disabled', false);
						// Button with success icon
						$('#userLoginFormVerifyOtp button[type="submit"]').html('OTP Verified successfully <i class="mdi mdi-check"></i>');

						setTimeout(function() {
							// Redirect to the rest password page
							window.location.href = response.url;
						}, 3500);
						// Change the form token
						$('input[name="csrf_test_name"]').val(response.token);
					} else if (response.status == 'error') {
						// Show error message
						errorField.html(`
							<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-email-alert"></i></span>
									</div>
									<div class="media-body">
										<h6 class="mt-1 mb-2">${ response.title }</h6>
										<p class="mb-0">${ response.message }</p>
									</div>
								</div>
							</div>`);
						// Enable the submit button
						$('#userLoginFormVerifyOtp button[type="submit"]').attr('disabled', false);
						// Button with error icon
						$('#userLoginFormVerifyOtp button[type="submit"]').html('Error! Verify OTP. <i class="mdi mdi-close"></i>');
						$('input[name="csrf_test_name"]').val(response.token);
					}
				}
			});
		});
	</script>
<?php endif; ?>

<!-- ================ SCRIPTS FOR PASSWORD RESET PAGE ================== -->
<?php if ($this->uri->segment(1) == 'reset-password') : ?>
	<script>
		$(document).on('submit', '#userResetPasswordForm', function(e) {
			e.preventDefault();
			const errorField = $('#resetPasswordMessages');
			// validate the for inputs
			$(this).validate({
				rules: {
					password: {
						required: true,
						minlength: 8,
						maxlength: 20,
					},
					confirm_password: {
						required: true,
					},
				},
				messages: {
					password: {
						required: "Please enter a new password",
						minlength: "Password must be at least 8 characters long",
						maxlength: "Password must be at most 20 characters long",
					},
					confirm_password: {
						required: "please enter a confirm password",
					}
				}
			});
			// Check if the form is valid
			if ($(this).valid()) {
				// Send the ajax request
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						// Disable the submit button
						$('#userResetPasswordForm button[type="submit"]').attr('disabled', true);
						// Button with loading icon
						$('#userResetPasswordForm button[type="submit"]').html(`
							<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
							<span class="visually-hidden">Loading...</span>
						`);
					},
					success: function(response) {
						// Check if the response status is success
						if (response.status == 'success') {
							// Show success message
							errorField.html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ response.title }</h5>
										<p class="mb-0">${ response.message }</p>
									</div>
								</div>
							</div>`);
							// Button with success icon
							$('#userResetPasswordForm button[type="submit"]').html('Reset Password <i class="mdi mdi-check"></i>');
							// Enable the submit button
							$('#userResetPasswordForm button[type="submit"]').attr('disabled', false);
							// Get the form token
							$('input[name="csrf_test_name"]').val(response.token);
							// Redirect to the login page
							setTimeout(function() {
								window.location.href = response.url;
							}, 3500);
						} else {
							// Show error message
							errorField.html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-email-alert"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-1 mb-2">${ response.title }</h6>
                                            <p class="mb-0">${ response.message }</p>
                                        </div>
                                    </div>
                                </div>`);
							// Enable the submit button
							$('#userResetPasswordForm button[type="submit"]').attr('disabled', false);
							// Button with error icon
							$('#userResetPasswordForm button[type="submit"]').html('Reset Password <i class="mdi mdi-close"></i>');
							// Get the form token
							$('input[name="csrf_test_name"]').val(response.token);
						}
					}
				})
			}
		});
	</script>
<?php endif; ?>

<!-- =============== LOAD SCRIPTS FOR CONTACTS PAGE ==================== -->
<?php if ($this->uri->segment(1) == 'contact') : ?>
	<script>
		// Function for sending the message
		$(document).on('submit', '#contact_form', function(e) {
			e.preventDefault();
			const url = $(this).attr('action');
			const data = $(this).serialize();
			// Validate form inputs
			$(this).validate({
				rules: {
					customer_name: {
						required: true,
						minlength: 3
					},
					email: {
						required: true,
						email: true
					},
					phone: {
						required: true,
						minlength: 10,
						maxlength: 10
					},
					subject: {
						required: true,
						minlength: 3
					},
					message: {
						required: true,
						minlength: 10
					}
				},
				messages: {
					customer_name: {
						required: 'Please enter your name',
						minlength: 'Your name must be at least 3 characters long'
					},
					email: {
						required: 'Please enter your email address',
						email: 'Please enter a valid email address'
					},
					phone: {
						required: 'Please enter your phone number',
						minlength: 'Phone number must be 10 digits long',
						maxlength: 'Phone number must be 10 digits long'
					},
					subject: {
						required: 'Please enter a subject',
						minlength: 'Subject must be at least 3 characters long'
					},
					message: {
						required: 'Please enter your message',
						minlength: 'Message must be at least 10 characters long'
					}
				},
			});

			// check if the form is valid
			if ($(this).valid()) {
				$.ajax({
					url: url,
					type: 'POST',
					data: data,
					dataType: 'json',
					beforeSend: function() {
						// Find button and add spinner
						$(this).find('button[type="submit"]').html('<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Loading...');
						// Disable the button
						$(this).find('button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						if (data.status === 'success') { // Everything is ok
							// Show success message
							$(".contactResponseMessages").html(`
									<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
										</button>
										<div class="media">
											<div class="alert-left-icon-big">
												<span><i class="mdi mdi-check-circle-outline"></i></span>
											</div>
											<div class="media-body">
												<h5 class="mt-1 mb-2">${ data.title }</h5>
												<p class="mb-0">${ data.message }</p>
											</div>
										</div>
									</div>`);
							// Clear the form
							$('#contact_form')[0].reset();
							// Enable the button
							$('#contact_form button[type="submit"]').attr('disabled', false);
							// Remove spinner
							$('#contact_form button[type="submit"]').html('Send Message');
							$('#contact_form button[type="submit"]').css({
								'background-color': '#28a745',
								'border-color': '#28a745',
								'color': '#fff',
								'cursor': 'not-allowed',
								'border-radius': '0.25rem',
								'text-transform': 'uppercase',
							});
							$('#contact_form button[type="submit"]').removeClass('blinking-button');
							// Reset csrf token
							$('input[name="csrf_test_name"]').val(data.token);
						} else if (data.status === 'error') { // An error occurred
							// Show error message
							$(".contactResponseMessages").html(`
								<div class="alert alert-outline-danger left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-close-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">${ data.title }</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
							// Enable the button
							$('#contact_form button[type="submit"]').attr('disabled', false);
							// Remove spinner
							$('#contact_form button[type="submit"]').html('Send Message');
							// Reset csrf token
							$('input[name="csrf_test_name"]').val(data.token);
						}
					},
					error: function(err) {
						// Show error message
						$(".contactResponseMessages").html(`
								<div class="alert alert-outline-danger left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-close-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">Error!</h5>
											<p class="mb-0">${ err.responseJSON.message }</p>
										</div>
									</div>
								</div>`);
						$('input[name="csrf_test_name"]').val(data.token);
					},
				})
			}
		})

		// Initialize and add the map
		function initMap() {
			// The location of Uluru
			const uluru = {
				lat: -25.344,
				lng: 131.036
			};
			// The map, centered at Uluru
			const map = new google.maps.Map(document.getElementById("map"), {
				zoom: 4,
				center: uluru,
			});
			// The marker, positioned at Uluru
			const marker = new google.maps.Marker({
				position: uluru,
				map: map,
			});
		}
	</script>
<?php endif; ?>

<!-- =============== LOAD SCRIPTS FOR THE ORDER PAGE ================== -->
<?php if ($this->uri->segment(1) === 'order') : ?>
	<script>
		// Get total price on package-status change
		$(document).on('change', '#package_status', function(e) {
			// Get the input values
			let package_weight = $('#package_weight').val();
			let package_type = $('#package_types').val();
			let package_status = $('#package_status').val();
			let package_quantity = $('#package_quantity').val();
			let csrf_token = $('input[name="csrf_test_name"]').val();
			// Prepare the data
			let data = {
				package_weight: package_weight,
				package_type: package_type,
				package_status: package_status,
				package_quantity: package_quantity,
				csrf_test_name: csrf_token
			}
			// Send the data to the server
			$.post('<?= base_url('crud_controller/get_total_shipping_price') ?>', data, function(response) {
				const data = JSON.parse(response);
				// Check if the response is successful
				if (data.status === 'success') {
					// Display the total price
					$('#total_delivery_rates').val(data.data.shipping_fee);
					// Show the total price to the user
					$("#placeOrderBtn").html('Place Order - KES ' + numberWithCommas(data.data.shipping_fee));
					// Reset csrf token
					$('input[name="csrf_test_name"]').val(data.token);
				}
			})
		});

		// SUBMIT ORDER FORM
		$(document).on('submit', '#placeOrderForm', function(e) {
			e.preventDefault();
			// Validate form
			$(this).validate({
				rules: {
					'sender_county': {
						required: true,
					},
					'sender_region': {
						required: true,
					},
					'sender_street': {
						required: true,
					},
					'receiver_name': {
						required: true,
						minlength: 3,
					},
					'receiver_phone': {
						required: true,
						minlength: 10,
						maxlength: 10,
						digits: true,
					},
					'package_weight': {
						required: true,
						minlength: 1,
						digits: true,
					},
					'package_description': {
						required: true,
						minlength: 3,
					},
					'package_types': {
						required: true,
					},
					'package_quantity': {
						required: true,
						minlength: 1,
						digits: true,
					},
					'package_image': {
						required: true,
						minlength: 3,
					},
					'package_status': {
						required: true,
					},
				},
				messages: {
					'sender_county': {
						required: 'Please enter your county',
					},
					'sender_region': {
						required: 'Please enter your region',
					},
					'sender_street': {
						required: 'Please enter your street',
					},
					'receiver_name': {
						required: 'Please enter receiver name',
						minlength: 'Receiver name must be at least 3 characters long',
					},
					'receiver_phone': {
						required: 'Please enter receiver phone',
						minlength: 'Receiver phone must be at least 10 characters long',
						maxlength: 'Receiver phone must be at most 10 characters long',
						digits: 'Receiver phone must be digits only',
					},
					'package_weight': {
						required: 'Please enter package weight',
						minlength: 'Package weight must be at least 1 characters long',
						digits: 'Package weight must be digits only',
					},
					'package_description': {
						required: 'Please enter package description',
						minlength: 'Package description must be at least 3 characters long',
					},
					'package_types': {
						required: 'Please enter package type',
					},
					'package_quantity': {
						required: 'Please enter package quantity',
						minlength: 'Package quantity must be at least 1 characters long',
						digits: 'Package quantity must be digits only',
					},
					'package_image': {
						required: 'Please enter package image',
						minlength: 'Package image must be at least 3 characters long',
					},
					'package_status': {
						required: 'Please enter package status',
					},
				},
			})

			// Check if form is valid
			if ($(this).valid()) {
				// Get form data
				const form_data = new FormData(this);
				// Send form data to the server
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					dataType: 'json',
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						// Change the button text
						$("#placeOrderForm button[type=submit]").html(`<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>`);
						// Disable the submit button
						$("#placeOrderForm button[type=submit]").attr('disabled', true);
					},
					success: function(data) {
						// Check if order was placed successfully
						if (data.status === 'success') {
							// Show success message
							$(".placeOrderAlert").html(`
								<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
									</button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-check-circle-outline"></i></span>
										</div>
										<div class="media-body">
											<h5 class="mt-1 mb-2">${ data.title }</h5>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
							// Reset the form
							$("#placeOrderForm")[0].reset();
							// Enable the submit button
							$("#placeOrderForm button[type=submit]").attr('disabled', false);
							// Change the button text
							$("#placeOrderForm button[type=submit]").html('Place Order');
							$(".otherInputs").addClass('d-none');
							$("#showOtherInputs").removeClass('d-none');
							// Set the csrf token
							$('input[name="csrf_test_name"]').val(data.token);
						} else if (data.status === 'error') {
							// Show error message
							$(".placeOrderAlert").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi btn-close"></i></span> </button>
									<div class="media">
										<div class="alert-left icon-big">
											<span><i class="mdi mdi-email-alert"></i></span>
										</div>
										<div class="media-body text-center">
											<h6 class="mt-1 mb-2">${ data.title }</h6>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
							// Enable the submit button
							$("#placeOrderForm button[type=submit]").attr('disabled', false);
							// Change the button text
							$("#placeOrderForm button[type=submit]").html('Place Order');
							// Set the csrf token
							$('input[name="csrf_test_name"]').val(data.token);
						}
					},
				});
			}
		})

		// PUSHER NOTIFICATIONS
		// Enable pusher logging - don't include this in production
		Pusher.logToConsole = true;

		var pusher = new Pusher('2d87a011e38a284e30a6', {
			cluster: 'mt1'
		});

		var channel = pusher.subscribe('delivisha-noti');
		channel.bind('my-event', function(data) {
			alert(JSON.stringify(data));
		});

		// POPULATE LOCATION IN INPUT FIELD
		$(document).ready(function() {
			// Show hiden inputs on the orders page
			$("#showOtherInputs").click(function() {
				// Remove d-none class from the inputs
				$(".otherInputs").removeClass("d-none");
				// Hide the button
				$(this).addClass("d-none");
			});

			// Get counties from the database
			$.ajax({
				url: '<?= base_url() ?>order/get_counties',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					// console.log(data);
					$.each(data, function(key, value) {
						$('#sender_county').append('<option value="' + value.county_code + '">' + value.county_name + '</option>');
					});
				}
			});

			// populate regions data on county change
			$('#sender_county').on('change', function() {
				// Get the county id
				$('#sender_region').empty();
				var county_id = $(this).val();

				// Get the regions
				$.ajax({
					url: '<?= base_url() ?>order/get_regions/' + county_id,
					method: 'GET',
					dataType: 'json',
					success: function(data) {
						// console.log(data);

						$('.sender_region').append('<option value="">Select Region</option>');
						$.each(data, function(key, value) {
							$('#sender_region').append('<option value="' + value.id + '">' + value.region_name + '</option>');
						});
					}
				});
			});

			// Populate streets data on region change
			$('#sender_region').on('change', function() {
				// Get the region id
				$('#sender_street').empty();
				var region_id = $(this).val();

				// Get the streets
				$.ajax({
					url: '<?= base_url() ?>order/get_streets/' + region_id,
					method: 'GET',
					dataType: 'json',
					success: function(data) {
						// console.log(data);

						$('.sender_street').append('<option value="">Select Street</option>');
						$.each(data, function(key, value) {
							$('#sender_street').append('<option value="' + value.id + '">' + value.street_name + '</option>');
						});
					}
				});
			});

			// Populate streets data on region change
			$('#sender_street').on('change', function() {
				// Get the street id
				var street_id = $(this).val();
				console.log(street_id);
			});

		});

		// This function is for getting shipping ammounts
		function getShippingCalculationNumbers() {
			// call ajax to get the shipping prices
			const url = '<?= site_url('crud_controller/getShippingRecords') ?>';
			$.get(url, function(response) {
				const dataResponse = JSON.parse(response);
				// check if data is not empty
				if (dataResponse.status == 200) {
					const deliveryRates = $('#delivery_rates');
					// append the data to the table
					deliveryRates.append(`
							<input type="hidden" name="std_doc_price" value="${ dataResponse.data.std_doc_price }" />
							<input type="hidden" name="std_parcel_price" value="${ dataResponse.data.std_parcel_price }" />
							<input type="hidden" name="std_box_price" value="${ dataResponse.data.std_box_price }" />
							<input type="hidden" name="std_crate_price" value="${ dataResponse.data.std_crate_price }" />
							<input type="hidden" name="std_pallet_price" value="${ dataResponse.data.std_pallet_price }" />
							<input type="hidden" name="doc_urg_price" value="${ dataResponse.data.doc_urg_price }" />
							<input type="hidden" name="parcel_urg_price" value="${ dataResponse.data.parcel_urg_price}" />
							<input type="hidden" name="box_urg_price" value="${ dataResponse.data.box_urg_price }" />
							<input type="hidden" name="crate_urg_price" value="${ dataResponse.data.crate_urg_price }" />
							<input type="hidden" name="pallet_urg_price" value="${ dataResponse.data.pallet_urg_price }" />
						`);
				}
			})
		}
	</script>
<?php endif; ?>

<!-- ============== LOAD SCRIPTS FOR THE TRACKING PAGE ============== -->
<?php if ($this->uri->segment(1) == 'tracking') : ?>
	<script>
		// *********** Show Tracking modal **************
		$(document).on('click', '#trackingPackage', function(e) {
			e.preventDefault();
			$('#trackingModal').modal('show');
		})

		// ********** Track Consignment **********
		$(document).on('submit', '#trackYourPackage', function(e) {
			e.preventDefault();
			const form = $(this);
			const url = form.attr('action');
			const method = form.attr('method');
			const data = form.serialize();

			// Check if the form is valid
			const waybillNumber = $('input[name=waybill]').val();
			// Waybill should not be empty
			if (waybillNumber == "") {
				alert('You need to provide your waybill number');
				// Waybill should be a number
			} else if (isNaN(waybillNumber)) {
				alert('Waybill number should be a number and not a character');
				// Waybill should be 6 digits long
			} else if (waybillNumber.length != 6) {
				alert('Incorrect waybill number please check and try again');
			} else {
				// alert('Waybill number is correct');
				// Send the data to the server
				$.ajax({
					url: url,
					method: method,
					data: data,
					dataType: 'json',
					beforeSend: function() {
						// Find button and add loading icon
						$('#trackYourPackage button[type="submit"]').html(`<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>`);
						// Disable button
						$('#trackYourPackage button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						if (data.status === 'success') {
							// Show success message
							$("#validationSuccessMsg").html(`
												<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
													<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi btn-close"></i></span> </button>
													<div class="media">
														<div class="alert-left icon-big">
															<span><i class="mdi mdi-email-check"></i></span>
														</div>
														<div class="media-body">
															<h6 class="mt-1 mb-2">${ data.title }</h6>
															<p class="mb-0">${ data.message }</p>
														</div>
													</div>
												</div>`);
							// Disable the submit button
							// $('#registerNewClient').find('button[type="submit"]').prop('disabled', true);
							$('input[name="csrf_test_name"]').val(data.token['hash']);
						} else if (data.status === 'error') {
							// Show error message
							$("#validationErrorMsg").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi btn-close"></i></span> </button>
									<div class="media">
										<div class="alert-left icon-big">
											<span><i class="mdi mdi-email-alert"></i></span>
										</div>
										<div class="media-body text-center">
											<h6 class="mt-1 mb-2">${ data.title }</h6>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
							// Disable the submit button
							// $('#registerNewClient').find('button[type="submit"]').prop('disabled', true);
							$('input[name="csrf_test_name"]').val(data.token['hash']);

						}
					},
				});

			}
		})

		$(document).on('click', '#moreTrackingInfo', function(e) {
			e.preventDefault();
			$('.progress-details').removeClass('d-none');
			$('.package-progress').addClass('d-none');
			$('.arrow-left').removeClass('d-none');
			$('.arrow-right').addClass('d-none');
			$('.tracking-title').addClass('d-none');
			$('.tracking-highlits').addClass('d-none');
		})

		$(document).on('click', '#trackingBack', function(e) {
			e.preventDefault();
			$('.progress-details').addClass('d-none');
			$('.package-progress').removeClass('d-none');
			$('.arrow-left').addClass('d-none');
			$('.arrow-right').removeClass('d-none');
			$('.tracking-title').removeClass('d-none');
			$('.tracking-highlits').removeClass('d-none');
		})
	</script>
<?php endif; ?>

<!-- ================= MAIN SCRIPTS FUNCTIONS =============== -->
<?php if ($this->uri->segment(1) == '') : ?>
	<script>
		// This function is for culculating the total price of delivery from the customer inputs

		$(document).on('submit', '#trackYourPackage', function(e) {
			e.preventDefault();
			const waybill = $('#waybill_number').val();
			// Check if input is empty
			if (waybill === '') {
				// Show error message
				alert('Please enter a waybill number to track your package');
			} else {
				// Send ajax request
				const url = $(this).attr('action');
				const method = $(this).attr('method');
				const data = $(this).serialize();
				$.ajax({
					url: url,
					method: method,
					data: data,
					dataType: 'json',
					success: function(data) {
						if (data.status === 'success') {
							// Show success message
							$("#waybillMessages").html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ data.title }</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);
							// Show model
							$('#waybillErrorModel').modal('show');
							// Get the token
							$('input[name="csrf_test_name"]').val(data.token);
							// Redirect to the package tracking page
							setTimeout(() => {
								window.location.href = data.url;
							}, 3000);
						} else {
							// Show error message
							$("#waybillMessages").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-email-alert"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-1 mb-2">${ data.title }</h6>
                                            <p class="mb-0">${ data.message }</p>
                                        </div>
                                    </div>
                                </div>`);
							// Show model
							$('#waybillErrorModel').modal('show');
							// Get the token
							$('input[name="csrf_test_name"]').val(data.token);
						}
					}
				});
			}
		})

		$(document).on('click', '.cancelWaybillModal', function(e) {
			e.preventDefault();
			$('#waybillErrorModel').modal('hide');
		})

		$(document).on('click', '#loadCalculationModal', function(e) {
			e.preventDefault();
			$('#calculationModal').modal('show');
			getShippingCalculationNumbers();
		})

		$(document).on('click', '#calculateAgainModal', function(e) {
			e.preventDefault();
			$('.calculation__form').removeClass('d-none');
			$('#calculation_results').html('');
			$('#calculate__btn').removeClass('d-none');
		})

		$(document).on('click', '.cancelModal', function() {
			$("#calculationModal").modal('hide');
		})

		$(document).on('click', '.cancelPhoneVerification', function() {
			$("#requestDeliveryModal").modal('hide');
		})

		$(document).on('click', '.cancelRegistrationModal', function() {
			$("#registrationModal").modal('hide');
		})

		// *********** 2. login Customer ***********
		$(document).on('submit', '#userLoginForm2', function(e) {
			e.preventDefault();
			// Validate form phone number inputs
			$(this).validate({
				rules: {
					phone_number: {
						required: true,
						minlength: 10,
						maxlength: 10
					}
				},
				messages: {
					phone_number: {
						required: "Please enter your phone number",
						minlength: "Your phone number must be at least 10 characters long",
						maxlength: "Your phone number must be at most 10 characters long"
					}
				}
			});
			// Check if the form is valid
			if ($(this).valid()) {
				// Get the form data
				var formData = $(this).serialize();
				// Send the data to the server
				$.ajax({
					url: $(this).attr('action'),
					method: 'POST',
					data: formData,
					dataType: 'json',
					beforeSend: function() {
						// Find button and insert loading icon
						$('#userLoginForm2 button[type="submit"]').html(`
						<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
						<span class="visually-hidden">Loading...</span>
					`);
						// Disable button
						$('#userLoginForm2 button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						console.log(data);
						if (data.status === 'success') {
							// Show success message
							$("#loginResponseMessage").html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">Sent Successfully!</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);

							// Remove the loading icon
							$('#userLoginForm2 button[type="submit"]').html('Login Successful');

							$('#userLoginForm2 button[type="submit"]').attr('disabled', false);
							// Change buttong color to green
							$('#userLoginForm2 button[type="submit"]').css({
								'background-color': '#28a745',
								'border-color': '#28a745',
								'color': '#fff',
								'cursor': 'not-allowed',
								'border-radius': '0.25rem',
								'text-transform': 'uppercase',
							});
							$('#userLoginForm2 button[type="submit"]').removeClass('blinking-button');
							$('.displayRegistrationLink').addClass('d-none');
							// Show the OTP form
							$('#verifyOTP').removeClass('d-none');
							// Hide the login form
							$('#userLoginForm2').addClass('d-none');
							$('input[name="csrf_test_name"]').val(data.token);
							// Redirect to the dashboard
							// setTimeout(function() {
							// 	window.location.href = data.redirect_url;
							// }, 2000);
						} else if (data.status === 'error') {
							// Show error message
							$("#loginResponseMessage").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
					                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
					                </button>
					                <div class="media">
					                    <div class="alert-left-icon-big">
					                        <span><i class="mdi mdi-email-alert"></i></span>
					                    </div>
					                    <div class="media-body">
					                        <h6 class="mt-1 mb-2">${ data.title }</h6>
					                        <p class="mb-0">${ data.message }</p>
					                    </div>
					                </div>
					            </div>`);
							// Disable the submit button
							$('#userLoginForm2 button[type="submit"]').attr('disabled', false);
							$('input[name="csrf_test_name"]').val(data.token);
							// Button with warning icon
							$('#userLoginForm2 button[type="submit"]').html('Error Verifying Phone <i class="mdi mdi-alert-circle-outline"></i>');
						}
					}
				});
			}
		});

		// ********** Go to login ***********	
		$(document).on('click', '#goToLogin', function() {
			window.location.href = $(this).attr('login_url');
		})

		// ********** Request a delivery **********
		$(document).on('click', '#requestADelivery', function() {
			// Show request delivery modal
			$('#requestDeliveryModal').modal('show');
		})

		// ******** Go to registration modal ********
		$(document).on('click', '#goToRegistrationPage', function() {
			// Show request delivery modal
			$('#requestDeliveryModal').modal('hide');
			// Show registration modal
			$('#registrationModal').modal('show');
		})

		// ********** 2.Verify Customer OTP **********
		$(document).on('submit', '#verifyCustomerOtp', function(e) {
			e.preventDefault();
			// Get the OTP
			const code1 = $('input[name="code1"]').val();
			const code2 = $('input[name="code2"]').val();
			const code3 = $('input[name="code3"]').val();
			const code4 = $('input[name="code4"]').val();
			const code5 = $('input[name="code5"]').val();
			const code6 = $('input[name="code6"]').val();
			const otp = code1 + code2 + code3 + code4 + code5 + code6;

			// Check if the OTP is 6 characters long
			if (otp.length === 6) {
				// Send the OTP to the server
				$.ajax({
					url: $(this).attr('action'),
					method: 'POST',
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						// Find button and add spinner
						$(this).find('button[type="submit"]').html(`
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						<span class="visually-hidden">Loading...</span>
					`);

						// Disable the button
						$(this).find('button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						// console.log(data);
						// Check if the data is true
						if (data.status === 'success') {
							// Show success message
							$("#loginResponseMessage").html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ data.title }</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);
							$('input[name="csrf_test_name"]').val(data.token);
							// Reset form fields
							$("#verifyCustomerOtp")[0].reset();
							// Redirect to the dashboard
							setTimeout(() => {
								window.location.href = data.url;
							}, 2000);
						} else if (data.status === 'error') {
							// Show error message
							$("#loginResponseMessage").html(`
							<div class="alert alert-outline-danger left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-close-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ data.title }</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);
							// Get the token
							$('input[name="csrf_test_name"]').val(data.token);
						}
					},
					complete: function() {
						// Find button and remove spinner
						$(this).find('button[type="submit"]').html('Verify OTP');

						// Enable the button
						$(this).find('button[type="submit"]').attr('disabled', false);
					}
				});
			} else {
				// Show validation error message
				$("#loginResponseMessage").html(`
				<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
					</button>
					<div class="media">
						<div class="alert-left-icon-big">
							<span><i class="mdi mdi-email-alert"></i></span>
						</div>
						<div class="media-body">
							<h6 class="mt-1 mb-2">Validation Error!</h6>
							<p class="mb-0">Please enter a six digit code to continue.</p>
						</div>
					</div>
				</div>`);
			}
		})

		// ******* Validate customer phone number *******
		$(document).on('submit', '#validateCustomerPhoneNumber', function(e) {
			e.preventDefault();
			// Validate form fields
			$(this).validate({
				rules: {
					phoneNumber: {
						required: true,
						minlength: 10,
						maxlength: 10,
						digits: true
					}
				},
				messages: {
					phoneNumber: {
						required: "Please enter your phone number",
						minlength: "Your phone number must be at least 10 characters long",
						maxlength: "Your phone number must be at most 10 characters long",
						digits: "Your phone number must be digits only"
					}
				}
			});

			// Get form data
			let csrf_token = $('#validate_phone_csrf').val();

			// Check if the phone number is valid
			if ($(this).valid()) {
				const url = $(this).attr('action');
				// Send the data to the server
				$.ajax({
					url: url,
					method: 'POST',
					data: $(this).serialize(),
					dataType: 'json',
					beforeSend: function() {
						// Find button and insert loading spinner
						$('#validateCustomerPhoneNumber button[type="submit"]').html(`
						<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
						<span class="visually-hidden">Loading...</span>
					`);
						// Disable button
						$('#validateCustomerPhoneNumber button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						// Check if the data is true
						if (data.status === 'success') {
							$('.number_input').addClass('d-none');
							$('.otp_form').removeClass('d-none');
							// Show success message
							$("#validationErrorMsg").html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">Sent Successfully!</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);
							// // Enable the submit button
							$('#validateCustomerPhoneNumber').find('button[type="submit"]').prop('disabled', false);
							// Remove the modal image
							$('.modalImage').addClass('d-none');
							$('.loginModalTitle').addClass('d-none');
							// Get the csrf token
							$('input[name="csrf_test_name"]').val(data.token);
						} else if (data.status === 'error') {
							// Show error message
							$("#validationErrorMsg").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-email-alert"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-1 mb-2">${ data.title }</h6>
                                            <p class="mb-0">${ data.message }</p>
                                        </div>
                                    </div>
                                </div>`);
							// Disable the submit button
							$('#validateCustomerPhoneNumber button[type="submit"]').attr('disabled', false);
							// Button with warning icon
							$('#validateCustomerPhoneNumber button[type="submit"]').html('Sign In <i class="mdi mdi-alert-circle-outline"></i>');
						}
					}
				});
			} else {
				// Show error message
				$("#customerMessages").html(`
				<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
					</button>
					<div class="media">
						<div class="alert-left-icon-big">
							<span><i class="mdi mdi-email-alert"></i></span>
						</div>
						<div class="media-body">
							<h6 class="mt-1 mb-2">Something went wrong!</h6>
							<p class="mb-0">${ data.message }</p>
						</div>
					</div>
				</div>`);
				// Disable the submit button
				$('#registerNewClient').find('button[type="submit"]').prop('disabled', true);
			}
		})

		// ****** Validate OTP ****** 
		$(document).on('submit', '#verify_otp', function(e) {
			e.preventDefault();
			// Get the OTP
			const code1 = $('input[name="code_1"]').val();
			const code2 = $('input[name="code_2"]').val();
			const code3 = $('input[name="code_3"]').val();
			const code4 = $('input[name="code_4"]').val();
			const code5 = $('input[name="code_5"]').val();
			const code6 = $('input[name="code_6"]').val();
			const otp = code1 + code2 + code3 + code4 + code5 + code6;

			// Check if the OTP is 6 characters long
			if (otp.length === 6) {
				// Get the form data
				var formData = $(this).serialize();
				// Send the data to the server
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					dataType: 'json',
					data: formData,
					beforeSend: function() {
						// Find button and insert loading icon
						$('#otp_form button[type="submit"]').html(`
						<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
						<span class="visually-hidden">Loading...</span>
					`);
						// Disable button
						$('#otp_form button[type="submit"]').attr('disabled', true);
					},
					success: function(data) {
						// Check if the data is true
						if (data.status === 'success') {
							// Show success message
							$("#validationErrorMsg").html(`
							<div class="alert alert-outline-success left-icon-big alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
								</button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-check-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">${ data.title }</h5>
										<p class="mb-0">${ data.message }</p>
									</div>
								</div>
							</div>`);
							// // Enable the submit button
							$('#registerNewClient').find('button[type="submit"]').prop('disabled', false);

							// get token
							$('input[name="csrf_test_name"]').val(data.token);

							// // redirect customer to order page
							setTimeout(function() {
								window.location.href = data.url;
							}, 2000);
						} else if (data.status === 'error') {
							// Show error message
							$("#validationErrorMsg").html(`
								<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi btn-close"></i></span> </button>
									<div class="media">
										<div class="alert-left-icon-big">
											<span><i class="mdi mdi-email-alert"></i></span>
										</div>
										<div class="media-body">
											<h6 class="mt-1 mb-2">${ data.title }</h6>
											<p class="mb-0">${ data.message }</p>
										</div>
									</div>
								</div>`);
							// // Disable the submit button
							// $('#registerNewClient').find('button[type="submit"]').prop('disabled', true);
							$('input[name="csrf_test_name"]').val(data.token['hash']);
						}
					},
					complete: function() {
						// Find button and remove loading icon
						$('#otp_form button[type="submit"]').html('Verify');
						// Enable button
						$('#otp_form button[type="submit"]').attr('disabled', false);
					}
				})
			} else {
				// Show error message
				$("#validationErrorMsg").html(`
					<div class="alert alert-outline-primary left-icon-big alert-dismissible fade show">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi btn-close"></i></span> </button>
						<div class="media">
							<div class="alert-left-icon-big">
								<span><i class="mdi mdi-email-alert"></i></span>
							</div>
							<div class="media-body">
								<h6 class="mt-1 mb-2">Invalid OTP</h6>
								<p class="mb-0">The OTP MUST be a six digits long number. Check your email/phone and try again.</p>
							</div>
						</div>
					</div>`);
				// Disable the submit button
				$('#registerNewClient').find('button[type="submit"]').addClass('error');
			}
		})

		// Populate the quantity field
		$(document).on('change', '#flexSwitchCheckDefault', function() {
			// check if the checkbox is checked
			if ($(this).is(':checked')) {
				$('.Qty_input').removeClass('d-none');
				$('.Qty_input').addClass('animate__animated animate__backInDown');
				// set the quantity to 1
				$('#quantity').val(1);
			} else {
				$('.Qty_input').addClass('d-none');
				// set the quantity to 0
				$('#quantity').val(0);
			}
		})

		// Submit the claculation form
		$(document).on('submit', '#calc-rates', function(e) {
			e.preventDefault();
			const form = $(this);
			const url = form.attr('action');
			const method = form.attr('method');
			const data = form.serialize();

			// Remove any error messages on input focusin event
			$('#package_types').on('focusin', function() {
				$(this).next().remove();
			})

			$('#package_weight').on('focusin', function() {
				$(this).next().remove();
			})

			$('#package_quantity').on('focusin', function() {
				$(this).next().remove();
			})

			$('#package_status').on('focusin', function() {
				$(this).next().remove();
			})

			// Send the request
			$.ajax({
				url: url,
				type: method,
				data: data,
				dataType: 'json',
				beforeSend: function() {
					// Find button and add loading icon
					$('#calc-rates button[type="submit"]').html(`
						<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 5px;"></i> Calculating...`);;
					// Disable button
					$('#calc-rates button[type="submit"]').attr('disabled', true);
				},
				success: function(data) {
					if (data.status === 'success') {
						// alert('Yes')
						// reset the form
						$('#calc-rates')[0].reset();
						$('.calculation__form').addClass('d-none');
						// Display the results to user
						$('#calculation_results').html(`
							<div class="text-center">
								<!-- <img src="<?= site_url('public/images/success.png'); ?>" alt="" width="100"> -->
								<!-- font awesone success icon -->
								<h3 class="text-success">Success</h3>
								<h3 class="text-info fs-24 font-w800" style="border: 1px dashed #58bad7;">PAY KES ${ numberWithCommas(data.data.shipping_fee, 2) }</h3>
								${ data.data.package_status !== 2 ? '<p class="text-success">Your package will be delivered within 24 hours </p>' : '<p class="text-success">Your package will be delivered in 1h 30 mins time.</p>' }
							</div>
							<div class="form-group">
								<label><strong>Package Type: </strong></label>
								<span id="package_type" style="margin-left: 10px;">${ getPackageType(data.data.package_type) }</span>
							</div>
							<div class="form-group mt-3">
								<label><strong>Package Weight (kgs/gms): </strong> </label>
								<span id="package_weight" style="margin-left: 10px;">${ data.data.package_weight == '' ? '0gms - 1kg' : data.data.package_weight+'kgs' }</span>
							</div>
							<div class="form-group mt-3">
								<label><strong>Package Quantity: </strong> (Pcs)</label>
								<span id="package_quantity" style="margin-left: 10px;">${ data.data.package_quantity }</span>
							</div>
							<div class="form-group mt-3">
								<label><strong>Package urgency: </strong></label>
								<span id="package_status" style="margin-left: 10px;">${ data.data.package_status == 1 ? 'Normal' : 'Urgent' }</span>
							</div>
							<div class="form-group mt-3">
								<label><strong>Delivery Fee: </strong></label>
								<span id="delivery_fee" style="margin-left: 10px;">KES ${ numberWithCommas(data.data.shipping_fee, 2) }</span>
							</div>
						`);
						// Enable button
						$('#calc-rates button[type="submit"]').attr('disabled', false);
						// Remove loading icon
						$('#calc-rates button[type="submit"]').html('Calculate');
						// Hide the calculate button
						$('#calc-rates button[type="submit"]').addClass('d-none');
						// Set the token
						$('input[name="csrf_test_name"]').val(data.token);
					} else if (data.status === 'error') {
						// Check the error type
						if (data.data.package_types !== '' && data.data.package_weight !== '' && data.data.package_status !== '') {
							// Display the error message
							$('.package_type_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_types }</span></span>`);
							$('.package_weight_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_weight } </span></span>`);
							$('.package_status_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_status } </span></span>`);
						}

						if (data.data.package_types !== '') {
							$('.package_type_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_types } </span></span>`);
						} else if (data.data.package_weight !== '') {
							$('.package_weight_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_weight } </span></span>`);
						} else if (data.data.package_quantity !== '') {
							$('.package_quantity_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_quantity } </span></span>`);
						} else if (data.data.package_status !== '') {
							$('.package_status_error').html(`<span class="error__messages"><i class="fa fa-exclamation-circle" aria-hidden="true" style="margin-right: 5px;"></i><span> ${ data.data.package_status } </span></span>`);
						}
						// Enable button
						$('#calc-rates button[type="submit"]').attr('disabled', false);
						// Remove loading icon
						$('#calc-rates button[type="submit"]').html('Calculate');
						// Set the token
						$('input[name="csrf_test_name"]').val(data.token);
					}
				},
			})

		})

		// Function for getting package type
		function getPackageType(package) {
			let packageType = '';
			if (package == 'Document') {
				packageType = 'Document';
			} else if (package == 'Parcel') {
				packageType = 'Parcel';
			} else if (package == 'Box') {
				packageType = 'Box';
			} else if (package == 'Crate') {
				packageType = 'Crate';
			} else if (package == 'Pallet') {
				packageType = 'Pallet';
			}
			return packageType;
		}

		// ****** Get user current location function ******
		function getUserCurrentLocation() {
			const successCallback = (position) => {
				console.log(position);
			};

			const errorCallback = (error) => {
				console.log(error);
			};

			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
		}
	</script>
<?php endif; ?>
