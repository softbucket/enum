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
        $allEnums = EnumHelper::allEnums(EnumTestClassEnforced::class);
        $this->assertTrue($allEnums == ['one' => EnumTestClassEnforced::one(), 'two' => EnumTestClassEnforced::two()]);
    }

    public function testEnumBasic()
    {
        //test strict comparison of same enums part 1
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::one());

        //test strict comparison of same enums part 2
        $one = 'one';
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::{$one}());

        //test loose comparison of same enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassLoose::one() == EnumTestClassLoose::one());

        //test strict comparison of different objects
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassLoose::one() !== EnumTestClassLoose::two());

        //test weak comparison of different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassLoose::one() != EnumTestClassLoose::two());

        //test weak comparison of two different enums to fail
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse(EnumTestClassLoose::one() == EnumTestClassLoose::two());

        //test strict comparison two different enums to fail part 1
        $this->assertFalse(EnumTestClassLoose::one() === EnumTestClassLoose::two());

        //test strict comparison two different enums to fail part 2
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::{$one}());

        //test enum name
        $this->assertSame('one', EnumTestClassLoose::one()->name());
    }

    public function testLooseEnumAdvanced()
    {
        //test name
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertFalse(EnumTestClassLoose::four() === null);

        //test correct behaviour of incorrect parsing by returning null
        $five = 'five';
        $this->assertFalse(EnumTestClassLoose::{$five}() === null);
    }

    /**
     * These tests should mirror testEnumBasic() except against EnumDocBlockEnforced
     */
    public function testStrictEnumBasic()
    {
        //test strict comparison of same enums part 1
        $this->assertTrue(EnumTestClassEnforced::one() === EnumTestClassEnforced::one());

        //test strict comparison of same enums part 2
        $one = 'one';
        $this->assertTrue(EnumTestClassEnforced::one() === EnumTestClassEnforced::{$one}());

        //test loose comparison of same enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassEnforced::one() == EnumTestClassEnforced::one());

        //test strict comparison of different objects
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassEnforced::one() !== EnumTestClassEnforced::two());

        //test weak comparison of different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassEnforced::one() != EnumTestClassEnforced::two());

        //test weak comparison of two different enums to fail
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse(EnumTestClassEnforced::one() == EnumTestClassEnforced::two());

        //test strict comparison two different enums to fail part 1
        $this->assertFalse(EnumTestClassEnforced::one() === EnumTestClassEnforced::two());

        //test strict comparison two different enums to fail part 2
        $this->assertTrue(EnumTestClassEnforced::one() === EnumTestClassEnforced::{$one}());
        
        //test enum name
        $this->assertSame('one', EnumTestClassEnforced::one()->name());
    }

    public function testStrictEnumAdvanced()
    {
        //test name
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertTrue(EnumTestClassEnforced::four() === null);

        //test correct behaviour of incorrect parsing by returning null
        $five = 'five';
        $this->assertTrue(EnumTestClassEnforced::{$five}() === null);
    }

    public function testEnumFailures()
    {
        $serializedEnum = serialize(EnumTestClassEnforced::one());

        //loose comparison succeeds
        $this->assertTrue(unserialize($serializedEnum) == EnumTestClassEnforced::one());

        //this is expected to fail since this is not the same object anymore
        $this->assertFalse(unserialize($serializedEnum) === EnumTestClassEnforced::one());
    }

    public function testEnumSwitch()
    {
        $oneEnum = EnumTestClassEnforced::one();
        switch ($oneEnum)
        {
            case EnumTestClassEnforced::one():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassEnforced::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClassEnforced::{'two'}():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassEnforced::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClassEnforced::two():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassEnforced::{'three'}();
        switch ($oneEnum)
        {
            case EnumTestClassEnforced::two():
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
        $serializedEnum = EnumHelper::serialize(EnumTestClassEnforced::one());
        print_r($serializedEnum);
        $unserailzedEnum = EnumHelper::unserialize($serializedEnum);
        $this->assertTrue($unserailzedEnum === EnumTestClassEnforced::one());
    }
}
