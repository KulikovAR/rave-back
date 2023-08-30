<?php

namespace App\Traits;

use App\Enums\PassengerTypeEnum;
use Carbon\Carbon;

trait DateFormats
{
    private function formatDateForInput(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        return date('Y-m-d', strtotime($date));
    }

    private function formatDateForOutput(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        return date('d.m.Y', strtotime($date));
    }

    private function formatDateTimeForOutput(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        return date('d.m.Y H:i:s', strtotime($date));
    }

    private function formatWithTimezone(?string $date): string
    {
        return Carbon::parse($date)->toISOString();
    }
}

