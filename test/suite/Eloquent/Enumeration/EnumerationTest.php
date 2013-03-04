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
        $instancesProperty = $reflector->getProperty('instances');
        $instancesProperty->setAccessible(true);
        $instancesProperty->setValue(null, array());
    }

    public function testInitialization()
    {
        $this->assertSame(array(
            'BAZ' => ValidEnumeration::BAZ(),
            'FOO' => ValidEnumeration::FOO(),
            'BAR' => ValidEnumeration::BAR(),
        ), ValidEnumeration::multitonInstances());
    }

    public function testInstanceByValue()
    {
        $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::instanceByValue(ValidEnumeration::FOO));
        $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::instanceByValue(ValidEnumeration::BAR));
    }

    public function testInstanceByValueFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
        ValidEnumeration::instanceByValue('mood');
    }

    public function testInstanceByKey()
    {
        $foo = ValidEnumeration::instanceByKey('FOO');
        $bar = ValidEnumeration::instanceByKey('BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidEnumeration::instanceByKey('FOO'));
        $this->assertSame($bar, ValidEnumeration::instanceByKey('BAR'));
    }

    public function testInstanceByKeyFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
        ValidEnumeration::instanceByKey('DOOM');
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
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
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
