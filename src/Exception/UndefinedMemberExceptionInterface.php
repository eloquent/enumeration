<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

/**
 * The interface implemented by exceptions that are thrown when an undefined
 * member is requested.
 *
 * @api
 */
interface UndefinedMemberExceptionInterface
{
    /**
     * Get the class name.
     *
     * @api
     *
     * @return string The class name.
     */
    public function className();

    /**
     * Get the property name.
     *
     * @api
     *
     * @return string The property name.
     */
    public function property();

    /**
     * Get the value of the property used to search for the member.
     *
     * @api
     *
     * @return mixed The value.
     */
    public function value();
}
