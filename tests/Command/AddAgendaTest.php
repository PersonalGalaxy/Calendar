<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\AddAgenda,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
};
use PHPUnit\Framework\TestCase;

class AddAgendaTest extends TestCase
{
    public function testInterface()
    {
        $event = new AddAgenda(
            $identity = $this->createMock(Identity::class),
            $user = $this->createMock(User::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($user, $event->user());
        $this->assertSame($name, $event->name());
    }
}
