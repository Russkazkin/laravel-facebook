<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'ruslan@skazkin.su')->first();

        if(!$user) {
            User::create([
                'name' => 'admin',
                'email' => 'ruslan@skazkin.su',
                'password' => '$2y$10$Hv7RJYtTrhrSTcgFVKcz0.aUfVWkQIBB13BpTbHTrknSkwgpQzvim',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        factory(User::class, 5)->create();
    }
}
