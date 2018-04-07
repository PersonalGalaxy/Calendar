<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\RenameAgenda,
    Entity\Agenda\Identity,
    Entity\Agenda\Name,
};
use PHPUnit\Framework\TestCase;

class RenameAgendaTest extends TestCase
{
    public function testInterface()
    {
        $event = new RenameAgenda(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
