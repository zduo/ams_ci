<div class="page-header">
	<h3>
	    修改权限

		<div class="pull-right">
			<a href="<?=base_url('admin/privileges')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<?php if (isset($message) && !empty($message)): ?>
<div class="alert alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>警告!</h4>
    <?=$message?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?=base_url('admin/privileges/edit')?>" autocomplete="off">
    <div class="tab-pane active" id="tab-general">
        <div class="control-group">
            <label class="control-label" for="name">权限名</label>
            <div class="controls">
                <input type="hidden" name="privilege_id" value="<?=$pri_info['upriv_id']?>" />
                <input type="text" name="privilege_name" id="name" value="<?=htmlspecialchars($pri_info['upriv_name'])?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">简介</label>
            <div class="controls">
                <textarea class="input-xlarge" id="description" name="privilege_desc" rows="3"><?=htmlspecialchars($pri_info['upriv_desc'])?></textarea>
            </div>
        </div>
    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="create_privilege" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/privileges')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改权限</button>
		</div>
	</div>
</form>
