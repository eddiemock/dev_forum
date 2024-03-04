<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswords extends Command
{
    protected $signature = 'user:hash-passwords';
    protected $description = 'Hash existing plain-text passwords for users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to hash passwords...');

        User::query()
            ->whereRaw('length(password) < 60') // Assuming bcrypt is used; adjust length as necessary
            ->each(function ($user) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password hashed for user: {$user->email}");
            });

        $this->info('Completed hashing passwords.');
    }
}
