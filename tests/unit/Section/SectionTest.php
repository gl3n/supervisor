<?php

/*
 * This file is part of the Indigo Supervisor package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Supervisor\Section;

use Codeception\TestCase\Test;

/**
 * Tests for Sections
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Supervisor\Section\AbstractSection
 * @group              Supervisor
 * @group              Section
 */
class SectionTest extends Test
{
    /**
     * Section object
     *
     * @var Section
     */
    protected $section;

    public function _before()
    {
        $this->section = new DummySection;
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $section = new DummySection(['optional' => 1]);

        $this->assertEquals(['optional' => 1], $section->getOptions());
    }

    /**
     * @covers ::getName
     */
    public function testName()
    {
        $this->assertEquals('dummy', $this->section->getName());
    }

    /**
     * @covers ::getOptions
     * @covers ::setOptions
     * @covers ::hasOptions
     */
    public function testOptions()
    {
        $this->assertFalse($this->section->hasOptions());
        $this->assertSame($this->section, $this->section->setOptions(['optional' => 2]));
        $this->assertEquals(['optional' => 2], $this->section->getOptions());
        $this->assertTrue($this->section->hasOptions());
    }
}
