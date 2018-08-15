<?php
declare(strict_types=1);

namespace GraphQLTest\RequestBuilder;

use GraphQL\RequestBuilder\Argument;
use GraphQL\RequestBuilder\ArrayArgument;
use PHPUnit\Framework\TestCase;

/**
 * @author  david.pauli
 * @package GraphQLTest\RequestBuilder
 * @since   15.08.2018
 */
class ArrayArgumentTest extends TestCase
{
    private const ARGUMENT_NAME = 'argumentName';
    private const ARGUMENT_NAME_INNER = 'argumentNameInner';
    private const ARGUMENT_NAME_INNER_2 = 'argumentNameInner2';
    private const ARGUMENT_VALUE_INT_POSITIVE = 2;
    private const ARGUMENT_VALUE_STRING = 'argumentValueString';

    public function testToStringArgumentArray(): void
    {
        $innerArgument = new Argument(self::ARGUMENT_NAME_INNER, self::ARGUMENT_VALUE_STRING);
        $innerArgument2 = new ArrayArgument(self::ARGUMENT_NAME_INNER_2, self::ARGUMENT_VALUE_INT_POSITIVE);

        $argument = new ArrayArgument(self::ARGUMENT_NAME, [$innerArgument, $innerArgument2]);

        static::assertEquals(
            self::ARGUMENT_NAME . ':[{' . self::ARGUMENT_NAME_INNER . ':"' . self::ARGUMENT_VALUE_STRING . '"},{'
            . self::ARGUMENT_NAME_INNER_2 . ':' . self::ARGUMENT_VALUE_INT_POSITIVE . '}]',
            (string) $argument,
            'Setting array of Arguments should return correct string.'
        );
    }
}
