<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\RenameAgenda,
    Repository\AgendaRepository,
};

final class RenameAgendaHandler
{
    private $repository;

    public function __construct(AgendaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RenameAgenda $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->rename($wished->name());
    }
}
