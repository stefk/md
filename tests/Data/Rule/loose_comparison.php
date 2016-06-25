<?php

if ($foo == $bar) {
    echo 'loose';
}

while (true) {
    $baz = $foo === 'strict';
}

echo $bar !== 'strict';

return $x ? 123 : $bar != 'loose';

