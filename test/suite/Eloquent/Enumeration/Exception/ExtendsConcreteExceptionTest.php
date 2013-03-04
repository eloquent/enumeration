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

class ExtendsConcreteExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $className = 'foo';
        $parentClass = 'bar';
        $previous = new Exception;
        $exception = new ExtendsConcreteException($className, $parentClass, $previous);
        $expectedMessage = "Class 'foo' cannot extend concrete class 'bar'.";

        $this->assertSame($expectedMessage, $exception->getMessage());
        $this->assertSame($className, $exception->className());
        $this->assertSame($parentClass, $exception->parentClass());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
