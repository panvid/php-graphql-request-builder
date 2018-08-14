<?php
declare(strict_types=1);

namespace GraphQL\RequestBuilder;

use BlackBonjour\Stdlib\Exception\InvalidArgumentException;
use BlackBonjour\Stdlib\Util\Assert;
use GraphQL\RequestBuilder\Interfaces\ArgumentInterface;
use TypeError;

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

    /** @var int|float|string|bool|ArgumentInterface[]|ArgumentInterface The value of the argument. */
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
                $value = $this->buildStringFromArray($this->value);
                break;
            case 'object':
                $value = $this->buildStringFromArray([$this->value]);
                break;
            default:
                $value =  '';
        }
        return empty($value) ? '' : $this->name . ':' . $value;
    }

    /**
     * @param  self[] $values
     * @return string
     */
    private function buildStringFromArray(array $values): string
    {
        try {
            $correctType = Assert::typeOf(self::class, ...$values);
        } catch (TypeError|InvalidArgumentException $exception) {
            return '';
        }

        if ($correctType === false) {
            return '';
        }

        $returnArray = [];
        foreach ($values as $value) {
            $returnArray[] = (string) $value;
        }
        return '{' . implode(',', $returnArray) . '}';
    }
}
