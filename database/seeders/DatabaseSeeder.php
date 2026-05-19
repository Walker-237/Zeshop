<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolesSeeder::class);

        $user = User::query()->updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email_verified_at' => now(),
            'gender' => 'male',
            'password' => Hash::make('password'),
            'tel' => '+237600000000',
        ]);

        $user->syncRoles([config('shopper.core.users.admin_role')]);
    }
}
