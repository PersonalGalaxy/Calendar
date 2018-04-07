<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\EventWasMoved,
    Entity\Event\Identity,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class EventWasMovedTest extends TestCase
{
    public function testInterface()
    {
        $event = new EventWasMoved(
            $identity = $this->createMock(Identity::class),
            $pointInTime = $this->createMock(PointInTimeInterface::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($pointInTime, $event->pointInTime());
    }
}
