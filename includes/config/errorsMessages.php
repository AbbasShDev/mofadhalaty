<?php
if (count($errors)){ ?>
<div class="alert alert-danger col-10 col-lg-4 mx-auto">
    <?php foreach ($errors as $error) :?>
        <p class="m-0"><?php echo $error ?></p>
    <?php endforeach; ?>
</div>
<?php }