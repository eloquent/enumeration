<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

/**
 * Abstract base class for Java-style enumerations with a value.
 */
abstract class AbstractValueMultiton extends AbstractMultiton implements
    ValueMultitonInterface
{
    /**
     * Returns a single member by value.
     *
     * @param scalar       $value           The value associated with the member.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return ValueMultitonInterface             The first member with the supplied value.
     * @throws Exception\UndefinedMemberException If no associated member is found.
     */
    final public static function memberByValue($value, $isCaseSensitive = null)
    {
        return static::memberBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns a single member by value. Additionally returns a default if no
     * associated member is found.
     *
     * @param scalar                      $value           The value associated with the member.
     * @param ValueMultitonInterface|null $default         The default value to return.
     * @param boolean|null                $isCaseSensitive True if the search should be case sensitive.
     *
     * @return ValueMultitonInterface The first member with the supplied value, or the default value.
     */
    final public static function memberByValueWithDefault(
        $value,
        ValueMultitonInterface $default = null,
        $isCaseSensitive = null
    ) {
        return static::memberByWithDefault(
            'value',
            $value,
            $default,
            $isCaseSensitive
        );
    }

    /**
     * Returns a single member by value. Additionally returns null if the
     * supplied value is null.
     *
     * @param scalar|null  $value           The value associated with the member, or null.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return ValueMultitonInterface|null        The first member with the supplied value, or null if the supplied value is null.
     * @throws Exception\UndefinedMemberException If no associated member is found.
     */
    final public static function memberOrNullByValue(
        $value,
        $isCaseSensitive = null
    ) {
        return static::memberOrNullBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns a set of members matching the supplied value.
     *
     * @param scalar       $value           The value associated with the members.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return array<string,ValueMultitonInterface> All members with the supplied value.
     */
    final public static function membersByValue($value, $isCaseSensitive = null)
    {
        return static::membersBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns the value of this member.
     *
     * @return scalar The value of this member.
     */
    final public function value()
    {
        return $this->value;
    }

    /**
     * Construct and register a new value multiton member.
     *
     * @param string $key   The string key to associate with this member.
     * @param scalar $value The value of this member.
     *
     * @throws Exception\ExtendsConcreteException If the constructed member has an invalid inheritance hierarchy.
     */
    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->value = $value;
    }

    private $value;
}
