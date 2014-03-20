<div class="page-header">
    <h3>数据备份</h3>
</div>

<?php $this->load->view('warning'); ?>

<form method="post" action="<?=current_url()?>">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th class="span10">备份时间</th>
            <th class="span2">恢复</th>
        </thead>
        <tbody>
            <?php if (empty($this->data['back_file'])):?>
            <tr>
                <td colspan="2">暂时没有备份</td>
            </tr>
            <?php else:?>
            
            <?php foreach ($this->data['back_file'] as $back_time => $back_file):?>
            <tr>
                <td><?=$back_file?></td>
                <td>
                    <input type="radio" name="back" value="<?=$back_file?>" />
                </td>
            </tr>
            <?php endforeach;?>

            <?php endif;?>
            <tr>
                <td colspan="2">
                    <input type="submit" name="reverse_back" value="恢复备份" class="btn btn-danger" onclick="return confirm('确认要恢复吗?');" />
                </td>
            </tr>
        </tbody>
    </table>
</form>
