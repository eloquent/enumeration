<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

/**
 * The interface implemented by Java-style enumeration instances with a value.
 *
 * @api
 */
interface ValueMultitonInterface extends MultitonInterface
{
    /**
     * Returns the value of this member.
     *
     * @api
     *
     * @return mixed The value of this member.
     */
    public function value();
}
