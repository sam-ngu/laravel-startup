<?php


namespace Tests\Utils\Database;


use Illuminate\Support\Facades\Artisan;

class Seeder
{
    public static function seed()
    {
        Artisan::call('db:seed');
    }
}
