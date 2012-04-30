<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
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
class MultitonTest extends \Eloquent\Enumeration\Test\TestCase
{
  protected function setUp()
  {
    parent::setUp();

    ValidMultiton::_resetCalls();

    $reflector = new \ReflectionClass(__NAMESPACE__.'\Multiton');
    $instancesProperty = $reflector->getProperty('_instances');
    $instancesProperty->setAccessible(true);
    $instancesProperty->setValue(null, array());
  }

  public function testInstances()
  {
    $this->assertSame(array(
      'FOO' => ValidMultiton::FOO(),
      'BAR' => ValidMultiton::BAR(),
      'BAZ' => ValidMultiton::BAZ(),
    ), ValidMultiton::_instances());
  }

  public function testGet()
  {
    $this->assertSame(array(), ValidMultiton::_calls());

    $foo = ValidMultiton::_get('FOO');
    $bar = ValidMultiton::_get('BAR');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
    $this->assertNotEquals($foo, $bar);
    $this->assertSame($foo, ValidMultiton::_get('FOO'));
    $this->assertSame($bar, ValidMultiton::_get('BAR'));

    $this->assertSame(array(
      array(
        'Eloquent\Enumeration\Test\Fixture\ValidMultiton::_initialize',
        array(),
      ),
    ), ValidMultiton::_calls());
  }

  public function testGetFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidMultiton::_get('DOOM');
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
        'Eloquent\Enumeration\Test\Fixture\ValidMultiton::_initialize',
        array(),
      ),
    ), ValidMultiton::_calls());
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

    $this->assertSame('FOO', $foo->_key());
    $this->assertSame('BAR', $bar->_key());
    $this->assertSame('oof', $foo->_value());
    $this->assertSame('rab', $bar->_value());
  }

  public function testInheritanceProtection()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
    InvalidMultiton::BAZ();
  }
}
