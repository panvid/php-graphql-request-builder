<?php
declare(strict_types=1);

namespace GraphQLTest\RequestBuilder;

use GraphQL\RequestBuilder\RootType;
use PHPUnit\Framework\TestCase;

/**
 * @author  david.pauli
 * @package GraphQLTest\RequestBuilder
 * @since   15.08.2018
 */
class RootTypeTest extends TestCase
{
    private const TYPE_NAME = 'typeName';

    public function testToString(): void
    {
        $type = new RootType(self::TYPE_NAME);

        static::assertEquals(
            '{' . self::TYPE_NAME . '}',
            (string) $type,
            'Root types need to have brackets around himself'
        );
    }
}
