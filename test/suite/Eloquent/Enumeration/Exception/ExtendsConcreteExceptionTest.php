<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

class ExtendsConcreteExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Eloquent\Enumeration\Exception\ExtendsConcreteException
     * @covers Eloquent\Enumeration\Exception\LogicException
     * @covers Eloquent\Enumeration\Exception\Exception
     * @group exceptions
     * @group core
     */
    public function testException()
    {
        $class = 'foo';
        $parentClass = 'bar';
        $exception = new ExtendsConcreteException($class, $parentClass);
        $expectedMessage = "Class 'foo' cannot extend concrete class 'bar'.";

        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}
