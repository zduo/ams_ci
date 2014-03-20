<html>
<body>
    <h1>激活账户 <?php echo $identity;?></h1>
    <p>激活链接 <?php echo anchor('auth/activate_account/'. $user_id .'/'. $activation_token, '激活您的账户');?>.</p>
</body>
</html>
