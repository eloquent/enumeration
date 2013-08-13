<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use Exception as NativeException;
use ReflectionObject;

/**
 * Base class for Java-style enumerations.
 */
abstract class Multiton
{
    /**
     * Returns an array of all members in this multiton.
     *
     * @return array<string,Multiton> All members.
     */
    final public static function members()
    {
        $class = get_called_class();
        if (!array_key_exists($class, self::$members)) {
            self::$members[$class] = array();
            static::initializeMembers();
        }

        return self::$members[$class];
    }

    /**
     * Returns a single member by string key.
     *
     * @param string       $key             The string key associated with the member.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Multiton                                    The member associated with the given string key.
     * @throws Exception\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberByKey($key, $isCaseSensitive = null)
    {
        return static::memberBy('key', $key, $isCaseSensitive);
    }

    /**
     * Returns a single member by string key. Additionally returns a default if
     * no associated member is found.
     *
     * @param string        $key             The string key associated with the member.
     * @param Multiton|null $default         The default value to return.
     * @param boolean|null  $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Multiton The member associated with the given string key, or the default value.
     */
    final public static function memberByKeyWithDefault(
        $key,
        Multiton $default = null,
        $isCaseSensitive = null
    ) {
        return static::memberByWithDefault(
            'key',
            $key,
            $default,
            $isCaseSensitive
        );
    }

    /**
     * Returns a single member by comparison with the result of an accessor
     * method.
     *
     * @param string       $property        The name of the property (accessor method) to match.
     * @param mixed        $value           The value to match.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Multiton                                    The first member for which $member->{$property}() === $value.
     * @throws Exception\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberBy(
        $property,
        $value,
        $isCaseSensitive = null
    ) {
        $member = static::memberByWithDefault(
            $property,
            $value,
            null,
            $isCaseSensitive
        );
        if (null === $member) {
            throw static::createUndefinedMemberException(
                get_called_class(),
                $property,
                $value
            );
        }

        return $member;
    }

    /**
     * Returns a single member by comparison with the result of an accessor
     * method. Additionally returns a default if no associated member is found.
     *
     * @param string        $property        The name of the property (accessor method) to match.
     * @param mixed         $value           The value to match.
     * @param Multiton|null $default         The default value to return.
     * @param boolean|null  $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Multiton|null The first member for which $member->{$property}() === $value, or the default value.
     */
    final public static function memberByWithDefault(
        $property,
        $value,
        Multiton $default = null,
        $isCaseSensitive = null
    ) {
        if (null === $isCaseSensitive) {
            $isCaseSensitive = true;
        }
        if (!$isCaseSensitive && is_scalar($value)) {
            $value = strtoupper(strval($value));
        }

        return static::memberByPredicateWithDefault(
            function (Multiton $member) use (
                $property,
                $value,
                $isCaseSensitive
            ) {
                $memberValue = $member->{$property}();
                if (!$isCaseSensitive && is_scalar($memberValue)) {
                    $memberValue = strtoupper(strval($memberValue));
                }

                return $memberValue === $value;
            },
            $default
        );
    }

    /**
     * Returns a single member by predicate callback.
     *
     * @param callback $predicate The predicate applies to the member to find a match.
     *
     * @return Multiton                                    The first member for which $predicate($member) evaluates to boolean true.
     * @throws Exception\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberByPredicate($predicate)
    {
        $member = static::memberByPredicateWithDefault($predicate);
        if (null === $member) {
            throw static::createUndefinedMemberException(
                get_called_class(),
                '<callback>',
                '<callback>'
            );
        }

        return $member;
    }

    /**
     * Returns a single member by predicate callback. Additionally returns a
     * default if no associated member is found.
     *
     * @param callback      $predicate The predicate applies to the member to find a match.
     * @param Multiton|null $default   The default value to return.
     *
     * @return Multiton The first member for which $predicate($member) evaluates to boolean true, or the default value.
     */
    final public static function memberByPredicateWithDefault(
        $predicate,
        Multiton $default = null
    ) {
        foreach (static::members() as $member) {
            if ($predicate($member)) {
                return $member;
            }
        }

        return $default;
    }

    /**
     * Maps static method calls to members.
     *
     * @param string $key       The string key associated with the member.
     * @param array  $arguments Ignored.
     *
     * @return Multiton                                    The member associated with the given string key.
     * @throws Exception\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function __callStatic($key, array $arguments)
    {
        return static::memberByKey($key);
    }

    /**
     * Returns the string key of this member.
     *
     * @return string The associated string key of this member.
     */
    final public function key()
    {
        return $this->key;
    }

    /**
     * Check if this member is in the specified list of members.
     *
     * @param Multiton $a     The first member to check.
     * @param Multiton $b     The second member to check.
     * @param Multiton $c,... Additional members to check.
     *
     * @return boolean True if this member is in the specified list of members.
     */
    final public function anyOf(Multiton $a, Multiton $b)
    {
        return $this->anyOfArray(func_get_args());
    }

    /**
     * Check if this member is in the specified list of members.
     *
     * @param array<Multiton> $values An array of members to search.
     *
     * @return boolean True if this member is in the specified list of members.
     */
    final public function anyOfArray(array $values)
    {
        return in_array($this, $values, true);
    }

    /**
     * Returns a string representation of this member.
     *
     * Unless overridden, this is simply the string key.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->key();
    }

    /**
     * Override this method in child classes to implement one-time
     * initialization for a multiton class.
     *
     * This method is called the first time the members of a multiton are
     * accessed. It is called via late static binding, and hence can be
     * overridden in child classes.
     */
    protected static function initializeMembers() {}

    /**
     * Override this method in child classes to implement custom undefined
     * member exceptions for a multiton class.
     *
     * @param string               $className
     * @param string               $property
     * @param mixed                $value
     * @param NativeException|null $previous
     *
     * @return UndefinedMemberExceptionInterface
     */
    protected static function createUndefinedMemberException(
        $className,
        $property,
        $value,
        NativeException $previous = null
    ) {
        return new Exception\UndefinedMemberException(
            $className,
            $property,
            $value,
            $previous
        );
    }

    /**
     * Construct and register a new multiton member.
     *
     * If you override the constructor in a child class, you MUST call the parent
     * constructor. Calling this constructor is the only way to set the string
     * key for this member, and to ensure that the member is correctly
     * registered.
     *
     * @param string $key The string key to associate with this member.
     *
     * @throws Exception\ExtendsConcreteException If the constructed member has an invalid inheritance hierarchy.
     */
    protected function __construct($key)
    {
        $this->key = $key;

        self::registerMember($this);
    }

    /**
     * Registers the supplied member.
     *
     * Do not attempt to call this method directly. Instead, ensure that
     * Multiton::__construct() is called from any child classes, as this will
     * also handle registration of the member.
     *
     * @param  Multiton                           $member The member to register.
     * @throws Exception\ExtendsConcreteException If the supplied member has an invalid inheritance hierarchy.
     */
    private static function registerMember(self $member)
    {
        $reflector = new ReflectionObject($member);
        $parentClass = $reflector->getParentClass();
        if (!$parentClass->isAbstract()) {
            throw new Exception\ExtendsConcreteException(
                get_class($member),
                $parentClass->getName()
            );
        }

        self::$members[get_called_class()][$member->key()] = $member;
    }

    /**
     * Array of all members of all multiton and enumeration classes.
     *
     * Members are keyed by class name and member key string.
     *
     * @var array<string,array<string,Multiton>>
     */
    private static $members = array();

    /**
     * String key associated with this member.
     *
     * @var string
     */
    private $key;
}
