<div class="page-header">
	<h3>
	    修改IDC

		<div class="pull-right">
			<a href="<?=base_url('admin/idc')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=base_url('admin/idc/edit')?>" autocomplete="off" enctype="multipart/form-data">
    <div class="tab-pane active" id="tab-general">
  
		<div class="control-group">
            <label class="control-label" for="idc_name">IDC名称</label>
            <div class="controls">
				<input type="hidden" name="idc_id" value="<?=$idc['id']?>" />
                <input type="text" name="idc_name" id="idc_name" value="<?=htmlspecialchars($idc['idc_name'])?>" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_location">IDC地址</label>
            <div class="controls">
                <input type="text" name="idc_location" id="idc_location" value="<?=htmlspecialchars($idc['idc_location'])?>" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_desc">IDC描述</label>
            <div class="controls">
                <input type="text" name="idc_desc" id="idc_desc" value="<?=htmlspecialchars($idc['idc_desc'])?>" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_isp">IDC线路</label>
            <div class="controls">
                <input type="text" name="idc_isp" id="idc_isp" value="<?=htmlspecialchars($idc['idc_isp'])?>" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label">BGP</label>
            <div class="controls">
                <input type="radio" name="is_bgp" value="1" <? if($idc['is_bgp']!=0){ echo 'checked'; }?> />YES
				<input type="radio" name="is_bgp" value="0" <? if($idc['is_bgp']==0){ echo 'checked'; }?>/>NO
            </div>
        </div>





    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="edit_idc" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/idc')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">修改IDC</button>
		</div>
	</div>
</form>
