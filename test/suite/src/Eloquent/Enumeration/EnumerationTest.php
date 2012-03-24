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
  public function testCallStaticFailure()
  {
    $this->setExpectedException('Eloquent\Enumeration\Exception\UndefinedEnumerationException');
    TestEnumeration::QUX();
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
  public function testNameAndValue()
  {
    $this->assertSame('FOO', TestEnumeration::FOO()->name());
    $this->assertSame('BAR', TestEnumeration::BAR()->name());
    $this->assertSame(TestEnumeration::FOO, TestEnumeration::FOO()->value());
    $this->assertSame(TestEnumeration::BAR, TestEnumeration::BAR()->value());
  }
}
