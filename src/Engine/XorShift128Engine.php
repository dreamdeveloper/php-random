<?php
/**
 * This file is part of the Random.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Emonkak\Random\Engine;

class XorShift128Engine extends AbstractEngine
{
    const X = 123456789;
    const Y = 362436069;
    const Z = 521288629;
    const W = 88675123;

    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;

    /**
     * @var integer
     */
    private $z;

    /**
     * @var integer
     */
    private $w;

    /**
     * @param integer|null $seed
     */
    public function __construct($seed = null)
    {
        if ($seed !== null) {
            $this->seed($seed);
        } else {
            $this->x = self::X;
            $this->y = self::Y;
            $this->z = self::Z;
            $this->w = self::W;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function max()
    {
        return 0x7fffffff;
    }

    /**
     * {@inheritdoc}
     */
    public function min()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $t = ($this->x ^ ($this->x << 11)) & 0xffffffff;

        $this->x = $this->y;
        $this->y = $this->z;
        $this->z = $this->w;
        $this->w = ($this->w ^ $this->shiftR($this->w, 19) ^ ($t ^ $this->shiftR($t, 8))) & 0xffffffff;

        // Kill the sign bit for 32bit systems.
        return $this->w & 0x7fffffff;
    }

    /**
     * {@inheritdoc}
     */
    public function seed($seed)
    {
        // https://gist.github.com/gintenlabo/604721
        $this->x = self::X ^  $seed                                   & 0xffffffff;
        $this->y = self::Y ^ ($seed << 17) | $this->shiftR($seed, 15) & 0xffffffff;
        $this->z = self::Z ^ ($seed << 31) | $this->shiftR($seed,  1) & 0xffffffff;
        $this->w = self::W ^ ($seed << 18) | $this->shiftR($seed, 14) & 0xffffffff;
    }

    /**
     * @param integer $x
     * @param integer $i
     * @return integer
     */
    private function shiftR($x, $i)
    {
        return $x >> $i & ~(~0 << (32 - $i));
    }
}
