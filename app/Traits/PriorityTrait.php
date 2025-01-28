<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait PriorityTrait
{
    protected static ?string $groupByField = null;

    public static function bootPriorityTrait()
    {
        static::creating(function (Model $model) {
            if ($model->priority === 0) {
                $query = static::query()->where('priority', '>=', 0);

                if (static::$groupByField && $model->{static::$groupByField}) {
                    $query->where(static::$groupByField, $model->{static::$groupByField});
                }

                $query->increment('priority');
            }
        });

        static::saving(function (Model $model) {
            if ($model->isDirty('priority')) {
                $oldPriority = $model->getOriginal('priority');
                $newPriority = $model->priority;

                if ($oldPriority !== null && $newPriority !== null) {
                    $query = static::query()->where('id', '!=', $model->id);

                    if (static::$groupByField && $model->{static::$groupByField}) {
                        $query->where(static::$groupByField, $model->{static::$groupByField});
                    }

                    if ($oldPriority < $newPriority) {
                        $query->whereBetween('priority', [$oldPriority + 1, $newPriority])
                            ->decrement('priority');
                    } elseif ($oldPriority > $newPriority) {
                        $query->whereBetween('priority', [$newPriority, $oldPriority - 1])
                            ->increment('priority');
                    }
                }
            }
        });
    }

    public static function setGroupByField(string $field): void
    {
        static::$groupByField = $field;
    }
}
