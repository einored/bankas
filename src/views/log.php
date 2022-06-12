<?php 

use Bankas\App;

?>

<?php if (App::auth()) : ?>
<span><?= App::authName() ?></span>
<form action="<?= App::url('logout') ?>" method="post">
    <button type="submit">Logout</button>
</form>

<?php endif ?>



