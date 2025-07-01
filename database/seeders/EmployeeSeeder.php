<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $departments = Department::all();

        foreach (range(1, 10000) as $i) {
            Employee::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->optional()->numerify(substr($faker->phoneNumber, 0, 15)),
                'position' => $faker->jobTitle,
                'salary' => $faker->randomFloat(2, 3000, 10000),
                'hired_at' => $faker->date(),
                'status' => $faker->randomElement(['active', 'inactive']),
                'department_id' => $departments->random()->id,
            ]);
        }
    }
}
