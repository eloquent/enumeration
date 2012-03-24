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

use Eloquent\Enumeration\Test\Fixture\ExtendedTestEnumeration;
use Eloquent\Enumeration\Test\Fixture\TestEnumeration;

class EnumerationTest extends \Eloquent\Enumeration\Test\TestCase
{
  protected function setUp()
  {
    parent::setUp();

    TestEnumeration::resetCalls();

    $reflector = new \ReflectionClass(__NAMESPACE__.'\Enumeration');

    $enumerationsProperty = $reflector->getProperty('enumerations');
    $enumerationsProperty->setAccessible(true);
    $enumerationsProperty->setValue(null, array());

    $valuesProperty = $reflector->getProperty('values');
    $valuesProperty->setAccessible(true);
    $valuesProperty->setValue(null, array());
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testByName()
  {
    $foo = TestEnumeration::byName('FOO');
    $bar = TestEnumeration::byName('BAR');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $bar);
    $this->assertSame($foo, TestEnumeration::byName('FOO'));
    $this->assertSame($bar, TestEnumeration::byName('BAR'));
    $this->assertNotEquals($foo, $bar);

    $this->assertSame(array(
      array()
    ), TestEnumeration::initializeCalls());
    $this->assertSame(array(
      array('FOO'),
      array('BAR'),
    ), TestEnumeration::createCalls());
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testByNameFailure()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedEnumerationException');
    TestEnumeration::byName('QUX');
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testByValue()
  {
    $foo = TestEnumeration::byValue('oof');
    $bar = TestEnumeration::byValue('rab');

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $bar);
    $this->assertSame($foo, TestEnumeration::byValue('oof'));
    $this->assertSame($bar, TestEnumeration::byValue('rab'));
    $this->assertNotEquals($foo, $bar);
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testByValueFailure()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedEnumerationValueException');
    TestEnumeration::byValue('xuq');
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testValues()
  {
    $this->assertSame(array(), Enumeration::values());

    $this->assertSame(array(
      'FOO' => 'oof',
      'BAR' => 'rab',
    ), TestEnumeration::values());

    $this->assertSame(array(
      'BAZ' => 'zab',
      'FOO' => 'oof',
      'BAR' => 'rab',
    ), ExtendedTestEnumeration::values());
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testCallStatic()
  {
    $foo = TestEnumeration::FOO();
    $bar = TestEnumeration::BAR();

    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $foo);
    $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\TestEnumeration', $bar);
    $this->assertSame($foo, TestEnumeration::FOO());
    $this->assertSame($bar, TestEnumeration::BAR());
    $this->assertNotEquals($foo, $bar);
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testCallStaticFailure()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedEnumerationException');
    TestEnumeration::QUX();
  }

  /**
   * @covers Eloquent\Enumeration\Enumeration
   * @group core
   */
  public function testNameAndValue()
  {
    $this->assertSame('FOO', TestEnumeration::FOO()->name());
    $this->assertSame('BAR', TestEnumeration::BAR()->name());
    $this->assertSame(TestEnumeration::FOO, TestEnumeration::FOO()->value());
    $this->assertSame(TestEnumeration::BAR, TestEnumeration::BAR()->value());
  }
}
