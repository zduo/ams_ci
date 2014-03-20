<div class="page-header">
    <h3>重置密码</h3>
</div>

<?php $this->load->view('warning'); ?>

<div class="row">
    <form method="post" action="<?=current_url()?>" class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="new_password">新密码:</label>
            <div class="controls">
                <input type="password" id="new_password" name="new_password" value="" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="confirm_new_password">确认密码</label>
            <div class="controls">
                <input type="password" id="confirm_new_password" name="confirm_new_password" value="" />
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="change_forgotten_password" value="submit" />
                <button type="submit" class="btn">重置密码</button>
            </div>
        </div>
    </form>
</div>

