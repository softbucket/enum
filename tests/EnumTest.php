<?php
/**
 * @link    http://github.com/softbucket/enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Softbucket\Tests\Enum;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class EnumTest extends TestCase
{
    public function testEnum()
    {
        //strict

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

        //loose comparisons

        //test strict comparison of supposedly same enums
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::one());

        //test weak comparison of same enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassLoose::one() == EnumTestClassLoose::one());

        //test strict comparison of different objects
        $this->assertTrue(EnumTestClassLoose::one() !== EnumTestClassLoose::two());

        //test weak comparison of different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertTrue(EnumTestClassLoose::one() != EnumTestClassLoose::two());

        //test weak comparison failure of two different enums
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        $this->assertFalse(EnumTestClassLoose::one() == EnumTestClassLoose::two());

        //test strict comparison failure of two different enums
        $this->assertFalse(EnumTestClassLoose::one() === EnumTestClassLoose::two());

        //test name
        $this->assertSame('one', EnumTestClassLoose::one()->name());

        //test parsing of a valid enum
        $one = 'one';
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::{$one}());

        //test correct behaviour of invalid enum
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertTrue(EnumTestClassLoose::four() instanceof EnumTestClassLoose);

        //test correct behaviour of incorrect parsing by returning an enum
        $five = 'five';
        $this->assertTrue(EnumTestClassLoose::{$five}() instanceof EnumTestClassLoose);
    }
}
