<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

use Exception;
use PHPUnit_Framework_TestCase;

class UndefinedMemberExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $className = 'foo';
        $property = 'bar';
        $value = 'baz';
        $previous = new Exception;
        $exception = new UndefinedMemberException($className, $property, $value, $previous);
        $expectedMessage = "No member with bar equal to 'baz' defined in class 'foo'.";

        $this->assertSame($expectedMessage, $exception->getMessage());
        $this->assertSame($className, $exception->className());
        $this->assertSame($property, $exception->property());
        $this->assertSame($value, $exception->value());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
