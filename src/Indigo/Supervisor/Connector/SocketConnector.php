<?php

namespace Indigo\Supervisor\Connector;

use Indigo\Supervisor\Exception\InvalidResourceException;
use Indigo\Supervisor\Exception\InvalidResponseException;

class SocketConnector extends AbstractConnector
{
    const CHUNK_SIZE = 8192;

    public function __construct($socket, $timeout = null)
    {
        $timeout = $timeout ?: ini_get('default_socket_timeout');

        $this->resource = @fsockopen($socket, -1, $errNo, $errStr, $timeout);

        if ( ! is_resource($this->resource)) {
            throw new InvalidResourceException('Cannot open socket: ' . $errStr, $errNo);
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function isConnected()
    {
        return is_resource($this->resource);
    }

    public function close()
    {
        if ($this->isConnected()) {
            @fclose($this->resource);
        }
    }

    public function setResource($resource)
    {
        if (is_resource($resource)) {
            return parent::setResource($resource);
        } else {
            throw new InvalidResourceException('Invalid resource');
        }
    }

    public function call($namespace, $method, array $arguments = array())
    {
        $xml = xmlrpc_encode_request($namespace . '.' . $method, $arguments, array('encoding' => 'utf-8'));

        $headers = array_merge($this->headers, array('Content-Length' => strlen($xml)));

        $request = "POST /RPC2 HTTP/1.1\r\n" . http_build_headers($headers) . "\r\n" . $xml;

        fwrite($this->resource, $request);

        $response = '';

        do {
            $response .= fread($this->resource, self::CHUNK_SIZE);

            if ( ! isset($header) and ($headerLength = strpos($response, "\r\n\r\n")) !== false) {
                $header = substr($response, 0, $headerLength);

                $header = http_parse_headers($header);

                if (array_key_exists('Content-Length', $header)) {
                    $contentLength = $header['Content-Length'];
                } else {
                    throw new InvalidResponseException('No Content-Length field found in HTTP header.');
                }
            }

            $bodyStart  = $headerLength + 4;
            $bodyLength = strlen($response) - $bodyStart;

        } while ($this->isConnected() and $bodyLength < $contentLength);

        $response = substr($response, $bodyStart);

        return $this->processResponse($response);
    }
}