<?php

declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use function is_string;

/**
 * @author david.pauli
 * @since  29.08.2018
 */
class EnumArgument extends Argument
{
    public function __toString(): string
    {
        $value = is_string($this->value) ? '' . $this->value . '' : null;

        return $value === null ? '' : $this->name . ':' . $value;
    }
}
