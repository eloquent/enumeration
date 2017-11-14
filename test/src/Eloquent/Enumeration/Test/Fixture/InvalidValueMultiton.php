<?php

namespace Eloquent\Enumeration\Test\Fixture;

class InvalidValueMultiton extends ValidValueMultiton
{
    protected static function initializeMembers()
    {
        parent::initializeMembers();

        new static('QUX', 'xuq');
    }
}
