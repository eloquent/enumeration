<?php

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
