<?php

namespace MD;

use Symfony\Component\Console\Tester\ApplicationTester;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testAppAnalyseCurrentDirByDefault()
    {
        $originalDir = getcwd();
        chdir(__DIR__.'/Data/Files/no-php');

        $appTester = $this->makeAppTester();
        $code = $appTester->run([]);
        $this->assertEquals(0, $code);

        chdir($originalDir);
    }

    public function testAppThrowsOnInvalidPath()
    {
        $appTester = $this->makeAppTester();
        $code = $appTester->run(['files' => [__FILE__, 'unkwown']]);
        $this->assertEquals(1, $code);
        $this->assertContains("'unkwown' is not a valid path", $appTester->getDisplay());
    }

    public function testFileWithoutViolations()
    {
        $appTester = $this->makeAppTester();
        $code = $appTester->run(['files' => [__DIR__.'/Data/Files/no-violations/foo.php']]);
        $this->assertEquals(0, $code);
    }

    public function testFileWithViolations()
    {
        $appTester = $this->makeAppTester();
        $code = $appTester->run(['files' => [__DIR__.'/Data/Files/violations/foo.php']]);
        $this->assertEquals(1, $code);
    }

    public function testDirWithViolations()
    {
        $originalDir = getcwd();
        chdir(__DIR__);

        $appTester = $this->makeAppTester();
        $code = $appTester->run(['files' => ['Data/Files/violations']]);
        $this->assertEquals(1, $code);

        // next we want to assert 2 violations are found, but unfortunately
        // file/directory traversal order varies (PHP, OS dependent?) so
        // we have to check that the output contains them in any order
        $error1 = <<<ERR1
Data/Files/violations/foo.php:
  - line 3: found eval() call (eval() should never be used)

ERR1;
        $error2 = <<<ERR2
Data/Files/violations/bar/baz.php:
  - lines 3-5: found var_dump() call (debug functions should not be included in production code)

ERR2;
        $this->assertContains(
            $appTester->getDisplay(),
            [$error1.$error2, $error2.$error1]
        );

        chdir($originalDir);
    }

    private function makeAppTester()
    {
        $app = new Application();
        $app->setAutoExit(false);

        return new ApplicationTester($app);
    }
}
