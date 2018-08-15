<?php
declare(strict_types=1);

namespace GraphQLTest\RequestBuilder;

use Exception;
use GraphQL\RequestBuilder\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @author  David Pauli
 * @package GraphQLTest\RequestBuilder
 * @since   14.08.2018
 */
class ArgumentTest extends TestCase
{
    private const ARGUMENT_NAME = 'argumentName';
    private const ARGUMENT_NAME_INNER = 'argumentNameInner';
    private const ARGUMENT_NAME_INNER_2 = 'argumentNameInner2';
    private const ARGUMENT_VALUE_INT_POSITIVE = 2;
    private const ARGUMENT_VALUE_INT_ZERO = 0;
    private const ARGUMENT_VALUE_INT_NEGATIVE = -2;
    private const ARGUMENT_VALUE_FLOAT_POSITIVE = 1.23;
    private const ARGUMENT_VALUE_FLOAT_ZERO = 0.0;
    private const ARGUMENT_VALUE_FLOAT_NEGATIVE = -1.23;
    private const ARGUMENT_VALUE_STRING = 'argumentValueString';
    private const ARGUMENT_VALUE_STRING_EMPTY = '';
    private const ARGUMENT_VALUE_BOOL_TRUE = true;
    private const ARGUMENT_VALUE_BOOL_FALSE = false;

    public function testGetName(): void
    {
        $argument = new Argument(self::ARGUMENT_NAME, 'value');

        static::assertEquals(self::ARGUMENT_NAME, $argument->getName(), 'Constructed name should be set.');
    }

    /**
     * @dataProvider givenScalarValue()
     * @param        $argumentValue
     * @param string $expectedString
     * @param string $message
     */
    public function testToStringScalar($argumentValue, string $expectedString, string $message): void
    {
        $argument = new Argument(self::ARGUMENT_NAME, $argumentValue);

        static::assertEquals($expectedString, (string) $argument, $message);
    }

    public function testToStringArray(): void
    {
        $innerArgument = new Argument(self::ARGUMENT_NAME_INNER, self::ARGUMENT_VALUE_STRING);
        $innerArgument2 = new Argument(self::ARGUMENT_NAME_INNER_2, self::ARGUMENT_VALUE_INT_POSITIVE);

        $argument = new Argument(self::ARGUMENT_NAME, [$innerArgument, $innerArgument2]);

        static::assertEquals(
            self::ARGUMENT_NAME . ':{' . self::ARGUMENT_NAME_INNER . ':"' . self::ARGUMENT_VALUE_STRING . '",'
                . self::ARGUMENT_NAME_INNER_2 . ':' . self::ARGUMENT_VALUE_INT_POSITIVE . '}',
            (string) $argument,
            'Setting array of Arguments should return correct string.'
        );
    }

    public function testToStringObject(): void
    {
        $innerArgument = new Argument(self::ARGUMENT_NAME_INNER, self::ARGUMENT_VALUE_STRING);

        $argument = new Argument(self::ARGUMENT_NAME, $innerArgument);

        static::assertEquals(
            self::ARGUMENT_NAME . ':{' . self::ARGUMENT_NAME_INNER . ':"' . self::ARGUMENT_VALUE_STRING . '"}',
            (string) $argument,
            'Setting Argument should return correct string.'
        );
    }

    /**
     * @return array[]
     */
    public function givenScalarValue(): array
    {
        return [
            [
                self::ARGUMENT_VALUE_INT_POSITIVE,
                self::ARGUMENT_NAME . ':' . self::ARGUMENT_VALUE_INT_POSITIVE . '',
                'Setting positive int should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_INT_NEGATIVE,
                self::ARGUMENT_NAME . ':' . self::ARGUMENT_VALUE_INT_NEGATIVE . '',
                'Setting negative int should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_FLOAT_POSITIVE,
                self::ARGUMENT_NAME . ':' . self::ARGUMENT_VALUE_FLOAT_POSITIVE . '',
                'Setting positive float should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_FLOAT_NEGATIVE,
                self::ARGUMENT_NAME . ':' . self::ARGUMENT_VALUE_FLOAT_NEGATIVE . '',
                'Setting negative float should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_STRING,
                self::ARGUMENT_NAME . ':"' . self::ARGUMENT_VALUE_STRING . '"',
                'Setting string should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_STRING_EMPTY,
                self::ARGUMENT_NAME . ':""',
                'Setting empty string should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_BOOL_TRUE,
                self::ARGUMENT_NAME . ':true',
                'Setting true bool should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_BOOL_FALSE,
                self::ARGUMENT_NAME . ':false',
                'Setting false bool should generate correct string.'
            ],
            [
                new Exception(),
                '',
                'Setting wrong type should generate empty string.'
            ],
            [
                self::ARGUMENT_VALUE_INT_ZERO,
                self::ARGUMENT_NAME . ':0',
                'Setting zero int should generate correct string.'
            ],
            [
                self::ARGUMENT_VALUE_FLOAT_ZERO,
                self::ARGUMENT_NAME . ':0',
                'Setting zero float should generate correct string.'
            ]
        ];
    }
}
