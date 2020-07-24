<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Softbucket\Tests\Enum;

use PHPUnit\Framework\TestCase;
use Softbucket\Enum\EnumHelper;

/**
 * @internal
 */
class EnumTest extends TestCase
{
    public function testEnumHelper()
    {
        $allEnums = EnumHelper::allEnums(EnumTestClass::class);
        $this->assertTrue($allEnums == ['one' => EnumTestClass::one(), 'two' => EnumTestClass::two()]);
    }

    public function testEnumBasic()
    {
        //test strict comparison of same enums part 1
        $this->assertTrue(EnumTestClass::one() === EnumTestClass::one());

        //test strict comparison of same enums part 2
        $one = 'one';
        $this->assertTrue(EnumTestClass::one() === EnumTestClass::{$one}());

        //test loose comparison of same enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClass::one() == EnumTestClass::one());

        //test strict comparison of different objects
        $this->assertTrue(EnumTestClass::one() !== EnumTestClass::two());

        //test weak comparison of different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClass::one() != EnumTestClass::two());

        //test weak comparison of two different enums to fail
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse(EnumTestClass::one() == EnumTestClass::two());

        //test strict comparison two different enums to fail part 1
        $this->assertFalse(EnumTestClass::one() === EnumTestClass::two());

        //test strict comparison two different enums to fail part 2
        $this->assertTrue(EnumTestClass::one() === EnumTestClass::{$one}());

        //test enum name
        $this->assertSame('one', EnumTestClass::one()->name());
    }

    public function testEnumSwitch()
    {
        $oneEnum = EnumTestClass::one();
        switch ($oneEnum)
        {
            case EnumTestClass::one():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClass::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClass::{'two'}():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClass::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClass::two():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClass::{'three'}();
        switch ($oneEnum)
        {
            case EnumTestClass::two():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === false);
    }

    public function testSerialize()
    {
        $serializedEnum = EnumHelper::serialize(EnumTestClass::one());
        $unserailzedEnum = EnumHelper::unserialize($serializedEnum);
        $this->assertTrue($unserailzedEnum === EnumTestClass::one());
    }

    public function testIsDefined()
    {
        $this->assertTrue(EnumHelper::isDefined(EnumTestClass::one()));
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertFalse(EnumHelper::isDefined(EnumTestClass::three()));
    }
}
