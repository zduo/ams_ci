<div class="page-header">
	<h3>
        权限管理

		<div class="pull-right">
			<a href="<?=base_url('admin/privileges/create')?>" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 新建</a>
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

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">编号</th>
			<th class="span3">权限名</th>
			<th class="span6">简介</th>
			<th class="span2">操作</th>
		</tr>
	</thead>
	<tbody>
        <?php if (isset($pri_list) && !empty($pri_list)): ?>
            <?php foreach ($pri_list as $pri_item): ?>
                <tr>
                    <td><?=$pri_item['upriv_id']?></td>
                    <td><?=$pri_item['upriv_name']?></td>
                    <td><?=$pri_item['upriv_desc']?></td>
                    <td>
                        <a href="<?=base_url('admin/privileges/edit/'.$pri_item['upriv_id'])?>" class="btn btn-mini">编辑</a>
                        <a href="<?=base_url('admin/privileges/delete/'.$pri_item['upriv_id'])?>" class="btn btn-mini btn-danger" onclick="javascript:return confirm('确认要删除吗?');">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">请先添加权限</td></tr>
        <?php endif; ?>
	</tbody>
</table>
