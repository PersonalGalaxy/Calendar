<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Specification;

use PersonalGalaxy\Calendar\{
    Specification\Agenda,
    Entity\Agenda\Identity,
};
use Innmind\Specification\ComparatorInterface;
use PHPUnit\Framework\TestCase;
use Eris\{
    TestTrait,
    Generator,
};

class AgendaTest extends TestCase
{
    use TestTrait;

    public function testInterface()
    {
        $this
            ->forAll(Generator\string())
            ->then(function(string $string): void {
                $identity = $this->createMock(Identity::class);
                $identity
                    ->expects($this->once())
                    ->method('__toString')
                    ->willReturn($string);
                $spec = new Agenda($identity);

                $this->assertInstanceOf(ComparatorInterface::class, $spec);
                $this->assertSame('agenda', $spec->property());
                $this->assertSame('=', $spec->sign());
                $this->assertSame($string, $spec->value());
            });
    }
}
