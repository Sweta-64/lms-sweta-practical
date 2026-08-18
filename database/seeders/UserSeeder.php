<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'department' => 'Administration',
        ]);

        // Create Employee Users
        $employee1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@lms.com',
            'password' => bcrypt('password123'),
            'role' => 'employee',
            'department' => 'IT',
        ]);

        $employee2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@lms.com',
            'password' => bcrypt('password123'),
            'role' => 'employee',
            'department' => 'HR',
        ]);

        $employee3 = User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@lms.com',
            'password' => bcrypt('password123'),
            'role' => 'employee',
            'department' => 'Finance',
        ]);

        // Create sample leaves
        Leave::create([
            'user_id' => $employee1->id,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'type' => 'personal',
            'reason' => 'Family gathering and personal matters',
            'status' => 'approved',
            'approved_by' => $admin->id,
        ]);

        Leave::create([
            'user_id' => $employee1->id,
            'start_date' => now()->addDays(15)->toDateString(),
            'end_date' => now()->addDays(17)->toDateString(),
            'type' => 'sick',
            'reason' => 'Medical checkup and recovery',
            'status' => 'pending',
        ]);

        Leave::create([
            'user_id' => $employee2->id,
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'type' => 'vacation',
            'reason' => 'Vacation with family to hill station',
            'status' => 'approved',
            'approved_by' => $admin->id,
        ]);

        Leave::create([
            'user_id' => $employee2->id,
            'start_date' => now()->addDays(20)->toDateString(),
            'end_date' => now()->addDays(22)->toDateString(),
            'type' => 'personal',
            'reason' => 'Personal emergency',
            'status' => 'rejected',
            'approved_by' => $admin->id,
            'remarks' => 'Insufficient notice period. Please reapply with more advance notice.',
        ]);

        Leave::create([
            'user_id' => $employee3->id,
            'start_date' => now()->addDays(8)->toDateString(),
            'end_date' => now()->addDays(9)->toDateString(),
            'type' => 'sick',
            'reason' => 'Flu and rest required',
            'status' => 'pending',
        ]);
    }
}

