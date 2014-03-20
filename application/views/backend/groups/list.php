<div class="page-header">
	<h3>
        用户组管理

		<div class="pull-right">
			<a href="<?=base_url('admin/groups/create')?>" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 新建</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">编号</th>
			<th class="span3">用户组名</th>
            <th class="span1">管理组</th>
			<th class="span5">简介</th>
			<th class="span2">操作</th>
		</tr>
	</thead>
	<tbody>
        <?php if (isset($grp_list) && !empty($grp_list)): ?>
            <?php foreach ($grp_list as $grp_item): ?>
                <tr>
                    <td><?=$grp_item['ugrp_id']?></td>
                    <td><?=$grp_item['ugrp_name']?></td>
                    <td><?php if ($grp_item['ugrp_admin'] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
                    <td><?=$grp_item['ugrp_desc']?></td>
                    <td>
                        <a href="<?=base_url('admin/groups/edit/'.$grp_item['ugrp_id'])?>" class="btn btn-mini">编辑</a>
                        <a href="<?=base_url('admin/groups/delete/'.$grp_item['ugrp_id'])?>" class="btn btn-mini btn-danger" onclick="javascript:return confirm('确认要删除吗?');">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">请先添加用户组</td></tr>
        <?php endif; ?>
	</tbody>
</table>
