<!-- Navbar with links right -->
<nav class="navbar" id="navbar">
	<!-- LOGO -->
	<div class="logo"><a href="<?= base_url() ?>"><img width="200" src="<?= base_url() ?>public/images/delivisha_logo.png" alt=""></a></div>
	<!-- NAVIGATION MENU -->
	<ul class="nav-links">
		<!-- USING CHECKBOX HACK -->
		<input type="checkbox" id="checkbox_toggle" />
		<label for="checkbox_toggle" class="hamburger">&#9776;</label>
		<!-- NAVIGATION MENUS -->
		<div class="menu">
			<li class="<?= $this->uri->segment(1) == '' ? 'link-active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
			<li class="<?= $this->uri->segment(1) == 'about' ? 'link-active' : '' ?>"><a href="<?= base_url() ?>about">About</a></li>
			<li class="<?= $this->uri->segment(1) == 'shop' ? 'link-active' : '' ?>"><a href="<?= base_url() ?>shop">Shops</a></li>
			<li class="<?= $this->uri->segment(1) == 'contact' ? 'link-active' : '' ?>"><a href="<?= base_url() ?>contact">Contact</a></li>
			<li style="margin: 0 5px !important">
				<?php if ($this->session->userdata('logged_in')) : ?>
					<a href="<?= base_url() ?>customer_account" class="btn btn-primary btn-sm nav-button"> My Account <i class="fa fa-user" style="margin-left: 5px;"></i></a>
				<?php else : ?>
					<a href="<?= site_url() ?>login">
						<button class="btn btn-primary btn-sm nav-button">Users Account <i class="fa fa-lock" style="margin-left: 5px;"></i></button>
					</a>
				<?php endif ?>
			</li>
			<li style="margin: 0 5px !important">
				<?php if ($this->session->userdata('logged_in')) : ?>
					<a href="<?= site_url() ?>logout">
						<button class="btn btn-primary btn-sm nav-button">Logout <i class="fa fa-sign-out" style="margin-left: 5px;"></i></button>
					</a>
				<?php else : ?>
					<a href="javascript:;">
						<button class="btn btn-primary btn-sm nav-button logincustomerbtn">Customer Account <i class="fa fa-user" style="margin-left: 5px;"></i></button>
					</a>
				<?php endif ?>
			</li>

		</div>
	</ul>
</nav>
<!-- END OF NAVBAR -->
