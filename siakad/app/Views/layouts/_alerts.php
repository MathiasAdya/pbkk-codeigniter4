<?php foreach (['success', 'error'] as $type): ?>
    <?php if ($msg = session()->getFlashdata($type)): ?>
        <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show">
            <?= esc($msg) ?><button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif ?>
<?php endforeach ?>
<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div>
<?php endif ?>
