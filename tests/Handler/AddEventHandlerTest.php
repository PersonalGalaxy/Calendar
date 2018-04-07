<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\AddEventHandler,
    Command\AddEvent,
    Repository\EventRepository,
    Repository\AgendaRepository,
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\User,
    Entity\Event\Name,
    Entity\Agenda\Identity as Agenda,
    Event\EventWasAdded,
    Exception\AgendaNotFound,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class AddEventHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new AddEventHandler(
            $events = $this->createMock(EventRepository::class),
            $agendas = $this->createMock(AgendaRepository::class)
        );
        $command = new AddEvent(
            $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            $this->createMock(PointInTimeInterface::class)
        );
        $agendas
            ->expects($this->once())
            ->method('has')
            ->with($command->agenda())
            ->willReturn(true);
        $events
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(static function(Event $event) use ($command): bool {
                return $event->identity() === $command->identity() &&
                    $event->agenda() === $command->agenda() &&
                    $event->name() === $command->name() &&
                    $event->pointInTime() === $command->pointInTime() &&
                    $event->recordedEvents()->first() instanceof EventWasAdded;
            }));

        $this->assertNull($handle($command));
    }

    public function testThrowWhenAgendaNotFound()
    {
        $handle = new AddEventHandler(
            $events = $this->createMock(EventRepository::class),
            $agendas = $this->createMock(AgendaRepository::class)
        );
        $command = new AddEvent(
            $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            $this->createMock(PointInTimeInterface::class)
        );
        $agendas
            ->expects($this->once())
            ->method('has')
            ->with($command->agenda())
            ->willReturn(false);
        $events
            ->expects($this->never())
            ->method('add');

        try {
            $handle($command);

            $this->fail('it should throw');
        } catch (AgendaNotFound $e) {
            $this->assertSame($command->agenda(), $e->identity());
        }
    }
}
