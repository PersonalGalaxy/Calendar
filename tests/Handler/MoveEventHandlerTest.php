<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\MoveEventHandler,
    Command\MoveEvent,
    Repository\EventRepository,
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Agenda\Identity as Agenda,
    Exception\EventCannotBeDeclaredInThePast,
};
use Innmind\TimeContinuum\{
    TimeContinuumInterface,
    PointInTimeInterface,
};
use PHPUnit\Framework\TestCase;

class MoveEventHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new MoveEventHandler(
            $repository = $this->createMock(EventRepository::class),
            $clock = $this->createMock(TimeContinuumInterface::class)
        );
        $command = new MoveEvent(
            $this->createMock(Identity::class),
            $pointInTime = $this->createMock(PointInTimeInterface::class)
        );
        $clock
            ->expects($this->once())
            ->method('now')
            ->willReturn($now = $this->createMock(PointInTimeInterface::class));
        $now
            ->expects($this->once())
            ->method('aheadOf')
            ->with($pointInTime)
            ->willReturn(false);
        $repository
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($event = Event::add(
                $command->identity(),
                $this->createMock(Agenda::class),
                new Name('foo'),
                $this->createMock(PointInTimeInterface::class)
            ));

        $this->assertNull($handle($command));
        $this->assertSame($pointInTime, $event->pointInTime());
    }

    public function testThrowWhenPointInTimeInThePast()
    {
        $handle = new MoveEventHandler(
            $repository = $this->createMock(EventRepository::class),
            $clock = $this->createMock(TimeContinuumInterface::class)
        );
        $command = new MoveEvent(
            $this->createMock(Identity::class),
            $pointInTime = $this->createMock(PointInTimeInterface::class)
        );
        $clock
            ->expects($this->once())
            ->method('now')
            ->willReturn($now = $this->createMock(PointInTimeInterface::class));
        $now
            ->expects($this->once())
            ->method('aheadOf')
            ->with($pointInTime)
            ->willReturn(true);
        $repository
            ->expects($this->never())
            ->method('get');

        try {
            $handle($command);

            $this->fail('it should throw');
        } catch (EventCannotBeDeclaredInThePast $e) {
            $this->assertSame($pointInTime, $e->pointInTime());
        }
    }
}
