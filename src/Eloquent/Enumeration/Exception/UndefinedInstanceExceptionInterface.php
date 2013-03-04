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
 * Interface used to mark all exceptions thrown when an undefined instance is requested.
 */
interface UndefinedInstanceExceptionInterface
{
    /**
     * @return string
     */
    public function className();

    /**
     * @return string
     */
    public function property();

    /**
     * @return mixed
     */
    public function value();
}
