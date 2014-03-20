<div class="page-header">
    <h3>管理后台注册</h3>
</div>

<?php $this->load->view('warning'); ?>

<div class="row">
    <form method="post" action="<?=current_url()?>" class="form-horizontal">

        <!-- Email -->
        <div class="control-group <?php $email_error = form_error('email'); if (!empty($email_error)): ?>error<?php endif; ?>">
            <label class="control-label" for="email">邮箱</label>
            <div class="controls">
                <input type="text" name="email" id="email" value="<?=set_value('email')?>" />
                <span class="help-block"><?=$email_error ?></span>
            </div>
        </div>

        <!-- Username -->
        <div class="control-group <?php $username_error = form_error('username'); if (!empty($username_error)): ?>error<?php endif; ?>">
            <label class="control-label" for="username">昵称</label>
            <div class="controls">
                <input type="text" name="username" id="username" value="<?=set_value('username')?>" />
                <span class="help-block"><?=$username_error ?></span>
            </div>
        </div>

        <!-- Password -->
        <div class="control-group <?php $pwd_error = form_error('password'); if (!empty($pwd_error)): ?>error<?php endif; ?>">
            <label class="control-label" for="password">密码</label>
            <div class="controls">
                <input type="password" name="password" id="password" value="<?=set_value('password')?>" />
                <span class="help-block"><?=$pwd_error?></span>
            </div>
        </div>

        <!-- Repassword-->
        <div class="control-group <?php $repwd_error = form_error('repassword'); if (!empty($repwd_error)): ?>error<?php endif; ?>">
            <label class="control-label" for="repassword">重复密码</label>
            <div class="controls">
                <input type="password" name="repassword" id="repassword" value="<?=set_value('repassword')?>" />
                <span class="help-block"><?=$repwd_error?></span>
            </div>
        </div>

        <hr>

        <!-- Form actions -->
        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="register_user" value="Submit" />
                <button type="submit" class="btn">注册</button>
            </div>
        </div>
    </form>
</div>
