<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use GraphQL\RequestBuilder\Interfaces\ArgumentInterface;
use GraphQL\RequestBuilder\Interfaces\TypeInterface;

/**
 * Implementation of the GraphQL type.
 *
 * @author  David Pauli
 * @package GraphQL\RequestBuilder
 * @since   14.08.2018
 */
class Type implements TypeInterface
{
    /** @var string The name of the type. */
    private $name;

    /** @var ArgumentInterface[] Defined parameters to request the resource. */
    private $arguments;

    /** @var TypeInterface[] Expected types in responses. */
    private $types = [];

    /**
     * @inheritdoc
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     * @return self
     */
    public function addArgument(ArgumentInterface $argument): TypeInterface
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addArguments(array $arguments): TypeInterface
    {
        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addSubType(TypeInterface $type): TypeInterface
    {
        $this->types[$type->getName()] = $type;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addSubTypes(array $types): TypeInterface
    {
        foreach ($types as $type) {
            $this->addSubType($type);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
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
