<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler\Event;

use PersonalGalaxy\Calendar\{
    Command\Event\AddNote,
    Repository\EventRepository,
};

final class AddNoteHandler
{
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddNote $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->addNote($wished->note());
    }
}
