<?php

namespace N;

use Foo\Bar;
use Baz as Quz;

// no violations:

$a = new Bar();
$b = new Quz\Test();
$c = new \stdClass(); // std/global
$d = new O\P(); // relative

// $violations:

$d = new \X\Y\Z();
$e = \A\B::c();
