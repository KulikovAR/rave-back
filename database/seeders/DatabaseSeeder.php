<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(ShortSeeder::class);
        $this->call(AnnounceSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
