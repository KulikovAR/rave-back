<?php

namespace App\Services;

use App\Contracts\EventServiceContract;

class EventService implements EventServiceContract
{
    public function handler(array $request): void
    {
        $this->proccess();
        return;
    }

    public function proccess(): void
    {

        return;
    }

    public function distribute(): void
    {
        return;
    }
}
