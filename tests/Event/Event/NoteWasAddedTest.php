<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\Event\NoteWasAdded,
    Entity\Event\Identity,
    Entity\Event\Note,
};
use PHPUnit\Framework\TestCase;

class NoteWasAddedTest extends TestCase
{
    public function testInterface()
    {
        $event = new NoteWasAdded(
            $identity = $this->createMock(Identity::class),
            $note = new Note('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($note, $event->note());
    }
}
