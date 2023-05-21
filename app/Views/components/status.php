<?php if (session()->has('status')): ?>
    <?php $status = session()->get('status'); ?>
    <div class="alert alert-<?php echo ['success' => 'success', 'error' => 'danger'][$status['type']]; ?> mb-3">
        <?php echo $status['message']; ?>
    </div>
<?php endif; ?>
