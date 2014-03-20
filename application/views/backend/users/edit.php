<div class="page-header">
	<h3>
	    修改用户

		<div class="pull-right">
			<a href="<?=base_url('admin/users')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">基本信息</a></li>
	<li><a href="#tab-permissions" data-toggle="tab">权限</a></li>
</ul>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=current_url()?>" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="control-group">
				<label class="control-label" for="name">邮箱</label>
				<div class="controls">
					<input type="text" name="email" id="email" value="<?=set_value('email', $user[$this->flexi_auth->db_column('user_acc', 'email')])?>" />
				</div>
			</div>
            <div class="control-group">
                <label class="control-label" for="username">昵称</label>
                <div class="controls">
                    <input type="text" name="username" id="username" value="<?=set_value('username', $user[$this->flexi_auth->db_column('user_acc', 'username')])?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="group">用户组</label>
                <div class="controls">
                    <select id="group" name="group">
                    <?php foreach ($groups as $group): ?>
                        <?php $user_group = ($group[$this->flexi_auth->db_column('user_group', 'id')] == $user[$this->flexi_auth->db_column('user_acc', 'group_id')]) ? TRUE : FALSE;?>
                        <option value="<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>" <?php echo set_select('update_group', $group[$this->flexi_auth->db_column('user_group', 'id')], $user_group);?>>
                        <?php echo $group[$this->flexi_auth->db_column('user_group', 'name')];?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
		</div>

		<!-- Tab Permissions -->
		<div class="tab-pane" id="tab-permissions">
			<div class="control-group">
				<div class="controls">

					<fieldset>
						<legend>用户权限</legend>
                        <?php if (isset($privileges) && !empty($privileges)): ?>
                            <?php foreach ($privileges as $privilege):?>
                            <div class="control-group">
                                <label class="control-label"><a class="atip" href="#" data-toggle="tooltip" title="<?=htmlspecialchars($privilege[$this->flexi_auth->db_column('user_privileges', 'description')])?>"><?=htmlspecialchars($privilege[$this->flexi_auth->db_column('user_privileges', 'name')])?></a></label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                        <?php
                                        $current_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 1 : 0;
                                        $new_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 'checked="checked"' : NULL;
                                        ?>
                                        <input type="hidden" name="update[<?=$privilege[$this->flexi_auth->db_column('user_privileges', 'id')]?>][id]" value="<?=$privilege[$this->flexi_auth->db_column('user_privileges', 'id')]?>" />
                                        <input type="hidden" name="update[<?=$privilege[$this->flexi_auth->db_column('user_privileges', 'id')]?>][current_status]" value="<?=$current_status ?>"/>
                                        <input type="hidden" name="update[<?=$privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>][new_status]" value="0"/>
                                        <input type="checkbox" name="update[<?=$privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>][new_status]" value="1" <?=$new_status ?>/>
                                        允许
                                        &nbsp;&nbsp;
                                        组权限:
                                        <?php echo (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $group_privileges) ? 'Yes' : 'No'); ?>
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
            <input type="hidden" name="update_user" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/users')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改用户组</button>
		</div>
	</div>
</form>
