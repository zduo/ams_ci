<html>
<body>
    <h1>为用户：<?php echo $identity;?> 重置密码</h1>
    <p>请点击链接<?php echo anchor('auth/manual_reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, '重置你的密码');?>.</p>
</body>
</html>
