<div class="page-header">
	<h3>
        IDC列表
		<div class="pull-right">
			<a href="<?=base_url('admin/idc/create')?>" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i>新建</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form method="post" action="<?=current_url()?>">
    
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="span3">IDC名称</th>
                <th class="span4">IDC地址</th>
                <th class="span4">IDC描述</th>
                <th class="span2">IDC线路</th>
				<th class="span1">BGP</th>
				<th class="span2"></th>
            </tr>
        </thead>
        <?php if (isset($idcs) && !empty($idcs)): ?>
        <tbody>
            <?php foreach ($idcs as $item): ?>
                <tr>
                    <td><?=$item['idc_name']?></td>
                    <td><?=$item['idc_location']?></td>                    
                    <td><?=$item['idc_desc']?></td>
					<td><?=$item['idc_isp']?></td>
					<td><?=$item['is_bgp']==1?'YES':'NO';?></td>
					<td>
                        <a href="<?=base_url('admin/idc/edit/'.$item['id'])?>" class="btn btn-mini">编辑</a>
                        <a href="<?=base_url('admin/idc/delete/'.$item['id'])?>" class="btn btn-mini btn-danger" onclick="return confirm('确定要删除吗？');">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php else: ?>
        <tbody><tr><td colspan="6">暂无IDC信息</td></tr></tbody>
        <?php endif; ?>
    </table>
</form>

<?php if (!empty($pagination['links'])): ?>
<div id="pagination">
    <p>共<?=$pagination['total_keys']?>条记录</p>
    <p><?=$pagination['links']?></p>
</div>
<?php endif; ?>

