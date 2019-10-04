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
        $allEnums = EnumHelper::allEnums(EnumTestClassStrict::class);
        $this->assertTrue($allEnums == ['one' => EnumTestClassStrict::one(), 'two' => EnumTestClassStrict::two()]);

        $allEnumsKvp = EnumHelper::allEnumsAsKeyValuePair(EnumTestClassValues::class);
        $this->assertTrue($allEnumsKvp == ['one' => '1', 'two' => 'two']);

        $this->assertTrue(EnumHelper::findByName(EnumTestClassValues::class, 'one') === EnumTestClassvalues::one());
        $this->assertTrue(EnumHelper::findByValue(EnumTestClassValues::class, '1') === EnumTestClassvalues::one());
    }

    public function testStrictEnum()
    {
        //test strict comparison of supposedly same enums
        $this->assertTrue(EnumTestClassStrict::one() === EnumTestClassStrict::one());

        //test loose comparison of same enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassStrict::one() == EnumTestClassStrict::one());

        /** @noinspection PhpNonStrictObjectEqualityInspection */
        //test strict comparison of different objects
        $this->assertTrue(EnumTestClassStrict::one() !== EnumTestClassStrict::two());

        //test weak comparison of different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassStrict::one() != EnumTestClassStrict::two());

        //test weak comparison failure of two different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse(EnumTestClassStrict::one() == EnumTestClassStrict::two());

        //test strict comparison failure of two different enums
        $this->assertFalse(EnumTestClassStrict::one() === EnumTestClassStrict::two());
        $this->assertSame('one', EnumTestClassStrict::one()->name());

        //test strict comparison failure of two different enums
        $one = 'one';
        $this->assertTrue(EnumTestClassStrict::one() === EnumTestClassStrict::{$one}());

        //test name
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertTrue(EnumTestClassStrict::four() === null);

        //test correct behaviour of incorrect parsing by returning null
        $five = 'five';
        $this->assertTrue(EnumTestClassStrict::{$five}() === null);
    }

    public function testEnumValue()
    {
        $this->assertTrue(EnumTestClassValues::one()->value() === '1');
        $this->assertTrue(EnumTestClassValues::two()->value() === 'two');
    }

    public function testEnumFailures()
    {
        $serializedEnum = serialize(EnumTestClassStrict::one());

        //loose comparison succeeds
        $this->assertTrue(unserialize($serializedEnum) == EnumTestClassStrict::one());

        //this is expected to fail since this is not the same object anymore
        $this->assertFalse(unserialize($serializedEnum) === EnumTestClassStrict::one());
    }

    public function testEnumSwitch()
    {
        $oneEnum = EnumTestClassStrict::one();
        switch ($oneEnum)
        {
            case EnumTestClassStrict::one():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassStrict::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClassStrict::{'two'}():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassStrict::{'two'}();
        switch ($oneEnum)
        {
            case EnumTestClassStrict::two():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === true);

        $oneEnum = EnumTestClassStrict::{'three'}();
        switch ($oneEnum)
        {
            case EnumTestClassStrict::two():
                $success = true;
                break;
            default:
                $success = false;
                break;
        }
        $this->assertTrue($success === false);
    }
}
