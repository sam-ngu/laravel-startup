<?php


namespace Tests\Utils\Database;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Artisan;

trait WithSeeder
{
    public function seed()
    {
        (new DatabaseSeeder())->run();
    }
}
