<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\CancelEventHandler,
    Command\CancelEvent,
    Repository\EventRepository,
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Agenda\Identity as Agenda,
    Event\EventWasCanceled,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class CancelEventHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new CancelEventHandler(
            $repository = $this->createMock(EventRepository::class)
        );
        $command = new CancelEvent($this->createMock(Identity::class));
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
        $repository
            ->expects($this->once())
            ->method('remove')
            ->with($command->identity());

        $this->assertNull($handle($command));
        $this->assertInstanceOf(EventWasCanceled::class, $event->recordedEvents()->last());
    }
}
