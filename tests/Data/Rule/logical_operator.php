<?php

if ($foo and $bar xor $baz) {
    echo '123';
}

while (true) {
    $baz = quz() or false;
}

// safe:

return $foo && $bar || $baz;

