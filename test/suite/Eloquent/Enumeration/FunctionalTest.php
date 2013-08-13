<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic setup of HttpRequestMethod class.
     */
    public function testHttpRequestMethodSetup()
    {
        $expected = array(
            'OPTIONS' => HttpRequestMethod::OPTIONS(),
            'GET' => HttpRequestMethod::GET(),
            'HEAD' => HttpRequestMethod::HEAD(),
            'POST' => HttpRequestMethod::POST(),
            'PUT' => HttpRequestMethod::PUT(),
            'DELETE' => HttpRequestMethod::DELETE(),
            'TRACE' => HttpRequestMethod::TRACE(),
            'CONNECT' => HttpRequestMethod::CONNECT(),
        );

        $this->assertSame($expected, HttpRequestMethod::members());
    }

    /**
     * Test the following statement:
     *
     * "[The HttpRequestMethod class] can now be used in a type hint to easily
     *  accept any valid HTTP request method."
     */
    public function testHttpRequestMethodAcceptAll()
    {
        $passedMethods = array();
        $handleHttpRequest = function(HttpRequestMethod $method, $url, $body) use (&$passedMethods) {
            $passedMethods[] = $method;
        };
        $handleHttpRequest(HttpRequestMethod::OPTIONS(), 'http://example.org/', null);
        $handleHttpRequest(HttpRequestMethod::GET(), 'http://example.org/', null);
        $handleHttpRequest(HttpRequestMethod::HEAD(), 'http://example.org/', null);
        $handleHttpRequest(HttpRequestMethod::POST(), 'http://example.org/', 'foo');
        $handleHttpRequest(HttpRequestMethod::PUT(), 'http://example.org/', 'foo');
        $handleHttpRequest(HttpRequestMethod::DELETE(), 'http://example.org/', null);
        $handleHttpRequest(HttpRequestMethod::TRACE(), 'http://example.org/', null);
        $handleHttpRequest(HttpRequestMethod::CONNECT(), 'http://example.org/', null);
        $expected = array(
            HttpRequestMethod::OPTIONS(),
            HttpRequestMethod::GET(),
            HttpRequestMethod::HEAD(),
            HttpRequestMethod::POST(),
            HttpRequestMethod::PUT(),
            HttpRequestMethod::DELETE(),
            HttpRequestMethod::TRACE(),
            HttpRequestMethod::CONNECT(),
        );

        $this->assertSame($expected, $passedMethods);
    }

    /**
     * Test the following statement:
     *
     * "[The fact that enumeration members are singleton instances] means that
     *  strict comparison (===) can be used to determine which member has been
     *  passed to a function"
     */
    public function testHttpRequestMethodStrictComparison()
    {
        $get = HttpRequestMethod::GET();
        $post = HttpRequestMethod::POST();

        $this->assertTrue($get === HttpRequestMethod::GET());
        $this->assertTrue($post === HttpRequestMethod::POST());
        $this->assertFalse($get === HttpRequestMethod::POST());
        $this->assertFalse($post === HttpRequestMethod::GET());
        $this->assertFalse($get === $post);
    }

    /**
     * Test basic setup of Planet class.
     */
    public function testPlanetSetup()
    {
        $expected = array(
            'MERCURY' => Planet::MERCURY(),
            'VENUS' => Planet::VENUS(),
            'EARTH' => Planet::EARTH(),
            'MARS' => Planet::MARS(),
            'JUPITER' => Planet::JUPITER(),
            'SATURN' => Planet::SATURN(),
            'URANUS' => Planet::URANUS(),
            'NEPTUNE' => Planet::NEPTUNE(),
        );

        $this->assertSame($expected, Planet::members());
    }

    /**
     * Test output from the example script for the Planet class.
     */
    public function testPlanetExampleScriptOutput()
    {
        ob_start();
        $earthWeight = 175;
        $mass = $earthWeight / Planet::EARTH()->surfaceGravity();

        foreach (Planet::members() as $planet) {
            // modified slightly to avoid floating point precision issues causing failing test
            echo sprintf(
                'Your weight on %s is %0.0f' . PHP_EOL,
                $planet,
                $planet->surfaceWeight($mass)
            );
        }
        $actual = ob_get_clean();
        $expected =
            'Your weight on MERCURY is 66' . PHP_EOL
            . 'Your weight on VENUS is 158' . PHP_EOL
            . 'Your weight on EARTH is 175' . PHP_EOL
            . 'Your weight on MARS is 66' . PHP_EOL
            . 'Your weight on JUPITER is 443' . PHP_EOL
            . 'Your weight on SATURN is 187' . PHP_EOL
            . 'Your weight on URANUS is 158' . PHP_EOL
            . 'Your weight on NEPTUNE is 199' . PHP_EOL
        ;

        $this->assertSame($expected, $actual);
    }
}
