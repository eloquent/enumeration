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
 * The interface implemented by Java-style enumeration instances.
 *
 * @api
 */
interface MultitonInterface
{
    /**
     * Returns the string key of this member.
     *
     * @api
     *
     * @return string The associated string key of this member.
     */
    public function key();

    /**
     * Check if this member is in the specified list of members.
     *
     * @api
     *
     * @param MultitonInterface $a     The first member to check.
     * @param MultitonInterface $b     The second member to check.
     * @param MultitonInterface $c,... Additional members to check.
     *
     * @return boolean True if this member is in the specified list of members.
     */
    public function anyOf(MultitonInterface $a, MultitonInterface $b);

    /**
     * Check if this member is in the specified list of members.
     *
     * @api
     *
     * @param array<MultitonInterface> $values An array of members to search.
     *
     * @return boolean True if this member is in the specified list of members.
     */
    public function anyOfArray(array $values);

    /**
     * Returns a string representation of this member.
     *
     * @api
     *
     * Unless overridden, this is simply the string key.
     *
     * @return string
     */
    public function __toString();
}
