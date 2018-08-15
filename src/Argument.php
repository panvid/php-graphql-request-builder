<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use BlackBonjour\Stdlib\Util\Assert;
use GraphQL\RequestBuilder\Interfaces\ArgumentInterface;

/**
 * Implementation of a GraphQL argument.
 *
 * @author  David Pauli
 * @package GraphQL\RequestBuilder
 * @since   14.08.2018
 */
class Argument implements ArgumentInterface
{
    /** @var string Name of the argument. */
    private $name;

    /** @var int|float|string|bool|Argument[]|Argument The value of the argument. */
    private $value;

    /**
     * @inheritdoc
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
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
        switch (gettype($this->value)) {
            case 'integer':
            case 'double':
                $value = $this->value;
                break;
            case 'string':
                $value = '"' . $this->value . '"';
                break;
            case 'boolean':
                $value = $this->value ? 'true' : 'false';
                break;
            case 'array':
                $value = Assert::validate(self::class, ...$this->value)
                    ? $this->buildStringFromArray($this->value)
                    : json_encode($this->value);
                break;
            case 'object':
                $value = Assert::validate(self::class, $this->value)
                    ? $this->buildStringFromArray([$this->value])
                    : null;
                break;
            default:
                $value =  null;
        }
        return $value === null ? '' : $this->name . ':' . $value;
    }

    /**
     * @param  Argument[] $values
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
