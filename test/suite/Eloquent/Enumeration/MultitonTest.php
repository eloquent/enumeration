<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use Eloquent\Enumeration\Test\Fixture\InvalidMultiton;
use Eloquent\Enumeration\Test\Fixture\ValidMultiton;

/**
 * @covers Eloquent\Enumeration\Multiton
 */
class MultitonTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        ValidMultiton::resetCalls();

        $reflector = new \ReflectionClass(__NAMESPACE__.'\Multiton');
        $instancesProperty = $reflector->getProperty('instances');
        $instancesProperty->setAccessible(true);
        $instancesProperty->setValue(null, array());
    }

    public function testMultitonInstances()
    {
        $this->assertSame(array(
            'FOO' => ValidMultiton::FOO(),
            'BAR' => ValidMultiton::BAR(),
            'BAZ' => ValidMultiton::BAZ(),
        ), ValidMultiton::multitonInstances());
    }

    public function testInstanceByKey()
    {
        $this->assertSame(array(), ValidMultiton::calls());

        $foo = ValidMultiton::instanceByKey('FOO');
        $bar = ValidMultiton::instanceByKey('BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidMultiton::instanceByKey('FOO'));
        $this->assertSame($bar, ValidMultiton::instanceByKey('BAR'));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMultiton',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testInstanceByKeyFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
        ValidMultiton::instanceByKey('DOOM');
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
                'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initializeMultiton',
                array(),
            ),
        ), ValidMultiton::calls());
    }

    public function testCallStaticFailureUndefined()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
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

    public function testToString()
    {
        $foo = ValidMultiton::FOO();
        $bar = ValidMultiton::BAR();

        $this->assertSame($foo->key(), (string)$foo);
        $this->assertSame($bar->key(), (string)$bar);
    }
}
