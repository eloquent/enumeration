<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use Eloquent\Enumeration\Test\Fixture\InvalidMultiton;
use Eloquent\Enumeration\Test\Fixture\ValidMultiton;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class MultitonTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        ValidMultiton::resetCalls();

        $reflector = new ReflectionClass(__NAMESPACE__.'\Multiton');
        $membersProperty = $reflector->getProperty('members');
        $membersProperty->setAccessible(true);
        $membersProperty->setValue(null, array());
    }

    public function testMembers()
    {
        $this->assertSame(array(
            'FOO' => ValidMultiton::FOO(),
            'BAR' => ValidMultiton::BAR(),
            'BAZ' => ValidMultiton::BAZ(),
        ), ValidMultiton::members());
    }

    public function testMemberByKey()
    {
        $this->assertSame(array(), ValidMultiton::calls());

        $foo = ValidMultiton::memberByKey('FOO');
        $bar = ValidMultiton::memberByKey('BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidMultiton::memberByKey('BAR'));
        $this->assertSame($foo, ValidMultiton::memberByKey('Foo', false));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMembers',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testMemberByKeyFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidMultiton::memberByKey('DOOM');
    }

    public function testMemberByKeyWithDefault()
    {
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByKeyWithDefault('FOO'));
        $this->assertSame(ValidMultiton::BAR(), ValidMultiton::memberByKeyWithDefault('BAR'));
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByKeyWithDefault('Foo', null, false));
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByKeyWithDefault('qux', ValidMultiton::FOO()));
        $this->assertNull(ValidMultiton::memberByKeyWithDefault('qux'));
    }

    public function testMemberBy()
    {
        $this->assertSame(array(), ValidMultiton::calls());

        $foo = ValidMultiton::memberBy('key', 'FOO');
        $bar = ValidMultiton::memberBy('key', 'BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidMultiton::memberByKey('BAR'));
        $this->assertSame($foo, ValidMultiton::memberBy('key', 'Foo', false));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMembers',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testMemberByFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidMultiton::memberBy('key', 'DOOM');
    }

    public function testMemberByWithDefault()
    {
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByWithDefault('key', 'FOO'));
        $this->assertSame(ValidMultiton::BAR(), ValidMultiton::memberByWithDefault('key', 'BAR'));
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByWithDefault('key', 'Foo', null, false));
        $this->assertSame(ValidMultiton::FOO(), ValidMultiton::memberByWithDefault('key', 'qux', ValidMultiton::FOO()));
        $this->assertNull(ValidMultiton::memberByWithDefault('key', 'qux'));
    }

    public function testMemberByPredicate()
    {
        $this->assertSame(array(), ValidMultiton::calls());

        $foo = ValidMultiton::memberByPredicate(
            function (ValidMultiton $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidMultiton::memberByPredicate(
            function (ValidMultiton $member) {
                return $member->key() === 'BAR';
            }
        );

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidMultiton::memberByKey('BAR'));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMembers',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testMemberByPredicateFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidMultiton::memberByPredicate(
            function (ValidMultiton $member) {
                return false;
            }
        );
    }

    public function testMemberByPredicateWithDefault()
    {
        $foo = ValidMultiton::memberByPredicateWithDefault(
            function (ValidMultiton $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidMultiton::memberByPredicateWithDefault(
            function (ValidMultiton $member) {
                return $member->key() === 'BAR';
            }
        );
        $defaultFoo = ValidMultiton::memberByPredicateWithDefault(
            function (ValidMultiton $member) {
                return false;
            },
            ValidMultiton::FOO()
        );
        $defaultNull = ValidMultiton::memberByPredicateWithDefault(
            function (ValidMultiton $member) {
                return false;
            }
        );

        $this->assertSame(ValidMultiton::FOO(), $foo);
        $this->assertSame(ValidMultiton::BAR(), $bar);
        $this->assertSame(ValidMultiton::FOO(), $defaultFoo);
        $this->assertNull($defaultNull);
    }

    public function testCallStatic()
    {
        $foo = ValidMultiton::FOO();
        $bar = ValidMultiton::BAR();

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidMultiton::FOO());
        $this->assertSame($bar, ValidMultiton::BAR());

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMembers',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testCallStaticFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidMultiton::DOOM();
    }

    public function testInstantiationLogic()
    {
        $foo = ValidMultiton::FOO();
        $bar = ValidMultiton::BAR();

        $this->assertSame('FOO', $foo->key());
        $this->assertSame('BAR', $bar->key());
        $this->assertSame('oof', $foo->value());
        $this->assertSame('rab', $bar->value());
    }

    public function testInheritanceProtection()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
        InvalidMultiton::BAZ();
    }

    public function testAnyOf()
    {
        $this->assertTrue(ValidMultiton::BAR()->anyOf(ValidMultiton::FOO(), ValidMultiton::BAR()));
        $this->assertFalse(ValidMultiton::BAZ()->anyOf(ValidMultiton::FOO(), ValidMultiton::BAR()));
    }

    public function testAnyOfArray()
    {
        $array = array(ValidMultiton::FOO(), ValidMultiton::BAR());
        $this->assertTrue(ValidMultiton::BAR()->anyOfArray($array));
        $this->assertFalse(ValidMultiton::BAZ()->anyOfArray($array));
    }

    public function testToString()
    {
        $foo = ValidMultiton::FOO();
        $bar = ValidMultiton::BAR();

        $this->assertSame($foo->key(), (string) $foo);
        $this->assertSame($bar->key(), (string) $bar);
    }
}
