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
    /** @var static[][] */
    protected static $enumCacheFromName = array();

    /** @var bool[][] */
    protected static $enumInitialisedFromDocBlock = array();

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
        if (isset(self::$enumCacheFromName[$className][$methodName])) {
            return self::$enumCacheFromName[$className][$methodName];
        }
        self::$enumCacheFromName[$className][$methodName] = new static($methodName);
        return self::$enumCacheFromName[$className][$methodName];
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
        if (!isset(self::$enumInitialisedFromDocBlock[$className])) { //ie the cache has nothing and we have to build it from the doc blocks
            $newEnums = static::buildNewEnumsFromDocblocks($className);
            foreach ($newEnums as $enumName => $enum) {
                if (!isset(self::$enumCacheFromName[$className][$enumName])) {
                    self::$enumCacheFromName[$className][$enumName] = $enum;
                }
            }
            self::$enumInitialisedFromDocBlock[$className] = true;
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

    public function __serialize()
    {
        return [
            'class' => static::class,
            'value' => $this->name()
        ];
    }

    public function __unserialize($serialized)
    {
        $json = $serialized;
        return $json['class']::$json['value']();
    }
}
