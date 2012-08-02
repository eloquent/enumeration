# Enumeration

*An enumeration implementation for PHP.*

## Installation

Enumeration requires PHP 5.3 or later.

### With [Composer](http://getcomposer.org/)

* Add 'eloquent/enumeration' to the project's composer.json dependencies
* Run `php composer.phar install`

### Bare installation

* Clone from GitHub: `git clone git://github.com/eloquent/enumeration.git`
* Use a [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
  compatible autoloader (namespace 'Eloquent\Enumeration' in the 'src'
  directory)

## What is an Enumeration?

In terms of software development, an enumeration (or "enumerated type") is
essentially a fixed set of values. These values are called "members" or
"elements".

An enumeration is used in circumstances where it is desirable to allow an
argument to be only one of a particular set of values, and where anything else
is considered invalid.

## A basic example

Enumeration can be used like [C++ enumerated types](http://www.learncpp.com/cpp-tutorial/45-enumerated-types/).
Here is an example, representing a set of HTTP request methods:

```php
<?php

use Eloquent\Enumeration\Enumeration;

final class HTTPRequestMethod extends Enumeration
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
<?php

function handleHttpRequest(HTTPRequestMethod $method, $url, $body = NULL)
{
  // handle request...
}
```

## Accessing enumeration members

Members are accessed by static method calls, like so:

```php
<?php

handleHttpRequest(HTTPRequestMethod::GET(), 'http://example.org/');
handleHttpRequest(HTTPRequestMethod::POST(), 'http://example.org/', 'foo=bar&baz=qux');
```

For each member of the enumeration, a single instance of the enumeration class
is instantiated (that is, an instance of *HTTPRequestMethod* in the above
example). This means that strict comparison (===) can be used to determine
which member has been passed to a function:

```php
<?php

function handleHttpRequest(HTTPRequestMethod $method, $url, $body = NULL)
{
  if ($method === HTTPRequestMethod::POST())
  {
    // handle POST requests...
  }
  else
  {
    // handle other requests...
  }
}
```

## Java-style enumerations

[Java's enum types](http://docs.oracle.com/javase/tutorial/java/javaOO/enum.html)
have slightly more functionality than C++ enumerated types. They can have
additional properties and/or methods, and are really just a specialised kind of
class where there are a fixed set of instances.

This is sometimes called the [Multiton](http://en.wikipedia.org/wiki/Multiton_pattern)
pattern, and in fact, all enumerations in this implementation are Multitons.
The *Enumeration* class simply defines its members based upon class constants.

Here is an example borrowed from the Java documentation for its enum types. The
following multiton describes all of the planets in our solar system, including
their masses and radii:

```php
<?php

use Eloquent\Enumeration\Multiton;

final class Planet extends Multiton
{
  /**
   * Universal gravitational constant
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

  protected static function initializeMultiton()
  {
    parent::initializeMultiton();

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
   * @param float $mass
   * @param float $radius
   */
  protected function __construct($key, $mass, $radius)
  {
    parent::__construct($key);

    $this->mass = $mass;
    $this->radius = $radius;
  }

  /**
   * @var float
   */
  private $mass;

  /**
   * @var float
   */
  private $radius;
}
```

The above class can be used to take a known weight on earth (in any unit) and
calculate the weight on all of the planets (in the same unit):

```php
<?php

require 'Planet.php';

$earthWeight = 175;
$mass = $earthWeight / Planet::EARTH()->surfaceGravity();

foreach (Planet::multitonInstances() as $planet)
{
  echo sprintf('Your weight on %s is %f' . PHP_EOL, $planet, $planet->surfaceWeight($mass));
}
```

If you run the above script you will get something like the following output:

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

## Code quality

Enumeration strives to attain a high level of quality. A full test suite is
available, and code coverage is closely monitored. All of the above code
examples are also tested.

### Latest revision test suite results
[![Build Status](https://secure.travis-ci.org/eloquent/enumeration.png)](http://travis-ci.org/eloquent/enumeration)

### Latest revision test suite coverage
<http://ci.ezzatron.com/report/enumeration/coverage/>
