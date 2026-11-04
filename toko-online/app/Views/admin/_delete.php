<form method="post" action="<?= site_url($action) ?>" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
    <?= csrf_field() ?>
    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
</form>
