<?php

echo ereg_replace('( )is', '\\1was', $string);

if (ereg('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})', $date, $regs)) {
    echo "$regs[3].$regs[2].$regs[1]";
}

$pattern = '(>[^<]*)('. quotemeta($_GET['search']) .')';
$replacement = '\\1<span class="search">\\2</span>';
$body = eregi_replace($pattern, $replacement, $body);

if (eregi('z', $string)) {
    echo 123;
}

class Bar
{
    public function baz($date)
    {
        list($month, $day, $year) = split('[/.-]', $date);

        return spliti('a', $date, 5);
    }

    public function baz()
    {
        echo sql_regcase('Foo - bar.');
    }
}
