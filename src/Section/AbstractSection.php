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

use Indigo\Supervisor\Section;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

/**
 * Abstract Section
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class AbstractSection implements Section
{
    /**
     * Options
     *
     * @var []
     */
    protected $options = [];

    /**
     * Name of section (eg. supervisord or program:test)
     *
     * @var string
     */
    protected $name;

    /**
     * Required options
     *
     * @var []
     */
    protected $requiredOptions = [];

    /**
     * Optional options
     *
     * @var []
     */
    protected $optionalOptions = [];

    /**
     * Default constructor
     *
     * @param [] $options
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = [])
    {
        $this->options = $this->resolveOptions($options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return empty($this->options) === false;
    }

    /**
     * Resolve options
     *
     * @param array $options
     *
     * @return array Resolved options
     *
     * @codeCoverageIgnore
     */
    protected function resolveOptions(array $options = [])
    {
        static $resolver;

        if ($resolver === null) {
            $resolver = new OptionsResolver;
            $this->setDefaultOptions($resolver);
        }

        return $resolver->resolve($options);
    }

    /**
     * Set default options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @codeCoverageIgnore
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if (empty($this->requiredOptions) === false) {
            $resolver->setRequired(array_keys($this->requiredOptions))
                ->setAllowedTypes($this->requiredOptions);
        }

        if (empty($this->optionalOptions) === false) {
            $resolver->setOptional(array_keys($this->optionalOptions))
                ->setAllowedTypes($this->optionalOptions);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function environmentNormalizer()
    {
        return function (Options $options, $value) {
            if (is_array($value)) {
                $return = [];

                foreach ($value as $key => $val) {
                    if (is_int($key)) {
                        continue;
                    }

                    $return[$key] = strtoupper($key) . '="' . $val . '"';
                }

                $value = implode(',', $return);
            }

            return (string) $value;
        };
    }
}
