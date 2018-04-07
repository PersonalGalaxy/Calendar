<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\RenameEvent,
    Repository\EventRepository,
};

final class RenameEventHandler
{
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RenameEvent $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->rename($wished->name());
    }
}
