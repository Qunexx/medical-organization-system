<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Service;
use App\Models\Specialization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\RoleFactory;
use Database\Factories\ServiceFactory;
use Database\Factories\SpecializationFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        RoleFactory::new()->admin()->create();
        RoleFactory::new()->doctor()->create();
        RoleFactory::new()->support()->create();
        RoleFactory::new()->user()->create();
        UserFactory::new()->admin()->create();
        SpecializationFactory::new()->count(6)->create();
        ServiceFactory::new()->count(10)->create();
    }
}
