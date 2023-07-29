<?php

namespace App\Services;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrationService extends Migration
{

    public function registerDoctrineEnumType(): void
    {
        //for Filament and DBAL auto type recognition
        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }
}