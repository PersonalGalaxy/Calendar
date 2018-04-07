<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\AddAgenda,
    Repository\AgendaRepository,
    Entity\Agenda,
};

final class AddAgendaHandler
{
    private $repository;

    public function __construct(AgendaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddAgenda $wished): void
    {
        $this->repository->add(
            Agenda::add(
                $wished->identity(),
                $wished->user(),
                $wished->name()
            )
        );
    }
}
