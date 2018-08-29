<?php
declare(strict_types=1);

namespace GraphQLTest\RequestBuilder;

use GraphQL\RequestBuilder\EnumArgument;
use PHPUnit\Framework\TestCase;

/**
 * @author  david.pauli
 * @package GraphQLTest\RequestBuilder
 * @since   29.08.2018
 */
class EnumArgumentTest extends TestCase
{
    private const ARGUMENT_NAME = 'argumentName';
    private const ENUM_VALUE = 'enumValue';

    public function testToStringEnum(): void
    {
        $argument = new EnumArgument(self::ARGUMENT_NAME, self::ENUM_VALUE);

        static::assertEquals(
            self::ARGUMENT_NAME . ':' . self::ENUM_VALUE,
            (string) $argument,
            'Enum should be correct created.'
        );
    }
}
