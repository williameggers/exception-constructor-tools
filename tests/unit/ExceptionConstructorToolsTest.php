<?php

declare(strict_types=1);

namespace tests\unit\TomPHP;

use PHPUnit\Framework\TestCase;
use tests\support\ExampleException;
use tests\support\ExampleExtendedException;

final class ExceptionConstructorToolsTest extends TestCase
{
    public function testItFormatsTheMessage(): void
    {
        $exampleException = ExampleException::fromFormatString('example %s', 'message');

        $this->assertSame('example message', $exampleException->getMessage());
    }

    public function testItCanAddAnExceptionCode(): void
    {
        $exampleException = ExampleException::fromCode(909);

        $this->assertSame(909, $exampleException->getCode());
    }

    public function testItCanAddAPreviousException(): void
    {
        $runtimeException = new \RuntimeException();

        $exampleException = ExampleException::fromPreviousException($runtimeException);

        $this->assertSame($runtimeException, $exampleException->getPrevious());
    }

    public function testItUsesLateStaticBindings(): void
    {
        $exampleExtendedException = ExampleExtendedException::fromFormatString('', []);

        $this->assertInstanceOf('tests\support\ExampleExtendedException', $exampleExtendedException);
    }

    public function testItConvertsABuiltInTypeToAMessage(): void
    {
        $exampleException = ExampleException::withTypeInMessage(99);

        $this->assertSame('[integer]', $exampleException->getMessage());
    }

    public function testItConvertsAnObjectToAClassNameMessage(): void
    {
        $exampleException = ExampleException::withTypeInMessage(new \stdClass());

        $this->assertSame('stdClass', $exampleException->getMessage());
    }

    public function testItConvertsAStringValueToAMessage(): void
    {
        $exampleException = ExampleException::withValueInMessage('value');

        $this->assertSame('"value"', $exampleException->getMessage());
    }

    public function testItConvertsAStringWithQuotesValueToAMessage(): void
    {
        $exampleException = ExampleException::withValueInMessage('"value"');

        $this->assertSame('"\"value\""', $exampleException->getMessage());
    }

    public function testItConvertsATrueValueToAMessage(): void
    {
        $exampleException = ExampleException::withValueInMessage(true);

        $this->assertSame('true', $exampleException->getMessage());
    }

    public function testItConvertsAFalseValueToAMessage(): void
    {
        $exampleException = ExampleException::withValueInMessage(false);

        $this->assertSame('false', $exampleException->getMessage());
    }

    public function testItConvertsAnIntValueToAMessage(): void
    {
        $exampleException = ExampleException::withValueInMessage(12);

        $this->assertSame('12', $exampleException->getMessage());
    }

    public function testItConvertsAListOfStringsToAMessage(): void
    {
        $exampleException = ExampleException::withListInMessage(['a', 'b', 'c']);

        $this->assertSame('["a", "b", "c"]', $exampleException->getMessage());
    }

    public function testItConvertsAnEmptyListToAMessage(): void
    {
        $exampleException = ExampleException::withListInMessage([]);

        $this->assertSame('[]', $exampleException->getMessage());
    }

    public function testItConvertsAListOfIntsToAMessage(): void
    {
        $exampleException = ExampleException::withListInMessage([1, 2, 3]);

        $this->assertSame('[1, 2, 3]', $exampleException->getMessage());
    }
}
