<div class="page-header">
	<h3>接口列表</h3>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th class="span4">接口名</th>
            <th class="span8">地址</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($apis as $desc => $api): ?>
        <tr>
            <td><?=$desc?></td>
            <td><?=base_url($api)?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
