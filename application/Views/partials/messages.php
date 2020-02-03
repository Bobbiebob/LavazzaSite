    <!-- Little margin to separate messages from the header -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="margin-top: 2.5vh;">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" style="margin-top: 2.5vh;">
            <?= $success ?>
        </div>
    <?php endif; ?>
