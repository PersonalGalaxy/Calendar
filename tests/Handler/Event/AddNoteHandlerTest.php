<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler\Event;

use PersonalGalaxy\Calendar\{
    Handler\Event\AddNoteHandler,
    Command\Event\AddNote,
    Repository\EventRepository,
    Entity\Event,
    Entity\Event\Identity,
    Entity\Event\Name,
    Entity\Event\Slot,
    Entity\Event\Note,
    Entity\Agenda\Identity as Agenda,
};
use Innmind\TimeContinuum\PointInTimeInterface;
use PHPUnit\Framework\TestCase;

class AddNoteHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new AddNoteHandler(
            $repository = $this->createMock(EventRepository::class)
        );
        $command = new AddNote(
            $this->createMock(Identity::class),
            new Note('bar')
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
        $this->assertSame($command->note(), $event->note());
    }
}
