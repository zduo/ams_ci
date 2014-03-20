<?php if (isset($message) && !empty($message)): ?>
<div class="alert alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>警告!</h4>
    <?=$message?>
</div>
<?php endif; ?>
