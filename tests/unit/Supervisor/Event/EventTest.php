<?php

namespace Indigo\Supervisor\Event;

/**
 * Tests for Event
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Supervisor\Event\Event
 */
class EventTest extends AbstractEventTest
{
    public function setUp()
    {
        $this->event = new Event($this->header, $this->payload, $this->body);
    }
}