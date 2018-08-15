<?php
declare(strict_types=1);

namespace GraphQLTest\RequestBuilder;

use GraphQL\RequestBuilder\Argument;
use GraphQL\RequestBuilder\Type;
use PHPUnit\Framework\TestCase;

/**
 * @author  David Pauli
 * @package GraphQLTest\RequestBuilder
 * @since   14.08.2018
 */
class TypeTest extends TestCase
{
    private const TYPE_NAME = 'typeName';
    private const ARGUMENT_NAME = 'argumentName';
    private const ARGUMENT_VALUE = 'argumentValue';
    private const ARGUMENT_NAME_2 = 'argumentName2';
    private const ARGUMENT_VALUE_2 = 'argumentValue2';

    public function testGetName(): void
    {
        $type = new Type(self::TYPE_NAME);

        static::assertEquals(self::TYPE_NAME, $type->getName(), 'Setting name should work.');
    }

    public function testAddArgument(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);
        $argument = new Argument(self::ARGUMENT_NAME, self::ARGUMENT_VALUE);
        
        $type->addArgument($argument);
        $typeTwice->addArgument($argument)->addArgument($argument);

        static::assertEquals(
            self::TYPE_NAME . '(' . self::ARGUMENT_NAME . ':"' . self::ARGUMENT_VALUE . '")',
            (string) $type,
            'Setting a argument should create correct string.'
        );
        static::assertEquals((string) $type, (string) $typeTwice, 'Add item twice will create same string.');
    }

    public function testAddArguments(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);
        $argument = new Argument(self::ARGUMENT_NAME, self::ARGUMENT_VALUE);
        $argument2 = new Argument(self::ARGUMENT_NAME_2, self::ARGUMENT_VALUE_2);

        $type->addArguments([$argument, $argument2]);
        $typeTwice->addArgument($argument)->addArgument($argument2);

        static::assertEquals(
            self::TYPE_NAME . '(' . self::ARGUMENT_NAME . ':"' . self::ARGUMENT_VALUE . '",' . self::ARGUMENT_NAME_2
                . ':"' . self::ARGUMENT_VALUE_2 . '")',
            (string) $type,
            'Setting array with multiple arguments should return correct string.'
        );
        static::assertEquals((string) $type, (string) $typeTwice, 'Add items in single steps will create same string.');
    }

    public function testAddSubType(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);
        $addType = new Type(self::ARGUMENT_NAME);

        $type->addSubType($addType);
        $typeTwice->addSubType($addType)->addSubType($addType);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . '}',
            (string) $type,
            'Setting a subtype should create correct string.'
        );
        static::assertEquals(
            (string) $type,
            (string) $typeTwice,
            'Add item with subtype twice will create same string.'
        );
    }

    public function testAddSubTypeString(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);

        $type->addSubType(self::ARGUMENT_NAME);
        $typeTwice->addSubType(self::ARGUMENT_NAME)->addSubType(self::ARGUMENT_NAME);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . '}',
            (string) $type,
            'Setting a subtype as string should create correct string.'
        );
        static::assertEquals(
            (string) $type,
            (string) $typeTwice,
            'Add item with subtype as string twice will create same string.'
        );
    }

    public function testAddSubTypes(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);
        $addType = new Type(self::ARGUMENT_NAME);
        $addType2 = new Type(self::ARGUMENT_NAME_2);

        $type->addSubTypes([$addType, $addType2]);
        $typeTwice->addSubType($addType)->addSubType($addType2);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . ',' . self::ARGUMENT_NAME_2 . '}',
            (string) $type,
            'Setting array with multiple sub types should return correct string.'
        );
        static::assertEquals(
            (string) $type,
            (string) $typeTwice,
            'Add sub types in single steps will create same string.'
        );
    }

    public function testAddSubTypesAsString(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);

        $type->addSubTypes([self::ARGUMENT_NAME, self::ARGUMENT_NAME_2]);
        $typeTwice->addSubType(self::ARGUMENT_NAME)->addSubType(self::ARGUMENT_NAME_2);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . ',' . self::ARGUMENT_NAME_2 . '}',
            (string) $type,
            'Setting array with multiple sub types as string should return correct string.'
        );
        static::assertEquals(
            (string) $type,
            (string) $typeTwice,
            'Add sub types in single steps as string will create same string.'
        );
    }

    public function testAddSubTypesAsStringAndType(): void
    {
        $type = new Type(self::TYPE_NAME);
        $typeTwice = new Type(self::TYPE_NAME);
        $addType = new Type(self::ARGUMENT_NAME);

        $type->addSubTypes([$addType, self::ARGUMENT_NAME_2]);
        $typeTwice->addSubType($addType)->addSubType(self::ARGUMENT_NAME_2);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . ',' . self::ARGUMENT_NAME_2 . '}',
            (string) $type,
            'Setting array with multiple sub types as string should return correct string.'
        );
        static::assertEquals(
            (string) $type,
            (string) $typeTwice,
            'Add sub types in single steps as string will create same string.'
        );
    }

    public function testAddComplexSubTypes(): void
    {
        $type = new Type(self::TYPE_NAME);
        $addType = (new Type(self::ARGUMENT_NAME))->addSubType(new Type(self::ARGUMENT_NAME_2));

        $type->addSubType($addType);

        static::assertEquals(
            self::TYPE_NAME . '{' . self::ARGUMENT_NAME . '{' . self::ARGUMENT_NAME_2 . '}}',
            (string) $type,
            'Setting sub type with sub sub type should return correct string.'
        );
    }

    public function testAddArgumentAndSubType(): void
    {
        $type = new Type(self::TYPE_NAME);
        $addType = new Type(self::ARGUMENT_NAME);
        $argument = new Argument(self::ARGUMENT_NAME_2, self::ARGUMENT_VALUE);

        $type->addSubType($addType)->addArgument($argument);

        static::assertEquals(
            self::TYPE_NAME . '(' . self::ARGUMENT_NAME_2. ':"' . self::ARGUMENT_VALUE . '"){' . self::ARGUMENT_NAME
                . '}',
            (string) $type,
            'Setting sub type and argument should return correct string.'
        );
    }
}
