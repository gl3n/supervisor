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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Supervisord Section
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class SupervisordSection extends AbstractSection
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'supervisord';

    /**
     * {@inheritdoc}
     */
    protected $optionalOptions = [
        'logfile'          => 'string',
        'logfile_maxbytes' => ['integer', 'string'],
        'logfile_backups'  => 'integer',
        'loglevel'         => 'string',
        'pidfile'          => 'string',
        'umask'            => 'integer',
        'nodaemon'         => 'bool',
        'minfds'           => 'integer',
        'minprocs'         => 'integer',
        'nocleanup'        => 'bool',
        'childlogdir'      => 'string',
        'user'             => 'string',
        'directory'        => 'string',
        'strip_ansi'       => 'bool',
        'environment'      => ['array', 'string'],
        'identifier'       => 'string',
    ];

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setAllowedValues([
            'loglevel' => ['critical', 'error', 'warn', 'info', 'debug', 'trace', 'blather'],
        ])->setNormalizers([
            'environment' => $this->environmentNormalizer(),
        ]);
    }
}
