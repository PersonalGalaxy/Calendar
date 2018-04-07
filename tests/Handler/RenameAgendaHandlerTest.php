<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Handler\RenameAgendaHandler,
    Command\RenameAgenda,
    Repository\AgendaRepository,
    Entity\Agenda,
    Entity\Agenda\Identity,
    Entity\Agenda\User,
    Entity\Agenda\Name,
};
use PHPUnit\Framework\TestCase;

class RenameAgendaHandlerTest extends TestCase
{
    public function testInterface()
    {
        $handle = new RenameAgendaHandler(
            $repository = $this->createMock(AgendaRepository::class)
        );
        $command = new RenameAgenda(
            $this->createMock(Identity::class),
            new Name('bar')
        );
        $repository
            ->expects($this->once())
            ->method('get')
            ->with($command->Identity())
            ->willReturn($agenda = Agenda::add(
                $command->identity(),
                $this->createMock(User::class),
                new Name('foo')
            ));

        $this->assertNull($handle($command));
        $this->assertSame($command->name(), $agenda->name());
    }
}
