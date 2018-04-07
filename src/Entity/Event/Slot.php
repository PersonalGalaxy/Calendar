<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Entity\Event;

use PersonalGalaxy\Calendar\Exception\{
    LogicException,
    EmptySlot,
};
use Innmind\TimeContinuum\PointInTimeInterface;

final class Slot
{
    private $start;
    private $end;

    public function __construct(
        PointInTimeInterface $start,
        PointInTimeInterface $end
    ) {
        if ($start->aheadOf($end)) {
            throw new LogicException;
        }

        if ($start->equals($end)) {
            throw new EmptySlot;
        }

        $this->start = $start;
        $this->end = $end;
    }

    public function start(): PointInTimeInterface
    {
        return $this->start;
    }

    public function end(): PointInTimeInterface
    {
        return $this->end;
    }

    public function overlaps(self $slot): bool
    {
        /**
         * this: |----|
         * slot:        |----|
         */
        if ($slot->start()->aheadOf($this->end)) {
            return false;
        }

        /**
         * this:        |----|
         * slot: |----|
         */
        if ($this->start->aheadOf($slot->end())) {
            return false;
        }

        /**
         * this: |----|
         * slot:      |----|
         */
        if ($slot->start()->equals($this->end)) {
            return false;
        }

        /**
         * this:      |----|
         * slot: |----|
         */
        if ($this->start->equals($slot->end())) {
            return false;
        }

        return true;
    }
}
