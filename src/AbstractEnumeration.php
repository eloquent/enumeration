<?php

namespace Eloquent\Enumeration;

use ReflectionClass;

/**
 * Abstract base class for C++ style enumerations.
 *
 * @api
 */
abstract class AbstractEnumeration extends AbstractValueMultiton implements
    EnumerationInterface
{
    /**
     * Initializes the members of this enumeration based upon its class
     * constants.
     *
     * Each constant becomes a member with a string key equal to the constant's
     * name, and a value equal to that of the constant's value.
     */
    final protected static function initializeMembers()
    {
        $reflector = new ReflectionClass(get_called_class());

        foreach ($reflector->getConstants() as $key => $value) {
            if (self::isPublicConstant($reflector, $key)) {
                new static($key, $value);
            }
        }
    }

    /**
     * Gets a value indicating whether the specified constant name is publicly accessible, according to the specified
     * class reflector.
     *
     * This feature is not supported by all versions of PHP, so a check is performed to see if accessibility detection
     * is available. This result of this check is statically cached so the check only occurs once per script lifetime.
     *
     * @param ReflectionClass $reflector Class reflector.
     * @param string $name Constant name.
     *
     * @return bool True if the constant is public, otherwise false.
     */
    private static function isPublicConstant(ReflectionClass $reflector, $name)
    {
        static $methodExists;
        $methodExists === null && $methodExists = method_exists($reflector, 'getReflectionConstants');

        if (!$methodExists) {
            return true;
        }

        return $reflector->getReflectionConstant($name)->isPublic();
    }
}
