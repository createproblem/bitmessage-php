<?php

/*
* This file is part of the bitmessage-php package.
*
* (c) littlehill <https://github.com/littlehill/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Bitmessage\Util;

use Bitmessage\Util\FileRetriever;

class RemoteFileRetriever implements FileRetriever
{
    /**
     * Retrievs the contenten from a data resource name
     *
     * @param  string   $dsn        Data Source Name
     * @param  resource $context    stream_context_create
     *
     * @return string
     */
    public function retrieveContents($dsn, $context = null)
    {
        $contents = file_get_contents($dsn, false, $context);

        return $contents;
    }
}
