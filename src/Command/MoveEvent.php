<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\Entity\Event\{
    Identity,
    Slot,
};

final class MoveEvent
{
    private $identity;
    private $slot;

    public function __construct(
        Identity $identity,
        Slot $slot
    ) {
        $this->identity = $identity;
        $this->slot = $slot;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function slot(): Slot
    {
        return $this->slot;
    }
}
