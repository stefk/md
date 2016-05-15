<?php

// commented eval()

eval('$foo = 123;');

$x = function () {
    return bar(eval('return new stdClass;'));
};
