<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use Eloquent\Enumeration\Test\Fixture\InvalidEnumeration;
use Eloquent\Enumeration\Test\Fixture\ValidEnumeration;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class AbstractEnumerationTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $reflector = new ReflectionClass(__NAMESPACE__ . '\AbstractMultiton');
        $membersProperty = $reflector->getProperty('members');
        $membersProperty->setAccessible(true);
        $membersProperty->setValue(null, array());
    }

    // Multiton tests ==========================================================

    public function testMemberByKey()
    {
        $foo = ValidEnumeration::memberByKey('FOO');
        $bar = ValidEnumeration::memberByKey('BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidEnumeration::memberByKey('FOO'));
        $this->assertSame($bar, ValidEnumeration::memberByKey('BAR'));
        $this->assertSame($foo, ValidEnumeration::memberByKey('Foo', false));
    }

    public function testMemberByKeyFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberByKey('DOOM');
    }

    public function testMemberByKeyWithDefault()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByKeyWithDefault('FOO'));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberByKeyWithDefault('BAR'));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByKeyWithDefault('Foo', null, false));
        $this->assertSame(
            ValidEnumeration::FOO(),
            ValidEnumeration::memberByKeyWithDefault('qux', ValidEnumeration::FOO())
        );
        $this->assertNull(ValidEnumeration::memberByKeyWithDefault('qux'));
    }

    public function testMemberOrNullByKey()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullByKey('FOO'));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberOrNullByKey('BAR'));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullByKey('Foo', false));
        $this->assertNull(ValidEnumeration::memberOrNullByKey(null));
    }

    public function testMemberOrNullByKeyFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberOrNullByKey('DOOM');
    }

    public function testMemberBy()
    {
        $foo = ValidEnumeration::memberBy('key', 'FOO');
        $bar = ValidEnumeration::memberBy('key', 'BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidEnumeration::memberByKey('FOO'));
        $this->assertSame($bar, ValidEnumeration::memberByKey('BAR'));
        $this->assertSame($foo, ValidEnumeration::memberBy('key', 'Foo', false));
    }

    public function testMemberByFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberBy('key', 'DOOM');
    }

    public function testMemberByWithDefault()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByWithDefault('key', 'FOO'));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberByWithDefault('key', 'BAR'));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByWithDefault('key', 'Foo', null, false));
        $this->assertSame(
            ValidEnumeration::FOO(),
            ValidEnumeration::memberByWithDefault('key', 'qux', ValidEnumeration::FOO())
        );
        $this->assertNull(ValidEnumeration::memberByWithDefault('key', 'qux'));
    }

    public function testMemberOrNullBy()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullBy('key', 'FOO'));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberOrNullBy('key', 'BAR'));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullBy('key', 'Foo', false));
        $this->assertNull(ValidEnumeration::memberOrNullBy('key', null));
    }

    public function testMemberOrNullByFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberOrNullBy('key', 'DOOM');
    }

    public function testMemberByPredicate()
    {
        $foo = ValidEnumeration::memberByPredicate(
            function (ValidEnumeration $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidEnumeration::memberByPredicate(
            function (ValidEnumeration $member) {
                return $member->key() === 'BAR';
            }
        );

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidEnumeration::memberByKey('FOO'));
        $this->assertSame($bar, ValidEnumeration::memberByKey('BAR'));
    }

    public function testMemberByPredicateFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberByPredicate(
            function (ValidEnumeration $member) {
                return false;
            }
        );
    }

    public function testMemberByPredicateWithDefault()
    {
        $foo = ValidEnumeration::memberByPredicateWithDefault(
            function (ValidEnumeration $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidEnumeration::memberByPredicateWithDefault(
            function (ValidEnumeration $member) {
                return $member->key() === 'BAR';
            }
        );
        $defaultFoo = ValidEnumeration::memberByPredicateWithDefault(
            function (ValidEnumeration $member) {
                return false;
            },
            ValidEnumeration::FOO()
        );
        $defaultNull = ValidEnumeration::memberByPredicateWithDefault(
            function (ValidEnumeration $member) {
                return false;
            }
        );

        $this->assertSame(ValidEnumeration::FOO(), $foo);
        $this->assertSame(ValidEnumeration::BAR(), $bar);
        $this->assertSame(ValidEnumeration::FOO(), $defaultFoo);
        $this->assertNull($defaultNull);
    }

    public function testMembers()
    {
        $this->assertSame(array(
            'BAZ' => ValidEnumeration::BAZ(),
            'FOO' => ValidEnumeration::FOO(),
            'BAR' => ValidEnumeration::BAR(),
        ), ValidEnumeration::members());
    }

    public function testMembersBy()
    {
        $foo = ValidEnumeration::membersBy('value', 'oof');
        $bar = ValidEnumeration::membersBy('value', 'RAB', false);

        $this->assertSame(array('FOO' => ValidEnumeration::FOO()), $foo);
        $this->assertSame(array('BAR' => ValidEnumeration::BAR()), $bar);
    }

    public function testMembersByPredicate()
    {
        $notBaz = ValidEnumeration::membersByPredicate(
            function (ValidEnumeration $member) {
                return $member->key() !== 'BAZ';
            }
        );

        $this->assertSame(
            array(
                'FOO' => ValidEnumeration::FOO(),
                'BAR' => ValidEnumeration::BAR(),
            ),
            $notBaz
        );
    }

    public function testCallStatic()
    {
        $foo = ValidEnumeration::FOO();
        $bar = ValidEnumeration::BAR();

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidEnumeration::FOO());
        $this->assertSame($bar, ValidEnumeration::BAR());
    }

    public function testCallStaticFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::DOOM();
    }

    public function testInstantiationLogic()
    {
        $foo = ValidEnumeration::FOO();
        $bar = ValidEnumeration::BAR();

        $this->assertSame('FOO', $foo->key());
        $this->assertSame('BAR', $bar->key());
        $this->assertSame('oof', $foo->value());
        $this->assertSame('rab', $bar->value());
    }

    public function testInheritanceProtection()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
        InValidEnumeration::BAZ();
    }

    public function testAnyOf()
    {
        $this->assertTrue(ValidEnumeration::BAR()->anyOf(ValidEnumeration::FOO(), ValidEnumeration::BAR()));
        $this->assertFalse(ValidEnumeration::BAZ()->anyOf(ValidEnumeration::FOO(), ValidEnumeration::BAR()));
    }

    public function testAnyOfArray()
    {
        $array = array(ValidEnumeration::FOO(), ValidEnumeration::BAR());
        $this->assertTrue(ValidEnumeration::BAR()->anyOfArray($array));
        $this->assertFalse(ValidEnumeration::BAZ()->anyOfArray($array));
    }

    public function testToString()
    {
        $foo = ValidEnumeration::FOO();
        $bar = ValidEnumeration::BAR();

        $this->assertSame($foo->key(), (string) $foo);
        $this->assertSame($bar->key(), (string) $bar);
    }

    // Value multiton tests ====================================================

    public function testMemberByValue()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByValue(ValidEnumeration::FOO));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberByValue(ValidEnumeration::BAR));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberByValue('Oof', false));
    }

    public function testMemberByValueFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberByValue('mood');
    }

    public function testMemberByValueWithDefault()
    {
        $this->assertSame(
            ValidEnumeration::FOO(),
            ValidEnumeration::memberByValueWithDefault(ValidEnumeration::FOO)
        );
        $this->assertSame(
            ValidEnumeration::BAR(),
            ValidEnumeration::memberByValueWithDefault(ValidEnumeration::BAR)
        );
        $this->assertSame(
            ValidEnumeration::FOO(),
            ValidEnumeration::memberByValueWithDefault('Oof', null, false)
        );
        $this->assertSame(
            ValidEnumeration::FOO(),
            ValidEnumeration::memberByValueWithDefault('qux', ValidEnumeration::FOO())
        );
        $this->assertNull(ValidEnumeration::memberByValueWithDefault('qux'));
    }

    public function testMemberOrNullByValue()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullByValue('oof'));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::memberOrNullByValue('rab'));
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::memberOrNullByValue('Oof', false));
        $this->assertNull(ValidEnumeration::memberOrNullByValue(null));
    }

    public function testMemberOrNullByValueFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidEnumeration::memberOrNullByValue('mood');
    }

    public function testMembersByValue()
    {
        $this->assertSame(array('FOO' => ValidEnumeration::FOO()), ValidEnumeration::membersByValue('oof'));
        $this->assertSame(array('BAR' => ValidEnumeration::BAR()), ValidEnumeration::membersByValue('rab'));
        $this->assertSame(array('FOO' => ValidEnumeration::FOO()), ValidEnumeration::membersByValue('Oof', false));
    }
}
