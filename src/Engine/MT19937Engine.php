<?php

declare(strict_types=1);

namespace Emonkak\Random\Engine;

/**
 * A Mersenne Twister pseudo-random generator of 32-bit numbers.
 */
class MT19937Engine extends AbstractEngine
{
    const N = 624;
    const M = 397;

    /**
     * @var \SplFixedArray
     */
    private $state;

    /**
     * @var int
     */
    private $remains = 0;

    public function __construct(int $seed)
    {
        $this->state = new \SplFixedArray(self::N + 1);
        $this->setSeed($seed);
    }

    /**
     * {@inheritdoc}
     */
    public function min(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function max(): int
    {
        return 0x7fffffff;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): int
    {
        if ($this->remains === 0) {
            $this->nextSeed();
        }

        $this->remains--;

        $s1 = $this->tempering($this->state->current());

        $this->state->next();

        return $s1;
    }

    protected function twist(int $m, int $u, int $v): int
    {
        $y = ($u & 0x80000000) | ($v & 0x7fffffff);
        return $m ^ (($y >> 1) & 0x7fffffff) ^ -($v & 0x00000001) & 0x9908b0df;
    }

    private function setSeed(int $seed): void
    {
        $this->state[0] = $seed & 0xffffffff;

        $int0 = $seed & 0xffff;
        $int1 = ($seed >> 16) & 0xffff;

        for ($i = 1; $i < self::N; $i++) {
            // $state[$i] = (1812433253 * ($state[$i - 1] ^ ($state[$i - 1] >> 30)) + $i) & 0xffffffff;
            $int0 ^= $int1 >> 14;
            $carry = (0x8965 * $int0) + $i;
            $tmp = $carry & 0xffff;
            $int1 = ((0x8965 * $int1) & 0xffff) + ((0x6C07 * $int0) & 0xffff) + ($carry >> 16) & 0xffff;
            $int0 = $tmp;
            $this->state[$i] = ($int1 << 16) | $int0;
        }
    }

    private function nextSeed(): void
    {
        for ($i = 0, $l = self::N - self::M; $i < $l; $i++) {
            $this->state[$i] = $this->twist(
                $this->state[$i + self::M],
                $this->state[$i],
                $this->state[$i + 1]
            );
        }

        for ($l = self::N - 1; $i < $l; $i++) {
            $this->state[$i] = $this->twist(
                $this->state[$i + self::M - self::N],
                $this->state[$i],
                $this->state[$i + 1]
            );
        }

        $this->state[$i] = $this->twist(
            $this->state[$i + self::M - self::N],
            $this->state[$i],
            $this->state[0]
        );

        $this->remains = self::N;

        $this->state->rewind();
    }

    private function tempering(int $x): int
    {
        $x ^= ($x >> 11) & 0x7fffffff;
        $x ^= ($x << 7) & 0x9d2c5680;
        $x ^= ($x << 15) & 0xefc60000;
        $x ^= ($x >> 18) & 0x7fffffff;
        return ($x >> 1) & 0x7fffffff;
    }
}
