<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>后台::<?=$title?></title>

		<!-- CSS
		================================================== -->
		<link href="<?=base_url('assets/css/bootstrap.css')?>" rel="stylesheet">
		<link href="<?=base_url('assets/css/bootstrap-responsive.css')?>" rel="stylesheet">
		<style>
		body {
			padding: 50px 0;
		}
		</style>
    </head>

	<body>
		<!-- Container -->
		<div class="container">
			<!-- Navbar -->
			<?php $this->load->view('backend/layouts/nav.php'); ?>
			<!-- Content -->
            <?=$content?>
            <!-- Footer -->
			<?php $this->load->view('backend/layouts/footer.php'); ?>
		</div>
	</body>
</html>
<!-- Javascripts
================================================== -->
<script src="<?=base_url('assets/js/jquery.1.10.2.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap/bootstrap.min.js')?>"></script>
<script type="text/javascript">
$(function(){
    var options={
        animation:true,
        trigger:'hover' //触发tooltip的事件
    }
    $('.atip').tooltip(options);
});
</script>
