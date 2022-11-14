	<!--**********************************
        Scripts
    ***********************************-->

	<script src="<?= base_url() ?>public/assets/vendor/global/global.min.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/js/custom.min.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/vendor/apexchart/apexchart.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/vendor/bootstrap-datetimepicker/js/moment.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/js/dashboard/dashboard-1.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>public/assets/js/dlabnav-init.js" type="text/javascript"></script>
	<!-- <script src="<?= base_url() ?>public/assets/js/demo.js" type="text/javascript"></script> -->
	<!-- <script src="<?= base_url() ?>public/assets/js/styleSwitcher.js" type="text/javascript"></script> -->



	<!-- Custome javaScript Scripts -->
	<!-- <script src="<?= base_url() ?>public/assets/js/custom.js" type="text/javascript"></script> -->
	<script>
		// Script for changing the logo on the navbar
		$(document).on('click', '#hamburger', function() {
			$('.line-3').toggleClass('d-none');
			$('.line-2').toggleClass('d-none');
		});

		$(function() {
			$('#datetimepicker').datetimepicker({
				inline: true,
			});
		});

		$(document).ready(function() {
			$(".booking-calender .fa.fa-clock-o").removeClass(this);
			$(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
		});
	</script>
	</body>

	</html>
