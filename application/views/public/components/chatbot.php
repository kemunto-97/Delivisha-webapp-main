<!-- Chat Boat -->
<div class="chatboat__container">
	<div class="chatboat-header bg-primary">
		<div class="chatboat-header-title">
			<h4 class="text-white">Chat With Delivisha Bot</h4>
		</div>
	</div>
	<div class="chatboat-body">
		<div class="chatboat-body-content">
			<!-- <div class="chatboat-body-content-message">
				<div class="chatboat-body-content-message-item">
					<div class="chatboat-body-content-message-item-avatar my-3 text-center">
						<img src="<?= base_url() ?>public/images/delivisha_logo.png" alt="Delivisha Logo" width="100">
					</div>
				</div>
			</div> -->
		</div>

		<div id="chat" class="conv-form-wrapper">
			<form action="<?= site_url('welcome/submit_chatbot_conversation') ?>" method="POST" class="hidden chatBot__Conversation">
				<select data-conv-question="Hello! 👋 I'm a delivisha chatbot how can i help you today? please choose one of the options below" name="first-question">
					<option value="patnership">Become a Partner</option>
					<option value="services">Delivisha Services</option>
				</select>
				<div data-conv-fork="first-question">
					<div data-conv-case="patnership">
						<input type="text" name="name" data-conv-question="Okay! Please, tell me your full name first." placeholder="what's your name?" />
						<input type="text" data-conv-question="<?= get_salute() ?>, {name}:0! It's a pleasure to meet you. Also welcome to Delivisha Logistics here you request and we deliver." data-no-answer="true" />
						<input data-conv-question="Alright, i will need some details from you. Please, enter your email address." data-pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="email" type="email" name="email" required placeholder="What's your e-mail?" />
						<input type="text" name="phone" data-conv-question="Awesome your email is {email}:0. looks good, please enter your phone number." placeholder="What's your phone number?" />
						<input type="text" name="bussiness" data-conv-question="Great! your phone number is {phone}:0, got it!. Now provide me with your business name." placeholder="What's your business name?" />
						<select name="partner" data-callback="" data-conv-question="How would you like to partner with us?">
							<option value="vendor">Vendor</option>
							<option value="rider">Rider</option>
						</select>
						<div data-conv-fork="partner">
							<div data-conv-case="vendor">
								<select name="vendor_thought" data-conv-question="Cool! would you like me to request an account opening for you?">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<div data-conv-fork="vendor_thought">
									<div data-conv-case="yes">
										<input type="text" data-conv-question="Awesome! you will get a call from our team shortly. Thank you for choosing Delivisha Logistics." data-no-answer="true" />
									</div>
									<div data-conv-case="no">
										<input type="text" data-conv-question="Okay! you can request for an account by sending an email to info@delivisha.com. Thank you for choosing Delivisha Logistics." data-no-answer="true" />
									</div>
								</div>
							</div>
							<div data-conv-case="rider">
								<select name="rider_thought" data-conv-question="Cool! would you like me to request an account opening for you?">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<div data-conv-fork="rider_thought">
									<div data-conv-case="yes">
										<input type="text" data-conv-question="Awesome! you will get a call from our team shortly. Thank you for choosing Delivisha Logistics." data-no-answer="true" />
									</div>
									<div data-conv-case="no">
										<input type="text" data-conv-question="Okay! you can request for an account by sending an email to info@delivisha.com. Thank you for choosing Delivisha Logistics." data-no-answer="true" />
									</div>
								</div>
							</div>
						</div>
						<select name="reaction" data-conv-question="Was the conversation helpful?">
							<option value="yes" data-callback="storeState">Yes</option>
							<option value="no" data-callback="restore">No</option>
						</select>
					</div>

					<div data-conv-case="services">
						<input type="text" name="name" data-conv-question="Okay! Please, tell me your full name first." placeholder="what's your name?" />
						<input type="text" data-conv-question="<?= get_salute() ?>, {name}:0! It's a pleasure to meet you. Also Welcome to Delivisha Logistics here you request and we deliver." data-no-answer="true" />
						<input data-conv-question="Alright, i will need some details from you. Please, enter your email address." data-pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="email" type="email" name="email" required placeholder="What's your e-mail?" />
						<input type="text" data-conv-question="Awesome your email is {email}:0. looks good, please enter your phone number." data-no-answer="true" />
						<input type="text" name="phone2" data-conv-question="Cool!😎 your phone number {phone2}:0! got it!, I am here to help you with a few things" />
						<input type="text" data-conv-question="✅ The services offered by Delivisha." data-no-answer="true" />
						<input type="text" data-conv-question="✅ Create an account with Delivishs." data-no-answer="true" />
						<input type="text" data-conv-question="✅ Show you ways of contacting Delivisha." data-no-answer="true" />
						<select name="delivery_services" data-conv-question="Now tell me what kind of service are you interested in knowing?">
							<option value="parcel">Parcel Service</option>
							<option value="rush">Rush Delivery</option>
							<option value="same_day">Same Day Delivery</option>
							<option value="standard">Standard Delivery</option>
						</select>
						<div data-conv-fork="delivery_services">
							<div data-conv-case="parcel">
								<input type="text" data-conv-question="Percel 📦 service involves items below 5kg and is delivered within 24 hours" data-no-answer="true" />
							</div>
							<div data-conv-case="rush">
								<input type="text" data-conv-question="Rush delivery 💨 involves items that are urgent and are delivered within 2 hours" data-no-answer="true" />
							</div>
							<div data-conv-case="same_day">
								<input type="text" data-conv-question="Same day delivery 😃 is done within the same day and is delivered within 4-6 hours" data-no-answer="true" />
							</div>
							<div data-conv-case="standard">
								<input type="text" data-conv-question="Standard delivery 🚚 is done within a day or two and is delivered within 24-48 hours" data-no-answer="true" />
							</div>
						</div>
						<select name="rection2" data-conv-question="Was the conversation helpful?">
							<option value="yes" data-callback="storeState">Yes</option>
							<option value="no" data-callback="restore">No</option>
						</select>
					</div>
				</div>

				<select data-conv-question="Then Please confirm the chat has ended.">
					<option value="conform">Confirm!</option>
				</select>
				<input type="text" data-conv-question="Thank you for choosing Delivisha Logistics. We are always here to help you. Have a nice day." data-no-answer="true" />
			</form>
		</div>

	</div>
</div>
<!-- End Chat Boat -->

<!-- Chat Bot icon -->
<div class="chatboat__icon animate__animated animate__pulse animate__infinite infinite">
	<i class="fa fa-comments" aria-hidden="true"></i>
</div>
<!-- End Bot Icon -->
