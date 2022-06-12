<?php
$title = 'Account list';

require __DIR__ . '/top.php';
require __DIR__ . '/menu.php';

use Bankas\App;
?>

<h1>Account list</h1>


<table class="table">
    <tr>
        <th>Personal Code</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Account Number</th>
        <th>Balance</th>
        <th>Delete</th>
        <th>Add </th>
        <th>Take out</th>
    </tr>
    <?php
    $json = file_get_contents(__DIR__ . "/../data/users.json");
    $obj = json_decode($json, TRUE);
    if (count($obj) != 0) {
        foreach ($obj as $item) {
            ?>
                <tr>
                    <td><?= $item['personalCode'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['surname'] ?></td>
                    <td><?= $item['accNumber'] ?></td>
                    <td><?= $item['balance'] ?></td>
                    <td>
                    <form action="<?= App::DeleteAcc('delete', $item['personalCode']) ?>" method="post">
                        <button type="submit">Delete</button>
                    </form>
                    </td>
                    <td><a href="<?= App::url('cashIn/'.$item['personalCode']) ?>">Cash in</a></button></td>
                    <td><a href="<?= App::url('cashOut/'.$item['personalCode']) ?>">Cash out</a></button></td>
                </tr>
            <?php
        }
    }
    ?>
</table>
<?php

require __DIR__ . '/bottom.php';