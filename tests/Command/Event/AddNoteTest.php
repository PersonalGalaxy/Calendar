<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command\Event;

use PersonalGalaxy\Calendar\{
    Command\Event\AddNote,
    Entity\Event\Identity,
    Entity\Event\Note,
};
use PHPUnit\Framework\TestCase;

class AddNoteTest extends TestCase
{
    public function testInterface()
    {
        $event = new AddNote(
            $identity = $this->createMock(Identity::class),
            $note = new Note('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($note, $event->note());
    }
}
