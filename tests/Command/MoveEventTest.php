<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\MoveEvent,
    Entity\Event\Identity,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class MoveEventTest extends TestCase
{
    public function testInterface()
    {
        $event = new MoveEvent(
            $identity = $this->createMock(Identity::class),
            $pointInTime = $this->createMock(PointInTimeInterface::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($pointInTime, $event->pointInTime());
    }
}
