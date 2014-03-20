<div class="page-header">
    <h3>找回密码</h3>
</div>

<?php $this->load->view('warning'); ?>

<div class="row">
    <form method="post" action="<?=current_url()?>" class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="identity">邮箱或用户名</label>
            <div class="controls">
                <input type="text" name="forgot_password_identity" id="identity" value="" />
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="send_forgotten_password" value="Submit" />
                <button type="submit" class="btn">发送邮件</button>
            </div>
        </div>
    </form>
</div>
