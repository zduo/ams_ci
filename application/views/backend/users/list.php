<div class="page-header">
	<h3>
        用户管理
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form method="post" action="<?=current_url()?>">
    <div class="well well-sm">
        搜索用户&nbsp;&nbsp;
        <input type="text" id="search" name="search_query" value="<?=set_value('search_users', $search_query)?>">
        <input type="submit" name="search_users" value="搜索" class="btn btn-success" />
    </div>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="span4">Email</th>
                <th class="span4">用户名</th>
                <th class="span2">用户组</th>
                <th class="span1">停用</th>
                <th class="span1">删除</th>
            </tr>
        </thead>
        <?php if (isset($users) && !empty($users)): ?>
        <tbody>
            <?php foreach ($users as $user_item): ?>
            <tr>
                <td>
                    <a href="<?=base_url('admin/users/edit/'.$user_item["uacc_id"])?>"><?=$user_item['uacc_email']?></a>
                </td>
                <td><?=$user_item['uacc_username']?></td>
                <td><?=$user_item[$this->flexi_auth->db_column('user_group', 'name')]?></td>
                <td>
                    <input type="hidden" name="current_status[<?=$user_item["uacc_id"]?>]" value="<?=$user_item["uacc_suspend"]?>" />
                    <!-- A hidden 'suspend_status[]' input is included to detect unchecked checkboxes on submit -->
                    <input type="hidden" name="suspend_status[<?=$user_item["uacc_id"];?>]" value="0" />
                    <input type="checkbox" name="suspend_status[<?=$user_item["uacc_id"]?>]" value="1" <?php echo ($user_item["uacc_suspend"] == 1) ? 'checked="checked"' : "";?>/>
                </td>
                <td>
                    <input type="checkbox" name="delete_user[<?=$user_item["uacc_id"]?>]" value="1" />
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5">
                    <input type="submit" name="update_users" value="更改／删除用户" class="btn btn-danger" onclick="javascript: confirm('确认操作吗?');" />
                </td>
            </tr>
        </tbody>
        <?php else: ?>
        <tbody><tr><td colspan="5">请先注册用户</td></tr></tbody>
        <?php endif; ?>
    </table>
</form>

<?php if (!empty($pagination['links'])): ?>
<div id="pagination">
    <p><?=$pagination['total_users']?> 用户匹配搜索</p>
    <p><?=$pagination['links']?></p>
</div>
<?php endif; ?>

