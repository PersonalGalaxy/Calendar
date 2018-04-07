<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Calendar\Repository;

use PersonalGalaxy\Calendar\Entity\{
    Event,
    Event\Identity,
};
use Innmind\Immutable\SetInterface;
use Innmind\Specification\SpecificationInterface;

interface EventRepository
{
    /**
     * @throws EventNotFound
     */
    public function get(Identity $identity): Event;
    public function add(Event $event): self;
    public function remove(Identity $identity): self;
    public function has(Identity $identity): bool;
    public function count(): int;
    /**
     * @return SetInterface<Event>
     */
    public function all(): SetInterface;
    /**
     * @return SetInterface<Event>
     */
    public function matching(SpecificationInterface $specification): SetInterface;
}
