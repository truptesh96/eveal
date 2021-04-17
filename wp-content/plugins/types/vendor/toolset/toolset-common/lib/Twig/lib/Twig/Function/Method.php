<?php

namespace OTGS\Toolset;

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Arnaud Le Blanc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use OTGS\Toolset\Twig\Extension\ExtensionInterface;
@\trigger_error('The Twig_Function_Method class is deprecated since version 1.12 and will be removed in 2.0. Use \\Twig\\TwigFunction instead.', \E_USER_DEPRECATED);
/**
 * Represents a method template function.
 *
 * Use \Twig\TwigFunction instead.
 *
 * @author Arnaud Le Blanc <arnaud.lb@gmail.com>
 *
 * @deprecated since 1.12 (to be removed in 2.0)
 */
class Twig_Function_Method extends \OTGS\Toolset\Twig_Function
{
    protected $extension;
    protected $method;
    public function __construct(\OTGS\Toolset\Twig\Extension\ExtensionInterface $extension, $method, array $options = [])
    {
        $options['callable'] = [$extension, $method];
        parent::__construct($options);
        $this->extension = $extension;
        $this->method = $method;
    }
    public function compile()
    {
        return \sprintf('$this->env->getExtension(\'%s\')->%s', \get_class($this->extension), $this->method);
    }
}
