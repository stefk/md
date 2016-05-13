<?php

namespace MD\Watcher;

use MD\Analyser;

class DebugFunctionWatcherTest extends \PHPUnit_Framework_TestCase
{
    private $analyser;

    protected function setUp()
    {
        $this->analyser = Analyser::buildDefault();
        $this->analyser->addWatcher(new DebugFunctionWatcher());
    }

    /**
     * @dataProvider watcherDataProvider
     */
    public function test($source, array $expectedMessages)
    {
        $messages = $this->analyser->analyse($source);
        $this->assertEquals(
            $expectedCount = count($expectedMessages),
            $expectedCount > 0 ? count($messages['']) : 0
        );

        foreach ($expectedMessages as $i => $message) {
            $this->assertEquals($message->message, $messages[''][$i][0]);
        }
    }

    public function watcherDataProvider()
    {
        $dataDir = realpath(__DIR__.'/../Data/Watcher');
        $dataSets = [];

        foreach (new \DirectoryIterator($dataDir) as $item) {
            if ($item->isFile() && $item->getExtension() === 'php') {
                $jsonFile = sprintf('%s/%s.json', $dataDir, $item->getBaseName('.php'));

                if (!file_exists($jsonFile)) {
                    throw new \Exception("No json companion file found for {$item->getPathname()}");
                }

                $dataSets[] = [
                    file_get_contents($item->getPathname()),
                    json_decode(file_get_contents($jsonFile))
                ];
            }

        }

        return $dataSets;
    }
}
