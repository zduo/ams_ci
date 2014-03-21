<!DOCTYPE html>
<html>
    <head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>后台管理::<?=$title?></title>

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">

		<style>
		body {
			padding: 10px 0;
		}
		</style>
    </head>

    <body>
        <!-- Container -->
        <div class="container">
            <!-- Navbar -->
            <div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container">
						<div class="nav-collapse collapse">
							<ul class="nav">
								<li class="active"><a href=""><i class="icon-home icon-white"></i> 首页</a></li>
							</ul>

                            <ul class="nav pull-right">
								<li class="active"><a href="<?=base_url('auth/register')?>">注册</a></li>
								<li class="active"><a href="<?=base_url('auth')?>">登录</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

            <!-- Content -->
            <?=$content?>

            <hr />

            <!-- Footer -->
            <footer>
                <p>&copy; Nova <?=date('Y') ?></p>
            </footer>
        </div>

        <!-- Javascripts
        ================================================-->
        <script src="<?=base_url('assets/js/jquery.1.10.2.min.js')?>"></script>
        <script src="<?=base_url('assets/js/bootstrap/bootstrap.min.js')?>"></script>
    </body>
</html>
