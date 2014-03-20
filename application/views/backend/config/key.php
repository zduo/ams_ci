<div class="page-header">
    <h3>
        映射搜索关键字

        <div class="pull-right">
			<a href="<?=base_url('admin/config/create_key')?>" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> 新建</a>
		</div>
    </h3>
</div>

<?php $this->load->view('warning'); ?>

<form method="post" action="<?=current_url()?>">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="span5">搜索词</th>
                <th class="span6">映射关键词</th>
                <th class="span1">删除</th>
            </tr>
        </thead>
        <?php if (isset($keys) && !empty($keys)): ?>
        <tbody>
            <?php foreach ($keys as $key): ?>
            <tr>
                <td>
                    <a href="<?=base_url('admin/config/edit_key/'.$key['id'])?>"><?=$key['key_str']?></a>
                </td>
                <td><?=$key['key_map_str']?></td>
                <td>
                    <input type="checkbox" name="delete_key[<?=$key['id']?>]" value="1" />
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">
                    <input type="submit" name="update_users" value="删除" class="btn btn-danger" onclick="return confirm('确认操作吗?');" />
                </td>
            </tr>
        </tbody>
        <?php else: ?>
        <tbody><tr><td colspan="3">无关键字映射</td></tr></tbody>
        <?php endif; ?>
    </table>
</form>

<?php if (!empty($pagination['links'])): ?>
<div id="pagination">
    <p>共<?=$pagination['total_keys']?>条记录</p>
    <p><?=$pagination['links']?></p>
</div>
<?php endif; ?>

