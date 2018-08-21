<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

trait TimestampBehavior
{
    private static function normalizeDateTimeForGet(?DateTimeInterface $at): ?DateTimeImmutable
    {
        if ($at === null) {
            return null;
        }

        return ($at instanceof DateTimeImmutable)
            ? $at
            : DateTimeImmutable::createFromMutable($at);
    }

    private static function normalizeDateTimeForSet(?DateTimeInterface $at): DateTime
    {
        if ($at === null) {
            return new DateTime();
        }

        if ($at instanceof DateTime) {
            return $at;
        }

        if (is_callable(['DateTime', 'createFromImmutable'])) {
            return DateTime::createFromImmutable($at);
        }

        return DateTime::createFromFormat(
            'U u',
            $at->format('U u'),
            $at->getTimezone()
        );
    }
}
