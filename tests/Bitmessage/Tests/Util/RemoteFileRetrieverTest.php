<?php

namespace Bitmessage\Tests\Util;

use Bitmessage\Util\RemoteFileRetriever;

class RemoteFileRetrieverTest extends \PHPUnit_Framework_TestCase
{
    private $remoteFileRetriever;
    private $fixturesDir;

    public function setUp()
    {
        $this->remoteFileRetriever = new RemoteFileRetriever();
        $this->fixturesDir = dirname(__FILE__).'/../../../../meta/fixtures';
    }

    public function testRetriveContents()
    {
        $file = $this->fixturesDir.'/helloWorldResponse.txt';
        $expected = file_get_contents($file);

        $contents = $this->remoteFileRetriever->retrieveContents($file);
        $this->assertEquals($expected, $contents);
    }
}
