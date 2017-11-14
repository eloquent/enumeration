# Enumeration

*An enumeration implementation for PHP.*

[![Current version image][version-image]][current version]
[![Current build status image][build-image]][current build status]
[![Current coverage status image][coverage-image]][current coverage status]

[build-image]: http://img.shields.io/travis/eloquent/enumeration/master.svg?style=flat-square "Current build status for the master branch"
[coverage-image]: https://img.shields.io/codecov/c/github/eloquent/enumeration/master.svg?style=flat-square "Current test coverage for the master branch"
[current build status]: https://travis-ci.org/eloquent/enumeration
[current coverage status]: https://codecov.io/github/eloquent/enumeration
[current version]: https://packagist.org/packages/eloquent/enumeration
[version-image]: https://img.shields.io/packagist/v/eloquent/enumeration.svg?style=flat-square "This project uses semantic versioning"

## Installation

- Available as [Composer] package [eloquent/enumeration].

[composer]: http://getcomposer.org/
[eloquent/enumeration]: https://packagist.org/packages/eloquent/enumeration

## What is an Enumeration?

In terms of software development, an enumeration (or "enumerated type") is
essentially a fixed set of values. These values are called "members" or
"elements".

An enumeration is used in circumstances where it is desirable to allow an
argument to be only one of a particular set of values, and where anything else
is considered invalid.

## A basic example

*Enumeration* can be used like [C++ enumerated types]. Here is an example,
representing a set of HTTP request methods:

```php
use Eloquent\Enumeration\AbstractEnumeration;

final class HttpRequestMethod extends AbstractEnumeration
{
    const OPTIONS = 'OPTIONS';
    const GET = 'GET';
    const HEAD = 'HEAD';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';
}
```

This class can now be used in a type hint to easily accept any valid HTTP
request method:

```php
function handleHttpRequest(HttpRequestMethod $method, $url, $body = null)
{
    // handle request...
}
```

[c++ enumerated types]: https://en.wikipedia.org/wiki/Enumerated_type#C.2B.2B

## Accessing enumeration members

Members are accessed by static method calls, like so:

```php
handleHttpRequest(HttpRequestMethod::GET(), 'http://example.org/');
handleHttpRequest(HttpRequestMethod::POST(), 'http://example.org/', 'foo=bar&baz=qux');
```

For each member of the enumeration, a single instance of the enumeration class
is instantiated (that is, an instance of `HttpRequestMethod` in the above
example). This means that strict comparison (===) can be used to determine
which member has been passed to a function:

```php
function handleHttpRequest(HttpRequestMethod $method, $url, $body = null)
{
    if ($method === HttpRequestMethod::POST()) {
        // handle POST requests...
    } else {
        // handle other requests...
    }
}
```

## Java-style enumerations

[Java's enum types] have slightly more functionality than C++ enumerated types.
They can have additional properties and/or methods, and are really just a
specialised kind of class where there are a fixed set of instances.

This is sometimes called the [Multiton] pattern, and in fact, all enumerations
in this implementation are Multitons. The `AbstractEnumeration` class simply
defines its members based upon class constants.

Here is an example borrowed from the Java documentation for its enum types. The
following multiton describes all of the planets in our solar system, including
their masses and radii:

```php
use Eloquent\Enumeration\AbstractMultiton;

final class Planet extends AbstractMultiton
{
    /**
     * Universal gravitational constant.
     *
     * @var float
     */
    const G = 6.67300E-11;

    /**
     * @return float
     */
    public function surfaceGravity()
    {
        return self::G * $this->mass / ($this->radius * $this->radius);
    }

    /**
     * @param float $otherMass
     *
     * @return float
     */
    public function surfaceWeight($otherMass)
    {
        return $otherMass * $this->surfaceGravity();
    }

    protected static function initializeMembers()
    {
        new static('MERCURY', 3.302e23,  2.4397e6);
        new static('VENUS',   4.869e24,  6.0518e6);
        new static('EARTH',   5.9742e24, 6.37814e6);
        new static('MARS',    6.4191e23, 3.3972e6);
        new static('JUPITER', 1.8987e27, 7.1492e7);
        new static('SATURN',  5.6851e26, 6.0268e7);
        new static('URANUS',  8.6849e25, 2.5559e7);
        new static('NEPTUNE', 1.0244e26, 2.4764e7);
        // new static('PLUTO',   1.31e22,   1.180e6);
    }

    /**
     * @param string $key
     * @param float  $mass
     * @param float  $radius
     */
    protected function __construct($key, $mass, $radius)
    {
        parent::__construct($key);

        $this->mass = $mass;
        $this->radius = $radius;
    }

    private $mass;
    private $radius;
}
```

The above class can be used to take a known weight on earth (in any unit) and
calculate the weight on all of the planets (in the same unit):

```php
$earthWeight = 175;
$mass = $earthWeight / Planet::EARTH()->surfaceGravity();

foreach (Planet::members() as $planet) {
    echo sprintf(
        'Your weight on %s is %f' . PHP_EOL,
        $planet,
        $planet->surfaceWeight($mass)
    );
}
```

If the above script is executed, it will produce something like the following
output:

```
Your weight on MERCURY is 66.107480
Your weight on VENUS is 158.422560
Your weight on EARTH is 175.000000
Your weight on MARS is 66.279359
Your weight on JUPITER is 442.677903
Your weight on SATURN is 186.513785
Your weight on URANUS is 158.424919
Your weight on NEPTUNE is 199.055584
```

[java's enum types]: https://en.wikipedia.org/wiki/Enumerated_type#Java
[multiton]: http://en.wikipedia.org/wiki/Multiton_pattern

## Enumerations and class inheritance

When an enumeration is defined, the intent is usually to define a set of valid
values that should not change, at least within the lifetime of a program's
execution.

Since PHP has no in-built support for enumerations, this library implements them
as regular PHP classes. Classes, however, allow for much more extensibility than
is desirable in a true enumeration.

For example, a naive enumeration implementation might allow a developer to
extend the `HttpRequestMethod` class from the examples above (assuming the
`final` keyword is removed):

```php
class CustomHttpMethod extends HttpRequestMethod
{
    const PATCH = 'PATCH';
}
```

The problem with this scenario is that all the code written to expect only the
HTTP methods defined in `HttpRequestMethod` is now compromised. Anybody can
extend `HttpRequestMethod` to add custom values, essentially voiding the reason
for defining `HttpRequestMethod` in the first place.

This library provides built-in protection from these kinds of circumstances.
Attempting to define an enumeration that extends another enumeration will result
in an exception being thrown, unless the 'base' enumeration is abstract.

### Abstract enumerations

Assuming that there really is a need to extend `HttpRequestMethod`, the way to
go about it is to define an abstract base class, then extend this class to
create the desired concrete enumerations:

```php
use Eloquent\Enumeration\AbstractEnumeration;

abstract class AbstractHttpRequestMethod extends AbstractEnumeration
{
    const OPTIONS = 'OPTIONS';
    const GET = 'GET';
    const HEAD = 'HEAD';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';
}

final class HttpRequestMethod extends AbstractHttpRequestMethod {}

final class CustomHttpMethod extends AbstractHttpRequestMethod
{
    const PATCH = 'PATCH';
}
```

In this way, when a developer uses a type hint for `HttpRequestMethod`, there is
no chance they will ever receive the 'PATCH' method:

```php
function handleHttpRequest(HttpRequestMethod $method, $url, $body = null)
{
    // only handles normal requests...
}

function handleCustomHttpRequest(
    CustomHttpRequestMethod $method,
    $url,
    $body = null
) {
    // handles normal requests, and custom requests...
}
```
