<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Exception;

use Innmind\TimeContinuum\PointInTimeInterface;

final class EventCannotBeDeclaredInThePast extends LogicException
{
    private $pointInTime;

    public function __construct(PointInTimeInterface $pointInTime)
    {
        $this->pointInTime = $pointInTime;
        parent::__construct((string) $pointInTime);
    }

    public function pointInTime(): PointInTimeInterface
    {
        return $this->pointInTime;
    }
}
