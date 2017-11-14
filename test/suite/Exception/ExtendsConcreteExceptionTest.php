<?php

namespace Eloquent\Enumeration\Exception;

use Exception;
use PHPUnit_Framework_TestCase;

class ExtendsConcreteExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $className = 'foo';
        $parentClass = 'bar';
        $previous = new Exception();
        $exception = new ExtendsConcreteException($className, $parentClass, $previous);
        $expectedMessage = "Class 'foo' cannot extend concrete class 'bar'.";

        $this->assertSame($expectedMessage, $exception->getMessage());
        $this->assertSame($className, $exception->className());
        $this->assertSame($parentClass, $exception->parentClass());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
