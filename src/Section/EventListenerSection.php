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

/**
 * Event Listener Section
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class EventListenerSection extends ProgramSection
{
    /**
     * {@inheritdoc}
     */
    protected $sectionName = 'eventlistener';

    /**
     * {@inheritdoc}
     */
    protected $optionalOverride = [
        'buffer_size'    => 'integer',
        'events'         => 'array',
        'result_handler' => 'string',
    ];

    /**
     * @param string $name
     * @param []     $options
     *
     * @codeCoverageIgnore
     */
    public function __construct($name, array $options = [])
    {
        $this->optionalOptions = array_merge($this->optionalOptions, $this->optionalOverride);

        parent::__construct($name, $options);
    }
}
