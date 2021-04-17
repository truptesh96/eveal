<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace OTGS\Toolset\Twig\Node\Expression\Test;

use OTGS\Toolset\Twig\Compiler;
use OTGS\Toolset\Twig\Node\Expression\TestExpression;
/**
 * Checks if a variable is the same as another one (=== in PHP).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SameasTest extends \OTGS\Toolset\Twig\Node\Expression\TestExpression
{
    public function compile(\OTGS\Toolset\Twig\Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('node'))->raw(' === ')->subcompile($this->getNode('arguments')->getNode(0))->raw(')');
    }
}
\class_alias('OTGS\\Toolset\\Twig\\Node\\Expression\\Test\\SameasTest', 'OTGS\\Toolset\\Twig_Node_Expression_Test_Sameas');
