<?php

$a = $GLOBALS['a'];

if (isset($_SERVER['b'])) {
    return $_GET['c'].$_POST['d'];
}

var_dump($_FILES, $_COOKIE, $_SESSION);

echo $_REQUEST['e'];

return $_ENV;
