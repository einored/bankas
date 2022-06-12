<?php 
use Bankas\App 
?>

<nav class="menu">
    <span>Hello <?= App::authName() ?></span>

    <a class="menuBtn" href="<?= App::url('home') ?>">Home</a>
    <a class="menuBtn" href="<?= App::url('userList') ?>">User list</a>
    <a class="menuBtn" href="<?= App::url('addUser') ?>">Add user</a>

    <form action="<?= App::url('logout') ?>" method="post">
        <button type="submit">Logout</button>
    </form>
</nav>