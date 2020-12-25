<?php


namespace Tests\Utils\Database;

use Database\Seeders\DatabaseSeeder;

trait WithSeeder
{
    public function seed()
    {
        (new DatabaseSeeder())->run();
    }
}
