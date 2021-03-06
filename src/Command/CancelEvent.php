<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Command;

use PersonalGalaxy\Calendar\Entity\Event\Identity;

final class CancelEvent
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
