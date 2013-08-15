<?php

namespace Bitmessage;

use Bitmessage\Util\FileRetriever;
use Bitmessage\Util\RemoteFileRetriever;

abstract class XmlRpcClient
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var FileRetriver
     */
    private $fileRetriever;

    /**
     * Constructs the XmlRpcClient
     *
     * @param string        $host           The host emaple: localhost or 127.0.0.1
     * @param int           $port           The port
     * @param string        $username       The username
     * @param string        $password       The password
     * @param FileRetriever $fileRetriever  null a new FileRetriever will be created impliciet
     */
    public function __construct($host, $port, $username, $password, FileRetriever $fileRetriever = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->fileRetriever = (null === $fileRetriever ? new RemoteFileRetriever() : $fileRetriever);

    }

    /**
     * Creates the DSN for the server connection
     *
     * @return string
     */
    public function getDSN()
    {
        return "http://{$this->username}:{$this->password}@{$this->host}:{$this->port}/";
    }

    /**
     * Calls the method on the server with the given parameters
     *
     * @param  string $method       The method name
     * @param  array  $parameters   The argument parameters for the method
     *
     * @return string
     */
    protected function call($method, array $parameters = array())
    {
        $request = xmlrpc_encode_request($method, $parameters);

        $context = stream_context_create(array('http' => array(
            'method' => "POST",
            'header' => "Content-Type: text/xml",
            'content' => $request
        )));

        $contents = $this->fileRetriever->retrieveContents($this->getDSN(), $context);
        $response = xmlrpc_decode($contents);

        if ($response && is_array($response) && xmlrpc_is_fault($response))
            trigger_error("xmlrpc: {$response['faultString']} ({$response['faultCode']})");

        return $response;
    }
}
