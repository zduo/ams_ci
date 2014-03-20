<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="<?=base_url('admin/welcome')?>"><i class="icon-home icon-white"></i> 首页</a></li>
                    <li class="dropdown <?php if (substr(uri_string(), 0, 9) == 'admin/idc' ): ?>active<?php endif; ?>">
                        <a href="<?=base_url('admin/idc')?>"><i class="icon-th-list icon-white"></i> IDC</a>
                    </li>
					<li class="dropdown <?php if (substr(uri_string(), 0, 12) == 'admin/server' ): ?>active<?php endif; ?>">
                        <a href="<?=base_url('admin/server')?>"><i class="icon-hdd icon-white"></i> 服务器</a>
                    </li>

                   
                    <?php if ($this->flexi_auth->is_admin()): ?>
                    <li class="dropdown <?php if (substr(uri_string(), 0, 11) == 'admin/users' || substr(uri_string(), 0, 12) == 'admin/groups' || substr(uri_string(), 0, 16) == 'admin/privileges'): ?>active<?php endif; ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-white icon-tag"></i> 权限<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if ($this->flexi_auth->is_privileged('list_user')):?>
                            <li <?php if (substr(uri_string(), 0, 11) == 'admin/users'):?>class="active"<?php endif; ?>><a href="<?=base_url('admin/users')?>"><i class="icon-tag"></i> 用户</a></li>
                            <?php endif; ?>
                            <?php if ($this->flexi_auth->is_privileged('list_group')): ?>
                            <li <?php if (substr(uri_string(), 0, 12) == 'admin/groups'):?>class="active"<?php endif; ?>><a href="<?=base_url('admin/groups')?>"><i class="icon-tag"></i> 用户组</a></li>
                            <?php endif; ?>
                            <?php if ($this->flexi_auth->is_privileged('list_privilege')): ?>
                            <li <?php if (substr(uri_string(), 0, 16) == 'admin/privileges'):?>class="active"<?php endif; ?>><a href="<?=base_url('admin/privileges')?>"><i class="icon-tag"></i> 权限</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                </ul>
                <ul class="nav pull-right">
                    <li><a href="javascript:none;">你好, <?=$this->auth->session_data['user_name']?></a></li>
                    <li><a href="<?=base_url('auth/logout')?>">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

