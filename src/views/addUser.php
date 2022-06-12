<?php
$title = 'Account list';

require __DIR__ . '/top.php';
require __DIR__ . '/menu.php';

use Bankas\App;
?>

<main>
    <form action="addUser" method="post">
        <label for="personalCode">Personal number:</label><br>
        <input type="number" name="personalCode"><br><br>
        
        <label for="name">Name:</label><br>
        <input type="text" name="name"><br><br>

        <label for="surname">Surname:</label><br>
        <input type="text" name="surname"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password"><br><br>
        
        <label for="accNumber">Account number:</label><br>
        <input type="text" name="accNumber" value="<?= $iban ?>" readonly><br><br>
        
        <input class="button" type="submit" value="Submit">
    </form>
</main>

<?php

require __DIR__ . '/bottom.php';