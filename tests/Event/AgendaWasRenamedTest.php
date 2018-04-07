<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\AgendaWasRenamed,
    Entity\Agenda\Identity,
    Entity\Agenda\Name,
};
use PHPUnit\Framework\TestCase;

class AgendaWasRenamedTest extends TestCase
{
    public function testInterface()
    {
        $event = new AgendaWasRenamed(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
