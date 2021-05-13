<?php

declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use GraphQL\RequestBuilder\Interfaces\ArgumentInterface;
use GraphQL\RequestBuilder\Interfaces\TypeInterface;

use function is_string;

/**
 * Implementation of the GraphQL type.
 *
 * @author David Pauli
 * @since  14.08.2018
 */
class Type implements TypeInterface
{
    /** @var string The name of the type. */
    private string $name;

    /** @var ArgumentInterface[] Defined parameters to request the resource. */
    private array $arguments = [];

    /** @var TypeInterface[] Expected types in responses. */
    private array $types = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addArgument(ArgumentInterface $argument): TypeInterface
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    public function addArguments(array $arguments): TypeInterface
    {
        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }
        return $this;
    }

    public function addSubType($type): TypeInterface
    {
        if (is_string($type)) {
            $this->types[$type] = new Type($type);
        } else {
            $this->types[$type->getName()] = $type;
        }
        return $this;
    }

    public function addSubTypes(array $types): TypeInterface
    {
        foreach ($types as $type) {
            $this->addSubType($type);
        }
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        $returnString = $this->name;
        // add arguments
        $returnString .= empty($this->arguments) ? '' : '(' . implode(',', $this->arguments) . ')';
        // add others types
        $returnString .= empty($this->types) ? '' : '{' . implode(',', $this->types) . '}';
        return $returnString;
    }
}
