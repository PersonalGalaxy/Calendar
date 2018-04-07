<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\CancelEvent,
    Repository\EventRepository,
};

final class CancelEventHandler
{
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CancelEvent $wished): void
    {
        $event = $this->repository->get($wished->identity());
        $event->cancel();
        $this->repository->remove($event->identity());
    }
}
