<?php

namespace Eloquent\Enumeration\Test\Fixture;

class InvalidMultiton extends ValidMultiton
{
    protected static function initializeMembers()
    {
        parent::initializeMembers();

        new static('QUX', 'xuq');
    }
}
