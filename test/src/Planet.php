<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    protected static function initializeMembers()
    {
        parent::initializeMembers();

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

    /**
     * @var float
     */
    private $mass;

    /**
     * @var float
     */
    private $radius;
}
