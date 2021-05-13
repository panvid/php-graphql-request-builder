<?php

declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use BlackBonjour\Stdlib\Util\Assert;
use GraphQL\RequestBuilder\Interfaces\ArgumentInterface;
use JsonException;

/**
 * Implementation of a GraphQL argument.
 *
 * @author David Pauli
 * @since  14.08.2018
 */
class Argument implements ArgumentInterface
{
    /** @var string Name of the argument. */
    protected string $name;

    /** @var int|float|string|bool|ArgumentInterface[]|ArgumentInterface The value of the argument. */
    protected $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        switch (gettype($this->value)) {
            case 'integer':
            case 'double':
                $value = (string) $this->value;
                break;
            case 'string':
                $value = '"' . $this->value . '"';
                break;
            case 'boolean':
                $value = $this->value ? 'true' : 'false';
                break;
            case 'array':
                if (Assert::validate(self::class, ...$this->value)) {
                    $value = $this->buildStringFromArray($this->value);
                } else {
                    try {
                        $value = json_encode($this->value, JSON_THROW_ON_ERROR);
                    } catch (JsonException $exception) {
                        $value = null;
                    }
                }
                break;
            case 'object':
                $value = Assert::validate(self::class, $this->value)
                    ? $this->buildStringFromArray([$this->value])
                    : null;
                break;
            default:
                $value =  null;
        }

        if ($value === null) {
            return '';
        }

        return $this->name === '' ? trim($value, '{}') : $this->name . ':' . $value;
    }

    /**
     * @param  ArgumentInterface[] $values
     * @return string|null
     */
    protected function buildStringFromArray(array $values): ?string
    {
        $returnArray = [];
        foreach ($values as $value) {
            $returnArray[] = (string) $value;
        }
        return '{' . implode(',', $returnArray) . '}';
    }
}
