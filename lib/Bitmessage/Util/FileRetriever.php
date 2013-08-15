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

interface FileRetriever
{
    /**
     * Retrievs the contenten from a data resource name
     *
     * @param  string   $dsn        Data Source Name
     * @param  resource $context    stream_context_create
     */
    public function retrieveContents($dsn, $context = null);
}
