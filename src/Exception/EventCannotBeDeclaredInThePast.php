<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Exception;

use PersonalGalaxy\Calendar\Entity\Event\Slot;

final class EventCannotBeDeclaredInThePast extends LogicException
{
    private $slot;

    public function __construct(Slot $slot)
    {
        $this->slot = $slot;
        parent::__construct();
    }

    public function slot(): Slot
    {
        return $this->slot;
    }
}
