<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Calendar\Entity\Event;

use PersonalGalaxy\Calendar\{
    Entity\Event\Name,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;
use Eris\{
    Generator,
    TestTrait,
};

class NameTest extends TestCase
{
    use TestTrait;

    public function testInterface()
    {
        $this
            ->forAll(Generator\string())
            ->when(static function(string $string): bool {
                return $string !== '';
            })
            ->then(function(string $string): void {
                $this->assertSame($string, (string) new Name($string));
            });
    }

    public function testEquals()
    {
        $this
            ->forAll(Generator\string(), Generator\string())
            ->when(static function(string $a, string $b): bool {
                return $a !== '' && $b !== '' && $a !== $b;
            })
            ->then(function(string $a, string $b): void {
                $this->assertTrue((new Name($a))->equals(new Name($a)));
                $this->assertFalse((new Name($a))->equals(new Name($b)));
                $this->assertFalse((new Name($b))->equals(new Name($a)));
            });
    }

    public function testThrowWhenEmptyName()
    {
        $this->expectException(DomainException::class);

        new Name('');
    }
}
