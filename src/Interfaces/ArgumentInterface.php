<?php

declare(strict_types=1);

namespace GraphQL\RequestBuilder\Interfaces;

/**
 * This interface defines the structure of arguments, the call parameter of a type.
 *
 * @author David Pauli
 * @since  14.08.2018
 */
interface ArgumentInterface
{
    /**
     * The Argument is defined by a parameter name and a parameter value.
     *
     * @param string                                    $name
     * @param int|float|string|bool|ArgumentInterface[]|ArgumentInterface $value
     */
    public function __construct(string $name, $value);

    /**
     * Returns the name of the argument.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the argument definition as GraphQL string.
     *
     * @return string
     */
    public function __toString(): string;
}
