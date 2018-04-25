<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use Alcohol\ISO4217;
use Faker\Provider\Base as BaseProvider;
use Faker\Provider\Miscellaneous;

/**
 * @author Vincent Chalamon <vincent@les-tilleuls.coop>
 */
final class MiscellaneousProvider extends BaseProvider
{
    public function isoCodeNum(): int
    {
        $currencies = (new ISO4217())->getAll();

        return (int) $currencies[rand(0, count($currencies) - 1)]['numeric'];
    }

    public function price(): string
    {
        return (string) $this->generator->randomFloat(2);
    }

    public function volume(): string
    {
        return (string) $this->generator->randomFloat(5, 0, 999);
    }

    public function salesUnit(): int
    {
        return $this->generator->randomNumber(1);
    }

    public function conversionRate(): float
    {
        return $this->generator->randomFloat(6, 0, 1);
    }

    public function locale(): string
    {
        $locale = Miscellaneous::locale();
        while (strlen($locale) > 5) {
            $locale = Miscellaneous::locale();
        }

        return $locale;
    }

    public function valid($validator = null, $maxRetries = 10000): bool
    {
        return true;
    }
}
