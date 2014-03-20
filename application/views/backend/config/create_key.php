<div class="page-header">
	<h3>
	    新建映射

		<div class="pull-right">
			<a href="<?=base_url('admin/config/search_key')?>" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> 返回</a>
		</div>
	</h3>
</div>

<?php $this->load->view('warning'); ?>

<form class="form-horizontal" method="post" action="<?=current_url()?>" autocomplete="off">
    <div class="control-group">
        <label class="control-label" for="key_str">搜索关键词</label>
        <div class="controls">
            <input type="text" name="key_str" id="key_str" value="<?=set_value('key_str')?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="key_map_str">映射词</label>
        <div class="controls">
            <input type="text" name="key_map_str" id="key_map_str" value="<?=set_value('key_map_str')?>" />
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <input type="hidden" name="create_key" value="1" />
            <a class="btn btn-link" href="<?=base_url('admin/search_key')?>">取消</a>
            <button type="reset" class="btn">重置</button>
            <button type="submit" class="btn btn-success">创建映射</button>
        </div>
    </div>
</form>
