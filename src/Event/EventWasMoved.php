<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Event;

use PersonalGalaxy\Calendar\Entity\Event\Identity;
use Innmind\TimeContinuum\PointInTimeInterface;

final class EventWasMoved
{
    private $identity;
    private $pointInTime;

    public function __construct(
        Identity $identity,
        PointInTimeInterface $pointInTime
    ) {
        $this->identity = $identity;
        $this->pointInTime = $pointInTime;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function pointInTime(): PointInTimeInterface
    {
        return $this->pointInTime;
    }
}
