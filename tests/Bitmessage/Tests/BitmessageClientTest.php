<?php

namespace Bitmessage\Tests;

use Bitmessage\BitmessageClient;

class BitmessageClientTest extends \PHPUnit_Framework_TestCase
{
    private $testDsn = 'http://bradley:password@localhost:8442/';

    private $fixturesDir;

    public function setUp()
    {
        if (!function_exists('xmlrpc_decode')) {
            $this->fail('The dependency component is not available. Missing module: php5-xmlrpc');
        }

        $this->fixturesDir = dirname(__FILE__).'/../../../meta/fixtures';
    }

    public function testApiTest()
    {
        $contents = file_get_contents($this->fixturesDir.'/helloWorldResponse.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);

        $response = $bmc->test('helloWorld', 'Hello', 'World');
        $this->assertEquals('Hello-World', $response);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testProtocolError()
    {
        $contents = file_get_contents($this->fixturesDir.'/xmlrpc_error.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);
        $response = $bmc->test('helloWorld', array('test'), 'test');
    }

    /**
     * @expectedException Exception
     */
    public function testHelloWorldException()
    {
        $contents = file_get_contents($this->fixturesDir.'/api_error.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);

        $response = $bmc->test('helloWorld1', 'test', 'test');
    }

    public function testCreateRandomAddress()
    {
        $contents = file_get_contents($this->fixturesDir.'/createRandomAddressResponse.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);

        $bmAddress = $bmc->createRandomAddress('test');
        $this->assertEquals('BM-2D7QKHUhFGdxSKwtVSzmwWpBsMmw5j8BNw', $bmAddress);
    }

    public function testSendMessage()
    {
        $contents = file_get_contents($this->fixturesDir.'/sendMessageResponse.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);

        $to = 'BM-2D8N2AVKxH2JPXm2k39kfynFmdXQbw7dMB';
        $from = 'BM-2D7QKHUhFGdxSKwtVSzmwWpBsMmw5j8BNw';
        $expected = 'b3ce1c0308eb0765e0c67eeaf851fc8d0d752359c8f1e499d1fe02e39affbc67';

        $ret = $bmc->sendMessage($to, $from, 'test', 'test');
        $this->assertEquals($expected, $ret);
    }

    public function testListAddresses()
    {
        $contents = file_get_contents($this->fixturesDir.'/listAddressesResponse.txt');
        $fileRetrieverMock = $this->getFileRetrieverMock($contents);

        $bmc = $this->getBmc($fileRetrieverMock);

        $addresses = $bmc->listAddresses();

        $this->assertTrue(is_array($addresses));
        $this->assertEquals('BM-2DBYZKCHfG82V5hHx93vREHeUoPzVmkykh', $addresses['addresses'][0]['address']);
    }

    private function getFileRetrieverMock($contents)
    {
        $mock = $this->getMock('Bitmessage\Util\RemoteFileRetriever');
        $mock->expects($this->once())
            ->method('retrieveContents')
            ->with($this->testDsn)
            ->will($this->returnValue($contents))
        ;

        return $mock;
    }

    private function getBmc($fileRetriever = null)
    {
        if (null !== $fileRetriever) {
            return new BitmessageClient('localhost', 8442, 'bradley', 'password', $fileRetriever);
        }

        return new BitmessageClient('localhost', 8442, 'bradley', 'password');
    }
}
