<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Entity;

use PersonalGalaxy\Calendar\{
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Event\Slot,
    Entity\Event\Note,
    Entity\Agenda\Identity as Agenda,
    Event\EventWasAdded,
    Event\EventWasRenamed,
    Event\EventWasMoved,
    Event\EventWasCanceled,
    Event\Event\NoteWasAdded,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use Innmind\EventBus\ContainsRecordedEventsInterface;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testAdd()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $agenda = $this->createMock(Agenda::class),
            $name = new Name('foo'),
            $slot = new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertInstanceOf(Event::class, $event);
        $this->assertInstanceOf(ContainsRecordedEventsInterface::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($agenda, $event->agenda());
        $this->assertSame($name, $event->name());
        $this->assertSame($slot, $event->slot());
        $this->assertSame('', (string) $event->note());
        $this->assertCount(1, $event->recordedEvents());
        $recordedEvent = $event->recordedEvents()->first();
        $this->assertInstanceOf(EventWasAdded::class, $recordedEvent);
        $this->assertSame($identity, $recordedEvent->identity());
        $this->assertSame($agenda, $recordedEvent->agenda());
        $this->assertSame($name, $recordedEvent->name());
        $this->assertSame($slot, $recordedEvent->slot());
    }

    public function testRename()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame($event, $event->rename($name = new Name('bar')));
        $this->assertSame($name, $event->name());
        $this->assertCount(2, $event->recordedEvents());
        $recordedEvent = $event->recordedEvents()->last();
        $this->assertInstanceOf(EventWasRenamed::class, $recordedEvent);
        $this->assertSame($identity, $recordedEvent->identity());
        $this->assertSame($name, $recordedEvent->name());
    }

    public function testDoesntRecordAnEventWhenRenamingWithSameName()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            $name = new Name('foo'),
            new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame($event, $event->rename(new Name('foo')));
        $this->assertSame($name, $event->name());
        $this->assertCount(1, $event->recordedEvents());
    }

    public function testMove()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame(
            $event,
            $event->move(
                $slot = new Slot(
                    $this->createMock(PointInTimeInterface::class),
                    $this->createMock(PointInTimeInterface::class)
                )
            )
        );
        $this->assertSame($slot, $event->slot());
        $this->assertCount(2, $event->recordedEvents());
        $recordedEvent = $event->recordedEvents()->last();
        $this->assertInstanceOf(EventWasMoved::class, $recordedEvent);
        $this->assertSame($identity, $recordedEvent->identity());
        $this->assertSame($slot, $recordedEvent->slot());
    }

    public function testCancel()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertNull($event->cancel());
        $this->assertCount(2, $event->recordedEvents());
        $recordedEvent = $event->recordedEvents()->last();
        $this->assertInstanceOf(EventWasCanceled::class, $recordedEvent);
        $this->assertSame($identity, $recordedEvent->identity());
    }

    public function testAddNote()
    {
        $event = Event::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(Agenda::class),
            new Name('foo'),
            new Slot(
                $this->createMock(PointInTimeInterface::class),
                $this->createMock(PointInTimeInterface::class)
            )
        );

        $this->assertSame($event, $event->addNote($note = new Note('foo')));
        $this->assertSame($note, $event->note());
        $this->assertCount(2, $event->recordedEvents());
        $recordedEvent = $event->recordedEvents()->last();
        $this->assertInstanceOf(NoteWasAdded::class, $recordedEvent);
        $this->assertSame($identity, $recordedEvent->identity());
        $this->assertSame($note, $recordedEvent->note());
    }
}
