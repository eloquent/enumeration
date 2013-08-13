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

use Eloquent\Enumeration\Test\Fixture\InvalidEnumeration;
use Eloquent\Enumeration\Test\Fixture\ValidEnumeration;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class EnumerationTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $reflector = new ReflectionClass(__NAMESPACE__.'\Multiton');
        $membersProperty = $reflector->getProperty('members');
        $membersProperty->setAccessible(true);
        $membersProperty->setValue(null, array());
    }

    public function testInitialization()
    {
        $this->assertSame(array(
            'BAZ' => ValidEnumeration::BAZ(),
            'FOO' => ValidEnumeration::FOO(),
            'BAR' => ValidEnumeration::BAR(),
        ), ValidEnumeration::members());
    }

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

    public function testCallStaticUndefined()
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
        InvalidEnumeration::QUX();
    }
}
