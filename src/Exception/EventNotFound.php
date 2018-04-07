<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Exception;

use PersonalGalaxy\Calendar\Entity\Event\Identity;

final class EventNotFound extends LogicException
{
    private $identity;

    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
        parent::__construct((string) $identity);
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
