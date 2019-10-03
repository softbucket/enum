# Clean PHP Enum Implementation

Latest build status:
[![CircleCI](https://circleci.com/gh/softbucket/enum.svg?style=svg)](https://circleci.com/gh/softbucket/enum)  
Github: https://github.com/softbucket/enum  
Packagist: https://packagist.org/packages/softbucket/enum  

Feel free to support me :D 

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://paypal.me/softbucket?locale.x=en_US)  

## What you're getting in this package

### 1. Cleanest IDE Usage
Many implementations of enums rely on a constant to be defined. However, the softbucket implementation has the cleanest usage because the definition of the constant is not required.   

Example:
```
<?php
use Softbucket\Enum\Enum;

/**
 * @method static self AM()
 * @method static self PM()
 */
class Meridiem extends Enum
{
}
```

### 2. Simple Enum Object Methods  
The enum objects are simple to use
```
class Enum 
{
    /**
     * Name of the enum. Always equal to the method name.
     * @return string
     */
    public function name()

    /**
     * If the constant isn't defined, then this returns the name.
     * @return mixed
     */
    public function value()
}
```
Example usage:  
```
Meridiem::AM()->name()
```
```
Meridiem::AM()->value()
```

### 3. Optional Enum Values  
You can define your own custom enum values! Useful for outputting a pretty version of the enum.
```
/**
 * @method static self zero()
 * @method static self one()
 */
class Binary extends Enum
{
    const zero = 0;

    //values default to their name
    //in this case, 'one' will have a value of 'one' 
}
```   

Example usage:  
```
Binary::zero()->value() //this returns 0 (instead of 'zero' because we had overridden the value)
```

### 4. Easy Parsing
Parsing an enum string into an enum object is very easy. Invalid parses return a null.  
```
$AMString = 'AM';

//will return the same as the Meridiem::AM() object
Meridiem::{$AMString}(); 
```
```
$invalidString = 'DM';

//will return a null 
Meridiem::{$invalidString}();
```

### 5. Noise-free Auto-completion
I'm an avid PhpStorm user and the other Enum packages are noisy when using the static class. Say goodbye to ~~Enum::getName()~~, ~~Enum::fromName()~~, ~~Enum::values()~~, ~~Enum::getConstants()~~, etc..  
Get ready to experience a minimalistic auto-complete menu.  
If you need extra functionality, `EnumHelper` will help you with functions such as:  
```
class EnumHelper extends Enum
{
     */
    public static function allEnums($className)

    /**
     * The return element will be either the passed in class type or null.
     * 
     * @param $className
     * @param $value
     * @return Enum
     */
    public static function findByValue($className, $value)

    /**
     * An alias of Enum::{$name}()
     *
     * @param $className
     * @param $name
     * @return Enum
     */
    public static function findByName($className, $name)

    /**
     * Returns a key-value-pair that has the enum-names as keys and the enum-values as values. Returns null if class is not an enum.
     *
     * @param $className
     * @return array
     */
    public static function allEnumsAsKeyValuePair($className)
}
```
Example usage:  
```
EnumHelper::allEnums(Meridiem::class);
```

### 6. Strict Comparator Support `===`
My PHPStorm complains when I'm not using the strict comparator. Therefore I made sure that strict comparisons will work in all typical use cases (only case I know of that can cheat this is during serialization - keep that in mind).
```
Meridiem::one() === Meridiem::one() //true
```
```
Meridiem::one() === Meridiem:{'one'}() //true
```
```
Meridiem::one() === unserialize(serialize(Meridiem:one())) //false - careful
```

### 7. Fast Enums
Just like other enum implementations, softbucket enums use a simple caching mechanic.

### 8. Name It Once
Since constants are optional, you can choose to only maintain the name of the enum in one location - the method name itself. Throw away those redundant constants such as ~~public const AM = 'AM';~~  

#### Thank you for choosing the cleanest php Enum package. I hope you enjoyed using this package and please spread the word for me!