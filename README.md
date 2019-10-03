# Clean PHP enum implementation

Latest build status:
[![CircleCI](https://circleci.com/gh/softbucket/enum.svg?style=svg)](https://circleci.com/gh/softbucket/enum)  
Github: https://github.com/softbucket/enum  
Packagist: https://packagist.org/packages/softbucket/enum

## What you're getting in this package

### 1) Cleanest Usage for an IDE
Many implementations of enums rely on a constant to be defined. The softbucket implementation has the cleanest usage because the definition of the constant is not used.   

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
### 2) Two modes of operation: Very Fast and Very Faster
There are two modes and is easily switched by overriding the `Enum` static method `enforceDocBlock()`

Example:
```
class Meridiem extends Enum
{
    protected static enforceDocBlock()
    {
        return true; 
    }
}
```

```protected static enforceDocBlock() { return true; } ```  
- Default value. Uses the doc block as a validator (shown in the example however doesn't need to be defined).

```protected static enforceDocBlock() { return false; }```
- Ignores doc block completely. Use this if you're concerned about doc block parsing. Additionally, this won't return a null on bad parses.

Both still use a simple caching mechanic.

### 3) Name it once
You only need to maintain the name of the enum in one location - the method name itself. Throw away those redundant constants such as ~~public const AM = 'AM';~~

### 4) Noise-free auto-completion
I'm an avid PhpStorm user and the other Enum packages are noisy. Say goodbye to ~~getName()~~, ~~fromName()~~, ~~values()~~, ~~getConstants()~~, etc..  
Get ready to experience a minimalistic auto-complete menu.

### 5) Very easy parsing
Parsing an enum string into an enum object is very easy. Invalid parses return a null.  
```
$AMString = 'AM';
Meridiem::{$AMString}(); //will return the same as Meridiem::AM();

Meridiem::{'DM'}(); //will return a null (assuming doc block enforcing)
```
