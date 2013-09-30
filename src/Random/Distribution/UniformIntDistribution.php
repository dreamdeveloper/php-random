<?php
/**
 * This file is part of the Random.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Random\Distribution;

use Random\Engine\Engine;

class UniformIntDistribution extends Distribution
{
    /**
     * @var integer
     */
    private $min;

    /**
     * @var integer
     */
    private $max;

    /**
     * @param integer $min
     * @param integer $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(Engine $engine)
    {
        return (int) floor($this->min + ($this->max - $this->min + 1.0)
                                      * $engine->nextDouble());
    }
}
