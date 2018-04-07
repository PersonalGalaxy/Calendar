<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\EventWasMoved,
    Entity\Event\Identity,
    Entity\Event\Slot,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class EventWasMovedTest extends TestCase
{
    public function testInterface()
    {
        $event = new EventWasMoved(
            $identity = $this->createMock(Identity::class),
            $slot = new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($slot, $event->slot());
    }
}
