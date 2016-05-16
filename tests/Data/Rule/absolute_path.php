<?php

$path1 = '/absolute/path';

file_get_contents('not/absolute/path');

function foo()
{
    $path1 = 'C:/Absolute/Path\with\mixed\slashes';
    $path2 = __DIR__.'/concat/not/absolute';
}

return 'd:\absolute\path';
