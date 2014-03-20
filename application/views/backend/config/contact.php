<div class="page-header">
    <h3>联系方式</h3>
</div>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=current_url()?>" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label" for="contact">联系方式</label>
        <div class="controls">
            <textarea id="contact" name="contact" rows="5" class="span4"><?php if (isset($contact)):?><?=$contact?><?php endif; ?></textarea>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <input type="hidden" name="update_contact" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/welcome')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改</button>
        </div>
    </div>
</form>
