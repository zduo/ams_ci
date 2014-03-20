<div class="page-header">
	<h3>
	    新建用户组

		<div class="pull-right">
			<a href="<?=base_url('admin/groups')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">基本信息</a></li>
	<li><a href="#tab-permissions" data-toggle="tab">权限</a></li>
</ul>

<form class="form-horizontal" method="post" action="<?=base_url('admin/groups/create')?>" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="control-group">
				<label class="control-label" for="name">用户组名</label>
				<div class="controls">
					<input type="text" name="group_name" id="name" value="<?=set_value('group_name')?>" />
				</div>
			</div>
            <div class="control-group">
                <label class="control-label" for="description">简介</label>
                <div class="controls">
                    <textarea class="input-xlarge" id="description" name="group_desc" rows="3"><?=set_value('group_desc')?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_admin">管理员组</label>
                <div class="controls">
                    <label class="checkbox inline"><input type="checkbox" name="is_admin" id="is_admin" value="1" <?php if (set_value('is_admin')):?>checked="checked"<?php endif; ?> /> 是</label>
                </div>
            </div>
		</div>

		<!-- Tab Permissions -->
		<div class="tab-pane" id="tab-permissions">
			<div class="control-group">
				<div class="controls">

					<fieldset>
						<legend>用户组权限</legend>
                        <?php if (isset($pri_list) && !empty($pri_list)): ?>
                            <?php foreach ($pri_list as $pri_item):?>
                            <div class="control-group">
                                <label class="control-label"><a class="atip" href="#" data-toggle="tooltip" title="<?=htmlspecialchars($pri_item['upriv_desc'])?>"><?=htmlspecialchars($pri_item['upriv_name'])?></a></label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                        <input type="checkbox" value="<?=$pri_item['upriv_id']?>" name="permission[]"> 允许
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                                请先添加用户权限
                            </div>
                        </div>
                        <?php endif; ?>
					</fieldset>

				</div>
			</div>
		</div>
	</div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="create_group" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/groups')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">创建用户组</button>
		</div>
	</div>
</form>
<script>
$(function(){
    var options={
        animation:true,
        trigger:'hover' //触发tooltip的事件
    }
    $('.atip').tooltip(options);
});
</script>
