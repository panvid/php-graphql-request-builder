<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

/**
 * @author  david.pauli
 * @package GraphQL\RequestBuilder
 * @since   29.08.2018
 */
class EnumArgument extends Argument
{
    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        switch (gettype($this->value)) {
            case 'string':
                $value = '' . $this->value . '';
                break;
            default:
                $value =  null;
        }

        return $value === null ? '': $this->name . ':' . $value;
    }
}
