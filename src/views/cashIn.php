<?php
require __DIR__ . '/top.php';
require __DIR__ . '/menu.php';
$uri = explode('/', $_SERVER['REQUEST_URI']);
use Bankas\App;
?>

<h1>Pinigu pridejimas</h1>
<main>
    <form action="<?= $uri[2] ?>" method="post"><hr><br>
        Deposit amount: <input type="number" name="amount" step="0.01"><br>
        <input type="submit" value="Deposit" class="button">
    </form>
</main>

<?php
require __DIR__ . '/bottom.php';