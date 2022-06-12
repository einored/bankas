<?php
require __DIR__ . '/top.php';
require __DIR__ . '/menu.php';
$uri = explode('/', $_SERVER['REQUEST_URI']);
use Bankas\App;
?>

<h1>Pinigu isemimas</h1>
<main>
    <form action="cashOut" method="post"><hr><br>
        Amount: <input type="number" name="amount" step="0.01"><br>
        <input type="submit" value="Cash out" class="button">
    </form>
</main>

<?php
require __DIR__ . '/bottom.php';