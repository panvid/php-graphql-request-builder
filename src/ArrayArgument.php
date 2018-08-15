<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

/**
 * @author  david.pauli
 * @package GraphQLTest\RequestBuilder
 * @since   15.08.2018
 */
class ArrayArgument extends Argument
{
    /**
     * @param  Argument[] $values
     * @return string|null
     */
    protected function buildStringFromArray(array $values): ?string
    {
        $returnArray = [];
        foreach ($values as $value) {
            $returnArray[] = '{' . (string) $value . '}';
        }
        return '[' . implode(',', $returnArray) . ']';
    }
}
