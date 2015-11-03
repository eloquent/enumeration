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

use Exception;

/**
 * The requested member was not found.
 */
final class UndefinedMemberException extends AbstractUndefinedMemberException
{
    /**
     * Construct a new undefined member exception.
     *
     * @param string         $className The name of the class from which the member was requested.
     * @param string         $property  The name of the property used to search for the member.
     * @param mixed          $value     The value of the property used to search for the member.
     * @param Exception|null $cause     The cause, if available.
     */
    public function __construct(
        $className,
        $property,
        $value,
        Exception $cause = null
    ) {
        parent::__construct(
            sprintf(
                'No member with %s equal to %s defined in class %s.',
                $property,
                var_export($value, true),
                var_export($className, true)
            ),
            $className,
            $property,
            $value,
            $cause
        );
    }
}
