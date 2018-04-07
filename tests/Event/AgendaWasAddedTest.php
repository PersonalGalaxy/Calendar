<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\{
    Event\AgendaWasAdded,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
};
use PHPUnit\Framework\TestCase;

class AgendaWasAddedTest extends TestCase
{
    public function testInterface()
    {
        $event = new AgendaWasAdded(
            $identity = $this->createMock(Identity::class),
            $user = $this->createMock(User::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($user, $event->user());
        $this->assertSame($name, $event->name());
    }
}
