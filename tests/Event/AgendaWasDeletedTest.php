<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\AgendaWasDeleted,
    Entity\Agenda\Identity,
};
use PHPUnit\Framework\TestCase;

class AgendaWasDeletedTest extends TestCase
{
    public function testInterface()
    {
        $event = new AgendaWasDeleted(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
