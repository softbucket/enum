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
        $this->assertTrue(EnumTestClassStrict::one() === EnumTestClassStrict::one());
        $this->assertTrue(EnumTestClassStrict::one() == EnumTestClassStrict::one());
        $this->assertTrue(EnumTestClassStrict::one() !== EnumTestClassStrict::two());
        $this->assertTrue(EnumTestClassStrict::one() != EnumTestClassStrict::two());
        $this->assertFalse(EnumTestClassStrict::one() == EnumTestClassStrict::two());
        $this->assertFalse(EnumTestClassStrict::one() === EnumTestClassStrict::two());
        $this->assertSame('one', EnumTestClassStrict::one()->name());
        $one = 'one';
        $this->assertSame(EnumTestClassStrict::one(), EnumTestClassStrict::{$one}());
        $this->assertTrue(EnumTestClassStrict::four() === null);
        $five = 'five';
        $this->assertTrue(EnumTestClassStrict::{$five}() === null);

        //loose
        $this->assertTrue(EnumTestClassLoose::one() === EnumTestClassLoose::one());
        $this->assertTrue(EnumTestClassLoose::one() == EnumTestClassLoose::one());
        $this->assertTrue(EnumTestClassLoose::one() !== EnumTestClassLoose::two());
        $this->assertTrue(EnumTestClassLoose::one() != EnumTestClassLoose::two());
        $this->assertFalse(EnumTestClassLoose::one() == EnumTestClassLoose::two());
        $this->assertFalse(EnumTestClassLoose::one() === EnumTestClassLoose::two());
        $this->assertSame('one', EnumTestClassLoose::one()->name());
        $one = 'one';
        $this->assertSame(EnumTestClassLoose::one(), EnumTestClassLoose::{$one}());
        $this->assertTrue(EnumTestClassLoose::four() instanceof EnumTestClassLoose);
        $five = 'five';
        
        $this->assertTrue(EnumTestClassLoose::{$five}() instanceof EnumTestClassLoose);
    }
}
