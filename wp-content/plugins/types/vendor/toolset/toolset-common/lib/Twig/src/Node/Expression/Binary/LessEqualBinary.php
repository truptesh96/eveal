<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace OTGS\Toolset\Twig\Node\Expression\Binary;

use OTGS\Toolset\Twig\Compiler;
class LessEqualBinary extends \OTGS\Toolset\Twig\Node\Expression\Binary\AbstractBinary
{
    public function operator(\OTGS\Toolset\Twig\Compiler $compiler)
    {
        return $compiler->raw('<=');
    }
}
\class_alias('OTGS\\Toolset\\Twig\\Node\\Expression\\Binary\\LessEqualBinary', 'OTGS\\Toolset\\Twig_Node_Expression_Binary_LessEqual');
