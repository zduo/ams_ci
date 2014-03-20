<div class="page-header">
	<h3>
	    新建权限

		<div class="pull-right">
			<a href="<?=base_url('admin/privileges')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<form class="form-horizontal" method="post" action="<?=base_url('admin/privileges/create')?>" autocomplete="off">
    <div class="tab-pane active" id="tab-general">
        <div class="control-group">
            <label class="control-label" for="name">权限名</label>
            <div class="controls">
                <input type="text" name="privilege_name" id="name" value="<?=set_value('privilege_name')?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">简介</label>
            <div class="controls">
                <textarea class="input-xlarge" id="description" name="privilege_desc" rows="3"><?=set_value('privilege_desc')?></textarea>
            </div>
        </div>
    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="create_privilege" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/privileges')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">创建权限</button>
		</div>
	</div>
</form>
