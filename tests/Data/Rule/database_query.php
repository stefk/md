<?php

// no violations:

$withStrings = 'delete from baz where id = '
    .'"const literal"';
$withConstants = 'INSERT into foo (name) values ('.Foo::SOME_CONSTANT.')';

// $violations:

$sql = 'SELECT * FROM foo WHERE id = '
    . $bar
    . ' and foo = '
    . $baz;

function baz($x)
{
    updateDb('
        UPDATE quz
        SET y = 1
        Where id >
    '. $x);
}

