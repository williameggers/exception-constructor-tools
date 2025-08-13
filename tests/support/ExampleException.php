<?php

declare(strict_types=1);

namespace tests\support;

use TomPHP\ExceptionConstructorTools;

class ExampleException extends \RuntimeException
{
    use ExceptionConstructorTools;

    /**
     * @param array<bool|float|int|string|null>|bool|float|int|string|null $param
     */
    public static function fromFormatString(string $format, array|bool|float|int|string|null $param): static
    {
        if (!is_array($param)) {
            $param = [$param];
        }

        return self::create($format, $param);
    }

    public static function fromCode(int $code): static
    {
        return self::create('', [], $code);
    }

    public static function fromPreviousException(?\Exception $exception): static
    {
        return self::create('', [], 0, $exception);
    }

    public static function withTypeInMessage(mixed $param): static
    {
        return self::create(self::typeToString($param));
    }

    public static function withValueInMessage(mixed $value): static
    {
        return self::create(self::valueToString($value));
    }

    /**
     * @param array<mixed> $param
     */
    public static function withListInMessage(array $param): static
    {
        return self::create(self::listToString($param));
    }
}
