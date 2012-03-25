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

use Eloquent\Enumeration\Test\Fixture\InvalidEnumeration;
use Eloquent\Enumeration\Test\Fixture\ValidEnumeration;

/**
 * @covers Eloquent\Enumeration\Enumeration
 */
class EnumerationTest extends \Eloquent\Enumeration\Test\TestCase
{
  protected function setUp()
  {
    parent::setUp();

    $reflector = new \ReflectionClass(__NAMESPACE__.'\Multiton');
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
    ), ValidEnumeration::instances());
  }

  public function testByValue()
  {
    $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::byValue(ValidEnumeration::FOO));
    $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::byValue(ValidEnumeration::BAR));
  }

  public function testByValueFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidEnumeration::byValue('mood');
  }

  public function testGet()
  {
    $foo = ValidEnumeration::get('FOO');
    $bar = ValidEnumeration::get('BAR');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
    $this->assertNotEquals($foo, $bar);
    $this->assertSame($foo, ValidEnumeration::get('FOO'));
    $this->assertSame($bar, ValidEnumeration::get('BAR'));
  }

  public function testGetFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidEnumeration::get('DOOM');
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
