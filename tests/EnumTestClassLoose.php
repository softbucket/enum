<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Softbucket\Tests\Enum;

use Softbucket\Enum\Enum;

/**
 * @method static self one()
 * @method static self two()
 */
class EnumTestClassLoose extends Enum
{
    protected static function enforceDocBlock()
    {
        return false;
    }
}