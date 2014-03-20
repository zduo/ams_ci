<div class="page-header">
    <h3>关于</h3>
</div>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=current_url()?>" autocomplete="off" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label" for="logo">大头照</label>
        <div class="controls">
            <?php if (isset($data['logo'])): ?>
            <img src="<?=$data['logo']?>" width="150"><br>
            <?php endif;?>
            <input type="file" name="logo" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="weibo">微博</label>
        <div class="controls">
            <input type="text" name="weibo" id="weibo" value="<?php if (isset($data['weibo'])):?><?=$data['weibo']?><?php endif; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="weixin">订阅号</label>
        <div class="controls">
            <input type="text" name="weixin" id="weixin" value="<?php if (isset($data['weixin'])):?><?=$data['weixin']?><?php endif; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="host">豆瓣小站</label>
        <div class="controls">
            <input type="text" name="host" id="host" value="<?php if (isset($data['host'])):?><?=$data['host']?><?php endif; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="intro1">介绍一</label>
        <div class="controls">
            <textarea id="intro" name="intro1" rows="5" class="span4"><?php if (isset($data['intro1'])):?><?=$data['intro1']?><?php endif; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="intro_img">插图</label>
        <div class="controls">
            <?php if (isset($data['intro_img'])): ?>
            <img src="<?=$data['intro_img']?>" width="150"><br>
            <?php endif;?>
            <input type="file" name="intro_img" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="intro2">介绍二</label>
        <div class="controls">
            <textarea id="intro" name="intro2" rows="5" class="span4"><?php if (isset($data['intro2'])):?><?=$data['intro2']?><?php endif; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="badge">徽章</label>
        <div class="controls">
            <?php if (isset($data['badge'])): ?>
            <img src="<?=$data['badge']?>" width="150"><br>
            <?php endif;?>
            <input type="file" name="badge" />
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <input type="hidden" name="update_intro" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/welcome')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改</button>
        </div>
    </div>
</form>
