<?php
if (count($errors)){ ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error) :?>
        <p class="m-0">- <?php echo $error ?></p>
    <?php endforeach; ?>
</div>
<?php }