<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\Entity\Event\Identity;

final class EventWasCanceled
{
    private $identity;

    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
