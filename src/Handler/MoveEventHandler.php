<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Handler;

use PersonalGalaxy\Calendar\{
    Command\MoveEvent,
    Repository\EventRepository,
    Exception\EventCannotBeDeclaredInThePast,
};
use Innmind\TimeContinuum\TimeContinuumInterface;

final class MoveEventHandler
{
    private $repository;
    private $clock;

    public function __construct(
        EventRepository $repository,
        TimeContinuumInterface $clock
    ) {
        $this->repository = $repository;
        $this->clock = $clock;
    }

    public function __invoke(MoveEvent $wished): void
    {
        if ($this->clock->now()->aheadOf($wished->pointInTime())) {
            throw new EventCannotBeDeclaredInThePast($wished->pointInTime());
        }

        $this
            ->repository
            ->get($wished->identity())
            ->move($wished->pointInTime());
    }
}
