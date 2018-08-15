<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

/**
 * This is the root type, the outer container in the request payload.
 *
 * @author  david.pauli
 * @package GraphQL\RequestBuilder
 * @since   15.08.2018
 */
class RootType extends Type
{
    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return '{' . parent::__toString() . '}';
    }
}
