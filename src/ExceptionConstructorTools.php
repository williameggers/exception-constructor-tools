<?php

declare(strict_types=1);

namespace TomPHP;

/**
 * This trait provides useful static methods which can be used to help create
 * static constructors for exceptions.
 */
trait ExceptionConstructorTools
{
    /**
     * Create an instance of the exception with a formatted message.
     *
     * @param string                            $message   The exception message in sprintf format.
     * @param array<bool|float|int|string|null> $params    The sprintf parameters for the message.
     * @param int                               $code      Numeric exception code.
     * @param \Exception                        $exception The previous exception.
     */
    protected static function create(
        string $message,
        array $params = [],
        int $code = 0,
        ?\Exception $exception = null
    ): static {
        $class           = static::class;
        $reflectionClass = new \ReflectionClass($class);
        return $reflectionClass->newInstance(sprintf($message, ...$params), $code, $exception);
    }

    /**
     * Returns a string representation of the type of a variable.
     */
    protected static function typeToString(mixed $variable): string
    {
        return is_object($variable)
            ? $variable::class
            : '[' . gettype($variable) . ']';
    }

    /**
     * Returns a string representation of the value.
     */
    protected static function valueToString(mixed $value): string
    {
        if (!is_string($value)
            && !is_numeric($value)
            && !is_bool($value)
            && !$value instanceof \Stringable
        ) {
            throw new \InvalidArgumentException("Value isn't stringable");
        }

        return match (gettype($value)) {
            'string'  => '"' . addslashes($value) . '"',
            'boolean' => $value ? 'true' : 'false',
            default   => (string) $value,
        };
    }

    /**
     * Returns the list as a formatted string.
     *
     * @param array<mixed> $list
     */
    protected static function listToString(array $list): string
    {
        if ($list === []) {
            return '[]';
        }

        $list = array_map(fn ($item): string => static::valueToString($item), $list);

        return '[' . implode(', ', $list) . ']';
    }
}
