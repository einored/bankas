<?php
$title = 'Login';
require __DIR__ . '/top.php';

?>



<h1>Login to Alamaba</h1>
<form method="post">
    <input type="text" name="name">
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>





<?php
require __DIR__ . '/bottom.php';