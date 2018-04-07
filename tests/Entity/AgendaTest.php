<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Entity;

use PersonalGalaxy\Calendar\{
    Entity\Agenda,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
    Event\AgendaWasAdded,
    Event\AgendaWasRenamed,
    Event\AgendaWasDeleted,
};
use Innmind\EventBus\ContainsRecordedEventsInterface;
use PHPUnit\Framework\TestCase;

class AgendaTest extends TestCase
{
    public function testAdd()
    {
        $agenda = Agenda::add(
            $identity = $this->createMock(Identity::class),
            $user = $this->createMock(User::class),
            $name = new Name('foo')
        );

        $this->assertInstanceOf(Agenda::class, $agenda);
        $this->assertInstanceOf(ContainsRecordedEventsInterface::class, $agenda);
        $this->assertSame($identity, $agenda->identity());
        $this->assertSame($user, $agenda->user());
        $this->assertSame($name, $agenda->name());
        $this->assertCount(1, $agenda->recordedEvents());
        $event = $agenda->recordedEvents()->first();
        $this->assertInstanceOf(AgendaWasAdded::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($user, $event->user());
        $this->assertSame($name, $event->name());
    }

    public function testRename()
    {
        $agenda = Agenda::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(User::class),
            new Name('foo')
        );

        $this->assertSame($agenda, $agenda->rename($name = new Name('bar')));
        $this->assertSame($name, $agenda->name());
        $this->assertCount(2, $agenda->recordedEvents());
        $event = $agenda->recordedEvents()->last();
        $this->assertInstanceOf(AgendaWasRenamed::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }

    public function testDoesntRecordAnEventWhenRenamingWithSameName()
    {
        $agenda = Agenda::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(User::class),
            $name = new Name('foo')
        );

        $this->assertSame($agenda, $agenda->rename(new Name('foo')));
        $this->assertSame($name, $agenda->name());
        $this->assertCount(1, $agenda->recordedEvents());
    }

    public function testDelete()
    {
        $agenda = Agenda::add(
            $identity = $this->createMock(Identity::class),
            $this->createMock(User::class),
            new Name('foo')
        );

        $this->assertNull($agenda->delete());
        $this->assertCount(2, $agenda->recordedEvents());
        $event = $agenda->recordedEvents()->last();
        $this->assertInstanceOf(AgendaWasDeleted::class, $event);
        $this->assertSame($identity, $event->identity());
    }
}
