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

/**
 * The interface implemented by exceptions that are thrown when an undefined
 * member is requested.
 */
interface UndefinedMemberExceptionInterface
{
    /**
     * Get the class name.
     *
     * @return string The class name.
     */
    public function className();

    /**
     * Get the property name.
     *
     * @return string The property name.
     */
    public function property();

    /**
     * Get the value of the property used to search for the member.
     *
     * @return mixed The value.
     */
    public function value();
}
