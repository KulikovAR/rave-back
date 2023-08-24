<?php

namespace App\Traits;
trait Rating
{
    public function getRating(): ?float
    {
        if(!is_null($this->rating)) {
            return $this->rating;
        }

        return $this->ratings()->count() ? round($this->ratings()->sum('rating') / $this->ratings()->count(), 1) : null;
    }
}