<div class="page-header">
	<h3>
	    新建SERVER

		<div class="pull-right">
			<a href="<?=base_url('admin/server')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<?php if (isset($message) && !empty($message)): ?>
<div class="alert alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>警告!</h4>
    <?=$message?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?=base_url('admin/server/create')?>" autocomplete="off" enctype="multipart/form-data">
    <div class="tab-pane active" id="tab-general">

		<div class="control-group">
            <label class="control-label" for="idc_id">所在IDC</label>
            <div class="controls">
				<select name="idc_id">
				<?
					foreach($idcs as $key=>$val){
						echo '<option value="'.$val['id'].'">'.$val['idc_name'].'</option>';
					}
				?>
				</select>
            </div>
        </div>
	<?
		foreach($table_column as $k=>$v){
			if($k=='idc_id') continue;
	?>
        <div class="control-group">
            <label class="control-label" for="<?=$k?>"><?=$v?></label>
            <div class="controls">
                <input type="text" name="<?=$k?>" id="<?=$k?>" />
				<?if($k=='server_memory') echo 'G';?>
				<?if($k=='server_cpu_count') echo '个';?>
            </div>
        </div>
	<?
		}
	?>

    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="create_server" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/server')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">创建SERVER</button>
		</div>
	</div>
</form>
