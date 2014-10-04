<?php

/*
 * This file is part of the Indigo Supervisor package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Supervisor\Event;

/**
 * Dummy Connector
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DummyMemmonListener extends MemmonListener
{
    protected function processResult($result)
    {
        parent::processResult($result);
        return false;
    }
}