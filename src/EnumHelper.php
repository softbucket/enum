<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Softbucket\Enum;

/**
 * Helper class for Enum
 * 
 * @author Ed Mak <ed.mak.is@gmail.com>
 */
class EnumHelper extends Enum
{
    /**
     * The array elements will be of the type that is passed in. Keys will be the enum's name.
     * 
     * @param $className
     * @return Enum[]
     */
    public static function allEnums($className)
    {
        return Enum::getAllEnums($className);
    }
}