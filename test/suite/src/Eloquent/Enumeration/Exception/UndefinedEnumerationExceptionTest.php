<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

class UndefinedEnumerationExceptionTest extends \Eloquent\Enumeration\Test\TestCase
{
  /**
   * @covers Eloquent\Enumeration\Exception\UndefinedEnumerationException
   * @covers Eloquent\Enumeration\Exception\LogicException
   * @covers Eloquent\Enumeration\Exception\Exception
   * @group exceptions
   * @group core
   */
  public function testException()
  {
    $class = 'foo';
    $name = 'bar';
    $exception = new UndefinedEnumerationException($class, $name);
    $expectedMessage = "No enumeration 'bar' defined in class 'foo'.";

    $this->assertSame($expectedMessage, $exception->getMessage());
  }
}
