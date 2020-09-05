<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(BookTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(StudyTableSeeder::class);
        $this->call(GradeTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
    }
}
