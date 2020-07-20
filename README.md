# Clean PHP Enum Implementation

Latest build status:
[![CircleCI](https://circleci.com/gh/softbucket/enum.svg?style=svg)](https://circleci.com/gh/softbucket/enum)  
Github: https://github.com/softbucket/enum  
Packagist: https://packagist.org/packages/softbucket/enum  

Feel free to support me :D 

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://paypal.me/softbucket?locale.x=en_US)  

## What you're getting in this package

### 1. Comparator Support `===` and `==`
Use PHP's natural comparator
```
Meridiem::one() === Meridiem::one() //true
```
```
Meridiem::one() == Meridiem::one() //true
```

### 2. Simple
The softbucket implementation does not require constants to be defined.   
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

### 3. Easy Parsing
Parsing a string into an enum is very easy.  
```
$AMString = 'AM';
Meridiem::{$AMString}(); 
```

### 4. No utility methods
The Enum objects are clean of utility methods. Use EnumHelper to grab am array of Enums.
```
EnumHelper::allEnums(Meridiem::class);
```

Goodbye
 
 ~~Enum::getName()~~
 
 ~~Enum::fromName()~~
 
 ~~Enum::values()~~
 
 ~~Enum::getConstants()~~

### 5. Fast Enums
Using simple array caching.

#### Thank you for choosing the cleanest php Enum package. I hope you enjoyed using this package and please spread the word for me!