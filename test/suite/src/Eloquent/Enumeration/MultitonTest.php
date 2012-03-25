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

    ValidMultiton::resetCalls();

    $reflector = new \ReflectionClass(__NAMESPACE__.'\Multiton');
    $instancesProperty = $reflector->getProperty('instances');
    $instancesProperty->setAccessible(true);
    $instancesProperty->setValue(null, array());
  }

  public function testInstances()
  {
    $this->assertSame(array(
      'FOO' => ValidMultiton::FOO(),
      'BAR' => ValidMultiton::BAR(),
      'BAZ' => ValidMultiton::BAZ(),
    ), ValidMultiton::instances());
  }

  public function testGet()
  {
    $this->assertSame(array(), ValidMultiton::calls());

    $foo = ValidMultiton::get('FOO');
    $bar = ValidMultiton::get('BAR');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidMultiton', $bar);
    $this->assertNotEquals($foo, $bar);
    $this->assertSame($foo, ValidMultiton::get('FOO'));
    $this->assertSame($bar, ValidMultiton::get('BAR'));

    $this->assertSame(array(
      array(
        'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initialize',
        array(),
      ),
    ), ValidMultiton::calls());
  }

  public function testGetFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidMultiton::get('DOOM');
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
        'Eloquent\Enumeration\Test\Fixture\ValidMultiton::initialize',
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
}
