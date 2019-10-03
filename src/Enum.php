<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Softbucket\Enum;

/**
 * Base Enum class
 *
 * Implement by extending this class and defining the methods in the class doc block
 *
 * @author Ed Mak <ed.mak.is@gmail.com>
 */
abstract class Enum
{
    /** @var Enum[][] */
    protected static $enumCacheFromName = array();

    /** @var string  */
    protected $enumName;

    protected function __construct($enumName)
    {
        $this->enumName = $enumName;
    }

    /**
     * @param string $methodName
     * @param array $arguments
     *
     * @return static|null
     */
    public static function __callStatic($methodName, $arguments)
    {
        $className = static::class;
        return static::getEnumFromName($className, $methodName);
    }

    /**
     * @param string $className
     * @param string $enumName
     *
     * @return static
     */
    protected static function getEnumFromName($className, $enumName)
    {
        $enum = isset(self::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        if ($enum !== null) {
            return $enum;
        }

        static::initializeEnums($className);

        $enum = isset(self::$enumCacheFromName[$className][$enumName]) ? static::$enumCacheFromName[$className][$enumName] : null;
        return $enum;
    }

    /**
     * @param $className
     * @return static[]
     */
    protected static function buildNewEnumsFromDocBlocks($className)
    {
        $enums = array();
        try {
            $reflection = new \ReflectionClass($className);
        } catch (\Exception  $e) {
            return $enums;
        }

        $docBlock = $reflection->getDocComment();
        $splitDocBlocks = explode("\n", $docBlock);
        foreach ($splitDocBlocks as $docBlockChunk) {
            $spaceDelimitedTokens = explode(' ', $docBlockChunk);
            $methodName = null;
            foreach ($spaceDelimitedTokens as $token) {
                $tokenLength = strlen($token);
                $brackets = substr($token, $tokenLength - 2);
                if ($brackets === '()') {
                    $methodName = substr($token, 0, $tokenLength - 2);
                    break;
                }
            }
            if ($methodName !== null) {
                $enums[$methodName] = new $className($methodName);
            }
        }
        return $enums;
    }

    /**
     * @param $className
     */
    protected static function initializeEnums($className)
    {
        if (!isset(self::$enumCacheFromName[$className])) { //ie the cache has nothing and we have to build it from the doc blocks
            self::$enumCacheFromName[$className] = static::buildNewEnumsFromDocblocks($className);
        }
    }

    /**
     * @param $className
     * @return static[]
     */
    protected static function getAllEnums($className)
    {
        static::initializeEnums($className);
        return self::$enumCacheFromName[$className];
    }

    /**
     * Name of the enum. Always equal to the method name.
     * @return string
     */
    public function name()
    {
        return $this->enumName;
    }

    /**
     * If the constant isn't defined, then this returns the name
     * @return mixed
     */
    public function value()
    {
        $constantName = static::class . '::' . $this->name();
        if(defined($constantName)) {
            return constant($constantName);
        } else {
            return $this->name();
        }
    }
}
