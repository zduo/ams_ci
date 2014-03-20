<div class="page-header">
    <h3>管理后台登录</h3>
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

        <!-- Password -->
        <div class="control-group <?php $pwd_error = form_error('password'); if (!empty($pwd_error)): ?>error<?php endif; ?>">
            <label class="control-label" for="password">密码</label>
            <div class="controls">
                <input type="password" name="password" id="password" value="<?=set_value('password')?>" />
                <span class="help-block"><?=$pwd_error?></span>
            </div>
        </div>

        <?php if (isset($captcha)): ?>
        <div class="control-group">
            <label class="control-label" for="login_captcha">验证码</label>
            <div class="controls">
                <?=$captcha?> = <input type="text" id="captcha" name="login_captcha" class="input-mini"/>
            </div>
        </div>
        <?php endif; ?>

        <!-- Remember me -->
        <div class="control-group">
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" name="remember-me" id="remember-me" value="1" <?=set_checkbox('remember-me', 1) ?>/> 记住我
                </label>
                <a href="<?=base_url('auth/forgotten_password')?>">忘记密码</a>
            </div>
        </div>

        <hr>

        <!-- Form actions -->
        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="login_user" value="Submit" />
                <a class="btn" href="<?=current_url()?>">取消</a>
                <button type="submit" class="btn">登录</button>
            </div>
        </div>
    </form>
</div>
