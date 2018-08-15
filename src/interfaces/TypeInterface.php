<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder\Interfaces;

/**
 * This are the types, represents the requested parameters in GraphQL.
 *
 * @author  David Pauli
 * @package GraphQL\RequestBuilder
 * @since   14.08.2018
 */
interface TypeInterface
{
    /**
     * Creates the Type object with defining the name of the type.
     *
     * @param string $name
     */
    public function __construct(string $name);

    /**
     * Add a single argument to the type as parameter.
     *
     * @param  ArgumentInterface $argument
     * @return self
     */
    public function addArgument(ArgumentInterface $argument): TypeInterface;

    /**
     * Adds a couple of arguments to parameter list.
     *
     * @param  ArgumentInterface[] $arguments
     * @return self
     */
    public function addArguments(array $arguments): TypeInterface;

    /**
     * Adds a specific subtype to the type.
     *
     * @param  TypeInterface|string $type
     * @return self
     */
    public function addSubType($type): TypeInterface;

    /**
     * Adds a couple of specific subtypes to the type.
     *
     * @param  TypeInterface[]|string[] $types
     * @return self
     */
    public function addSubTypes(array $types): TypeInterface;

    /**
     * Returns the name of the type.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the specific type (with subtypes) as GraphQL string.
     *
     * @return string
     */
    public function __toString(): string;
}
