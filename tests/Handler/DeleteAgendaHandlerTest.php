<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\DeleteAgendaHandler,
    Handler\CancelEventHandler,
    Command\DeleteAgenda,
    Repository\EventRepository,
    Repository\AgendaRepository,
    Entity\Agenda,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
    Entity\Event,
    Event\AgendaWasDeleted,
    Specification\Agenda as AgendaSpec,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class DeleteAgendaHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new DeleteAgendaHandler(
            $agendas = $this->createMock(AgendaRepository::class),
            $events = $this->createMock(EventRepository::class),
            new CancelEventHandler($events)
        );
        $command = new DeleteAgenda($this->createMock(Identity::class));
        $agendas
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($agenda = Agenda::add(
                $command->identity(),
                $this->createMock(User::class),
                new Name('foo')
            ));
        $events
            ->expects($this->at(0))
            ->method('matching')
            ->with(new AgendaSpec($command->identity()))
            ->willReturn(Set::of(
                Event::class,
                $event1 = Event::add(
                    $this->createMock(Event\Identity::class),
                    $command->identity(),
                    new Event\Name('foo'),
                    new Event\Slot(
                        $this->createMock(PointInTimeInterface::class),
                        $this->createMock(PointInTimeInterface::class)
                    )
                ),
                $event2 = Event::add(
                    $this->createMock(Event\Identity::class),
                    $command->identity(),
                    new Event\Name('foo'),
                    new Event\Slot(
                        $this->createMock(PointInTimeInterface::class),
                        $this->createMock(PointInTimeInterface::class)
                    )
                )
            ));
        $events
            ->expects($this->at(1))
            ->method('get')
            ->with($event1->identity())
            ->willReturn($event1);
        $events
            ->expects($this->at(2))
            ->method('remove')
            ->with($event1->identity());
        $events
            ->expects($this->at(3))
            ->method('get')
            ->with($event2->identity())
            ->willReturn($event2);
        $events
            ->expects($this->at(4))
            ->method('remove')
            ->with($event2->identity());
        $agendas
            ->expects($this->once())
            ->method('remove')
            ->with($agenda->identity());

        $this->assertNull($handle($command));
        $this->assertInstanceOf(AgendaWasDeleted::class, $agenda->recordedEvents()->last());
    }
}
