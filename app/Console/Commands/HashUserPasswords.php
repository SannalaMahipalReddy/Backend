<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:hash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hashes all plain-text user passwords in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch users where the password is plain-text
        // You may need a condition to detect plain-text passwords
        $users = User::all();  // Adjust this if necessary

        foreach ($users as $user) {
            // If the password is not hashed, hash it
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password hashed for user ID: {$user->id}");
            }
        }

        $this->info('All plain-text passwords have been hashed.');
    }
}
