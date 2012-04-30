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
    $instancesProperty = $reflector->getProperty('_instances');
    $instancesProperty->setAccessible(true);
    $instancesProperty->setValue(null, array());
  }

  public function testInitialization()
  {
    $this->assertSame(array(
      'BAZ' => ValidEnumeration::BAZ(),
      'FOO' => ValidEnumeration::FOO(),
      'BAR' => ValidEnumeration::BAR(),
    ), ValidEnumeration::_instances());
  }

  public function testByValue()
  {
    $this->assertSame(ValidEnumeration::FOO(), ValidEnumeration::_byValue(ValidEnumeration::FOO));
    $this->assertSame(ValidEnumeration::BAR(), ValidEnumeration::_byValue(ValidEnumeration::BAR));
  }

  public function testByValueFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidEnumeration::_byValue('mood');
  }

  public function testGet()
  {
    $foo = ValidEnumeration::_get('FOO');
    $bar = ValidEnumeration::_get('BAR');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidEnumeration', $bar);
    $this->assertNotEquals($foo, $bar);
    $this->assertSame($foo, ValidEnumeration::_get('FOO'));
    $this->assertSame($bar, ValidEnumeration::_get('BAR'));
  }

  public function testGetFailureUndefined()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedInstanceException');
    ValidEnumeration::_get('DOOM');
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

    $this->assertSame('FOO', $foo->_key());
    $this->assertSame('BAR', $bar->_key());
    $this->assertSame('oof', $foo->_value());
    $this->assertSame('rab', $bar->_value());
  }

  public function testInheritanceProtection()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
    InvalidEnumeration::QUX();
  }
}
