<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\EventWasAdded,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Agenda\Identity as Agenda,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class EventWasAddedTest extends TestCase
{
    public function testInterface()
    {
        $event = new EventWasAdded(
            $identity = $this->createMock(Identity::class),
            $agenda = $this->createMock(Agenda::class),
            $name = new Name('foo'),
            $pointInTime = $this->createMock(PointInTimeInterface::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($agenda, $event->agenda());
        $this->assertSame($name, $event->name());
        $this->assertSame($pointInTime, $event->pointInTime());
    }
}
