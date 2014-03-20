<div class="page-header">
    <h3>欢迎图&Logo</h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-normal" data-toggle="tab">欢迎图</a></li>
    <li><a href="#tab-logo" data-toggle="tab">Logo</a></li>
</ul>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=current_url()?>" enctype="multipart/form-data">
    <div class="tab-content">
        <!-- 日常欢迎页 -->
        <div class="tab-pane active" id="tab-normal">
            <div class="control-group">
                <label class="control-label" for="nl_img">欢迎图</label>
                <div class="controls">
                    <input type="file" name="nl_img" size="20">
                </div>
            </div>
            <?php if (file_exists(FCPATH."img/welcome.jpg")):?>
            <div class="control-group">
                <div class="controls">
                    <a href="<?=base_url('img/welcome.jpg')?>" target="_blank"><img src="<?=base_url('img/welcome.jpg')?>" alt="欢迎图" class="img-thumbnail" style="width: 80px; height: 80px;"></a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Logo -->
        <div class="tab-pane" id="tab-logo">
            <div class="control-group">
                <label class="control-label" for="logo_img">Logo</label>
                <div class="controls">
                    <input type="file" name="logo_img" size="20">
                </div>
            </div>
            <?php if (file_exists(FCPATH."img/logo.png")):?>
            <div class="control-group">
                <div class="controls">
                    <a href="<?=base_url('img/logo.png')?>" target="_blank"><img src="<?=base_url('img/logo.png')?>" alt="Logo" class="img-thumbnail" style="width: 80px; height: 80px;"></a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <input type="hidden" name="upload_welcome_img" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/welcome')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">上传</button>
        </div>
    </div>
</form>
