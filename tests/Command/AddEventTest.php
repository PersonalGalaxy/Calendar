<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\AddEvent,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Event\Slot,
    Entity\Agenda\Identity as Agenda,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class AddEventTest extends TestCase
{
    public function testInterface()
    {
        $event = new AddEvent(
            $identity = $this->createMock(Identity::class),
            $agenda = $this->createMock(Agenda::class),
            $name = new Name('foo'),
            $slot = new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($agenda, $event->agenda());
        $this->assertSame($name, $event->name());
        $this->assertSame($slot, $event->slot());
    }
}
