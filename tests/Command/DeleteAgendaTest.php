<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\{
    Command\DeleteAgenda,
    Entity\Agenda\Identity,
};
use PHPUnit\Framework\TestCase;

class DeleteAgendaTest extends TestCase
{
    public function testInterface()
    {
        $event = new DeleteAgenda(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
