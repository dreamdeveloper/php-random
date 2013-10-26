# Random.php  [![Build Status](https://travis-ci.org/emonkak/random.php.png)](https://travis-ci.org/emonkak/random.php)

Random.php is a random number generator.

It provides pseudo-random number Generators and random number distributions.

## Requirements

- PHP 5.3 or higher
- [Composer](http://getcomposer.org/)

## Licence

MIT Licence

## Examples

```php
use Random\Engine\MT19937Engine;
use Random\Distribution\NormalDistribution;

$seed = 100;  // Initial seed
$engine = new MT19937Engine($seed);  // Mersenne Twister engine
$distribution = new NormalDistribution(0, 1);  // Standard normal distribution

$distribution->generate();  // Generate a random number with normal distribution
```

## Engine

- `MT19937Engine`

	This is full-compatible to the build-in `mt_rand()`.

- `XorShift128Engine`

## Distribution

- `BernoulliDistribution`
- `BinomialDistribution`
- `DiscreteDistribution`
- `DistributionIterator`
- `NormalDistribution`
- `UniformIntDistribution`
- `UniformRealDistribution`
