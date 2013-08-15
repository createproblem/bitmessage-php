<?php

namespace Bitmessage;

use Bitmessage\XmlRpcClient as BaseClient;

class BitmessageClient extends BaseClient
{
    /**
     * Test method only for testing
     *
     * @param  string   $method
     * @param  mixed    $arg1
     * @param  mixed    $arg2
     *
     * @return string
     */
    public function test($method, $arg1, $arg2)
    {
        return $this->call($method, array($arg1, $arg2));
    }

    /**
     * Creates one address using the random number generator.
     *
     * @param  string  $label            Name of the address will be base64 encoded impliciet.
     * @param  boolean $eighteenByteRipe eighteenByteRipe is a boolean telling Bitmessage whether to generate an address
     *                                   with an 18 byte RIPE hash(as opposed to a 19 byte hash).
     *
     * @param  int  $totalDifficulty
     * @param  int  $smallMessageDifficulty
     *
     * @return string   The new generated address
     */
    public function createRandomAddress($label, $eighteenByteRipe = false, $totalDifficulty = 1, $smallMessageDifficulty = 1)
    {
        $params = array(base64_encode($label), $eighteenByteRipe, $totalDifficulty, $smallMessageDifficulty);

        return $this->call('createRandomAddress', $params);
    }

    /**
     * @param  string  $toAddress
     * @param  string  $fromAddress
     * @param  string  $subject
     * @param  string  $message
     * @param  integer $encodingType
     *
     * @return string   ackdata encoded in hex
     */
    public function sendMessage($toAddress, $fromAddress, $subject, $message, $encodingType = 2)
    {
        $params = array(
            $toAddress,
            $fromAddress,
            base64_encode($subject),
            base64_encode($message),
            $encodingType
        );

        return $this->call('sendMessage', $params);
    }

    /**
     * @return array
     */
    public function listAddresses()
    {
        $addressesRaw = $this->call('listAddresses');
        $addresses = json_decode($addressesRaw, true);

        return $addresses;
    }

    /**
     * {@inheritDoc}
     */
    protected function call($method, array $parameters = array())
    {
        $response = parent::call($method, $parameters);

        $error = array();
        if (preg_match("/^API Error ([0-9]+): (.+)$/", $response, $error)) {
            throw new \Exception($error[0]);
        }

        return $response;
    }
}
