<div class="page-header">
	<h3>
	    新建IDC

		<div class="pull-right">
			<a href="<?=base_url('admin/idc')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
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

<form class="form-horizontal" method="post" action="<?=base_url('admin/idc/create')?>" autocomplete="off" enctype="multipart/form-data">
    <div class="tab-pane active" id="tab-general">
        <div class="control-group">
            <label class="control-label" for="idc_name">IDC名称</label>
            <div class="controls">
                <input type="text" name="idc_name" id="idc_name" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_location">IDC地址</label>
            <div class="controls">
                <input type="text" name="idc_location" id="idc_location" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_desc">IDC描述</label>
            <div class="controls">
                <input type="text" name="idc_desc" id="idc_desc" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label" for="idc_isp">IDC线路</label>
            <div class="controls">
                <input type="text" name="idc_isp" id="idc_isp" />
            </div>
        </div>
		<div class="control-group">
            <label class="control-label">BGP</label>
            <div class="controls">
                <input type="radio" name="is_bgp" value="1" checked />YES
				<input type="radio" name="is_bgp" value="0" />NO
            </div>
        </div>
    </div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
            <input type="hidden" name="create_idc" value="1" />
			<a class="btn btn-link" href="<?=base_url('admin/idc')?>">取消</a>
			<button type="reset" class="btn">重置</button>
			<button type="submit" class="btn btn-success">创建IDC</button>
		</div>
	</div>
</form>
