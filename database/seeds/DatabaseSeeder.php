<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(QuestionsTableSeeder::class);
        $this->call(TestsTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(AwardsTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
    }
}