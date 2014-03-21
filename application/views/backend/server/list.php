<div class="page-header">
	<h3>
        SERVER列表
		<div class="pull-right">
			<a href="<?=base_url('admin/server/create')?>" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i>新建</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form method="post" action="<?=current_url()?>">
    
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="span3">所在IDC</th>
                <th class="span4">资产编号</th>
                <th class="span4">所在机柜</th>
                <th class="span2">品牌</th>
				<th class="span2">U数</th>
				<th class="span2">CPU型号</th>
				<th class="span2">CPU数量</th>
				<th class="span2">内存大小</th>
				<th class="span2">硬盘</th>
				<th class="span2">电源</th>
				<th class="span2">RAID</th>
				<th class="span2">系统</th>
				<th class="span2">用途描述</th>
				<th class="span2">维护人员</th>
				<th class="span1"></th>
            </tr>
        </thead>
        <?php if (isset($servers) && !empty($servers)): ?>
        <tbody>
            <?php foreach ($servers as $item): 
				$ii = $this->idc_model->idc_info($item['idc_id']);
			?>
                <tr>
                    <td><?=$ii['idc_name']?></td>
                    <td><?=$item['server_label']?></td>                    
                    <td><?=$item['server_cabinet']?></td>
					<td><?=$item['server_oem']?></td>
					<td><?=$item['server_height']?></td>
					<td><?=$item['server_cpu_model']?></td>
					<td><?=$item['server_cpu_count']?></td>
					<td><?=$item['server_memory']?></td>
					<td><?=$item['server_hd']?></td>
					<td><?=$item['server_powers']?></td>
					<td><?=$item['server_raid']?></td>
					<td><?=$item['server_os']?></td>
					<td><?=$item['server_desc']?></td>
					<td><?=$item['server_user']?></td>
					<td>
                        <a href="<?=base_url('admin/server/edit/'.$item['id'])?>" class="btn btn-mini">编辑</a>
                        <a href="<?=base_url('admin/server/delete/'.$item['id'])?>" class="btn btn-mini btn-danger" onclick="return confirm('确定要删除吗？');">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php else: ?>
        <tbody><tr><td colspan="15">暂无SERVER信息</td></tr></tbody>
        <?php endif; ?>
    </table>
</form>

<?php if (!empty($pagination['links'])): ?>
<div id="pagination">
    <p>共<?=$pagination['total_keys']?>条记录</p>
    <p><?=$pagination['links']?></p>
</div>
<?php endif; ?>

