<?php

namespace Eloquent\Enumeration;

use Eloquent\Enumeration\Test\Fixture\InvalidValueMultiton;
use Eloquent\Enumeration\Test\Fixture\ValidValueMultiton;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class AbstractValueMultitonTest extends TestCase
{
    protected function setUp()
    {
        ValidValueMultiton::resetCalls();

        $reflector = new ReflectionClass(__NAMESPACE__ . '\AbstractMultiton');
        $membersProperty = $reflector->getProperty('members');
        $membersProperty->setAccessible(true);
        $membersProperty->setValue(null, array());
    }

    // Multiton tests ==========================================================

    public function testMemberByKey()
    {
        $this->assertSame(array(), ValidValueMultiton::calls());

        $foo = ValidValueMultiton::memberByKey('FOO');
        $bar = ValidValueMultiton::memberByKey('BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidValueMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidValueMultiton::memberByKey('BAR'));
        $this->assertSame($foo, ValidValueMultiton::memberByKey('Foo', false));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testMemberByKeyFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberByKey('DOOM');
    }

    public function testMemberByKeyWithDefault()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByKeyWithDefault('FOO'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberByKeyWithDefault('BAR'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByKeyWithDefault('Foo', null, false));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByKeyWithDefault('qux', ValidValueMultiton::FOO()));
        $this->assertNull(ValidValueMultiton::memberByKeyWithDefault('qux'));
    }

    public function testMemberOrNullByKey()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullByKey('FOO'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberOrNullByKey('BAR'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullByKey('Foo', false));
        $this->assertNull(ValidValueMultiton::memberOrNullByKey(null));
    }

    public function testMemberOrNullByKeyFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberOrNullByKey('DOOM');
    }

    public function testMemberBy()
    {
        $this->assertSame(array(), ValidValueMultiton::calls());

        $foo = ValidValueMultiton::memberBy('key', 'FOO');
        $bar = ValidValueMultiton::memberBy('key', 'BAR');

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidValueMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidValueMultiton::memberByKey('BAR'));
        $this->assertSame($foo, ValidValueMultiton::memberBy('key', 'Foo', false));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testMemberByFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberBy('key', 'DOOM');
    }

    public function testMemberByWithDefault()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByWithDefault('key', 'FOO'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberByWithDefault('key', 'BAR'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByWithDefault('key', 'Foo', null, false));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByWithDefault('key', 'qux', ValidValueMultiton::FOO()));
        $this->assertNull(ValidValueMultiton::memberByWithDefault('key', 'qux'));
    }

    public function testMemberOrNullBy()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullBy('key', 'FOO'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberOrNullBy('key', 'BAR'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullBy('key', 'Foo', false));
        $this->assertNull(ValidValueMultiton::memberOrNullBy('key', null));
    }

    public function testMemberOrNullByFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberOrNullBy('key', 'DOOM');
    }

    public function testMemberByPredicate()
    {
        $this->assertSame(array(), ValidValueMultiton::calls());

        $foo = ValidValueMultiton::memberByPredicate(
            function (ValidValueMultiton $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidValueMultiton::memberByPredicate(
            function (ValidValueMultiton $member) {
                return $member->key() === 'BAR';
            }
        );

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidValueMultiton::memberByKey('FOO'));
        $this->assertSame($bar, ValidValueMultiton::memberByKey('BAR'));

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testMemberByPredicateFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberByPredicate(
            function (ValidValueMultiton $member) {
                return false;
            }
        );
    }

    public function testMemberByPredicateWithDefault()
    {
        $foo = ValidValueMultiton::memberByPredicateWithDefault(
            function (ValidValueMultiton $member) {
                return $member->key() === 'FOO';
            }
        );
        $bar = ValidValueMultiton::memberByPredicateWithDefault(
            function (ValidValueMultiton $member) {
                return $member->key() === 'BAR';
            }
        );
        $defaultFoo = ValidValueMultiton::memberByPredicateWithDefault(
            function (ValidValueMultiton $member) {
                return false;
            },
            ValidValueMultiton::FOO()
        );
        $defaultNull = ValidValueMultiton::memberByPredicateWithDefault(
            function (ValidValueMultiton $member) {
                return false;
            }
        );

        $this->assertSame(ValidValueMultiton::FOO(), $foo);
        $this->assertSame(ValidValueMultiton::BAR(), $bar);
        $this->assertSame(ValidValueMultiton::FOO(), $defaultFoo);
        $this->assertNull($defaultNull);
    }

    public function testMembers()
    {
        $this->assertSame(array(
            'FOO' => ValidValueMultiton::FOO(),
            'BAR' => ValidValueMultiton::BAR(),
            'BAZ' => ValidValueMultiton::BAZ(),
        ), ValidValueMultiton::members());
    }

    public function testMembersBy()
    {
        $this->assertSame(array(), ValidValueMultiton::calls());

        $foo = ValidValueMultiton::membersBy('value', 'oof');
        $bar = ValidValueMultiton::membersBy('value', 'RAB', false);

        $this->assertSame(array('FOO' => ValidValueMultiton::FOO()), $foo);
        $this->assertSame(array('BAR' => ValidValueMultiton::BAR()), $bar);

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testMembersByPredicate()
    {
        $this->assertSame(array(), ValidValueMultiton::calls());

        $notBaz = ValidValueMultiton::membersByPredicate(
            function (ValidValueMultiton $member) {
                return $member->key() !== 'BAZ';
            }
        );

        $this->assertSame(
            array(
                'FOO' => ValidValueMultiton::FOO(),
                'BAR' => ValidValueMultiton::BAR(),
            ),
            $notBaz
        );

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testCallStatic()
    {
        $foo = ValidValueMultiton::FOO();
        $bar = ValidValueMultiton::BAR();

        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $foo);
        $this->assertInstanceOf('Eloquent\Enumeration\Test\Fixture\ValidValueMultiton', $bar);
        $this->assertNotEquals($foo, $bar);
        $this->assertSame($foo, ValidValueMultiton::FOO());
        $this->assertSame($bar, ValidValueMultiton::BAR());

        $this->assertSame(array(
            array(
                'Eloquent\Enumeration\Test\Fixture\ValidValueMultiton::initializeMembers',
                array(),
            ),
        ), ValidValueMultiton::calls());
    }

    public function testCallStaticFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::DOOM();
    }

    public function testInstantiationLogic()
    {
        $foo = ValidValueMultiton::FOO();
        $bar = ValidValueMultiton::BAR();

        $this->assertSame('FOO', $foo->key());
        $this->assertSame('BAR', $bar->key());
        $this->assertSame('oof', $foo->value());
        $this->assertSame('rab', $bar->value());
    }

    public function testInheritanceProtection()
    {
        $this->expectException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
        InvalidValueMultiton::BAZ();
    }

    public function testAnyOf()
    {
        $this->assertTrue(ValidValueMultiton::BAR()->anyOf(ValidValueMultiton::FOO(), ValidValueMultiton::BAR()));
        $this->assertFalse(ValidValueMultiton::BAZ()->anyOf(ValidValueMultiton::FOO(), ValidValueMultiton::BAR()));
    }

    public function testAnyOfArray()
    {
        $array = array(ValidValueMultiton::FOO(), ValidValueMultiton::BAR());
        $this->assertTrue(ValidValueMultiton::BAR()->anyOfArray($array));
        $this->assertFalse(ValidValueMultiton::BAZ()->anyOfArray($array));
    }

    public function testToString()
    {
        $foo = ValidValueMultiton::FOO();
        $bar = ValidValueMultiton::BAR();

        $this->assertSame($foo->key(), (string) $foo);
        $this->assertSame($bar->key(), (string) $bar);
    }

    // Value multiton tests ====================================================

    public function testMemberByValue()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByValue('oof'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberByValue('rab'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByValue('Oof', false));
    }

    public function testMemberByValueFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberByValue('mood');
    }

    public function testMemberByValueWithDefault()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByValueWithDefault('oof'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberByValueWithDefault('rab'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberByValueWithDefault('Oof', null, false));
        $this->assertSame(
            ValidValueMultiton::FOO(),
            ValidValueMultiton::memberByValueWithDefault('qux', ValidValueMultiton::FOO())
        );
        $this->assertNull(ValidValueMultiton::memberByValueWithDefault('qux'));
    }

    public function testMemberOrNullByValue()
    {
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullByValue('oof'));
        $this->assertSame(ValidValueMultiton::BAR(), ValidValueMultiton::memberOrNullByValue('rab'));
        $this->assertSame(ValidValueMultiton::FOO(), ValidValueMultiton::memberOrNullByValue('Oof', false));
        $this->assertNull(ValidValueMultiton::memberOrNullByValue(null));
    }

    public function testMemberOrNullByValueFailureUndefined()
    {
        $this->expectException('Eloquent\Enumeration\Exception\UndefinedMemberException');
        ValidValueMultiton::memberOrNullByValue('mood');
    }

    public function testMembersByValue()
    {
        $this->assertSame(array('FOO' => ValidValueMultiton::FOO()), ValidValueMultiton::membersByValue('oof'));
        $this->assertSame(array('BAR' => ValidValueMultiton::BAR()), ValidValueMultiton::membersByValue('rab'));
        $this->assertSame(array('FOO' => ValidValueMultiton::FOO()), ValidValueMultiton::membersByValue('Oof', false));
    }
}
