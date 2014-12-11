<?php
/**
 * This file is part of the Random.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Emonkak\Random\Distribution;

use Emonkak\Random\Engine\AbstractEngine;

class LogNormalDistribution extends NormalDistribution
{
    /**
     * {@inheritdoc}
     */
    public function generate(AbstractEngine $engine)
    {
        return exp(parent::generate($engine));
    }
}
