<?php


namespace Tests\Utils\Database;

use Illuminate\Support\Facades\Artisan;

trait WithSeeder
{
    public function seed()
    {
        Artisan::call('db:seed');
    }
}
