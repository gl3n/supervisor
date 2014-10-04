<?php

/*
 * This file is part of the Indigo Supervisor package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Supervisor\Connector;

/**
 * Dummy Connector
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DummyConnector extends AbstractConnector
{
    protected $local = true;

    /**
     * {@inheritdoc}
     */
    public function call($namespace, $method, array $arguments = array()) {}
}

/**
 * Dummy XMLRPC Connector
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DummyXmlrpcConnector extends AbstractXmlrpcConnector
{
    /**
     * {@inheritdoc}
     */
    public function call($namespace, $method, array $arguments = array()) {}
}