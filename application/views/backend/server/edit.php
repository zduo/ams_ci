<div class="page-header">
	<h3>
	    修改SERVER

		<div class="pull-right">
			<a href="<?=base_url('admin/server')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=base_url('admin/server/edit')?>" autocomplete="off" enctype="multipart/form-data">
    <div class="tab-pane active" id="tab-general">
  
		<div class="control-group">
            <label class="control-label" for="idc_id">所在IDC</label>
            <div class="controls">
				<input type="hidden" name="server_id" value="<?=$server['id']?>" />
				<select name="idc_id">
				<?
					foreach($idcs as $key=>$val){
						$select = '';
						if($server['idc_id']==$val['id']){
							$select = 'selected';
						}
						echo '<option value="'.$val['id'].'" '.$select.'>'.$val['idc_name'].'</option>';
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
                <input type="text" name="<?=$k?>" id="<?=$k?>" value="<?=$server[$k]?>" />
            </div>
        </div>
	<?
		}
	?>




    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="edit_server" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/server')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改SERVER</button>
		</div>
	</div>
</form>
