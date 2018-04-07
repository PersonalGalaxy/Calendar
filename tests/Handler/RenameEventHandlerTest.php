<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\RenameEventHandler,
    Command\RenameEvent,
    Repository\EventRepository,
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Event\Slot,
    Entity\Agenda\Identity as Agenda,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class RenameEventHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RenameEventHandler(
            $repository = $this->createMock(EventRepository::class)
        );
        $command = new RenameEvent(
            $this->createMock(Identity::class),
            new Name('bar')
        );
        $repository
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($event = Event::add(
                $command->identity(),
                $this->createMock(Agenda::class),
                new Name('foo'),
                new Slot(
                    $this->createMock(PointInTimeInterface::class),
                    $this->createMock(PointInTimeInterface::class)
                )
            ));

        $this->assertNull($handle($command));
        $this->assertSame($command->name(), $event->name());
    }
}
