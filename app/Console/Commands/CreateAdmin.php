<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {username} {email} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register admin to the database';


    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (!isset($password)) {
            $password = CreateAdmin::quickRandom(10);
        }

        $user = User::where('username', '=', $this->argument('username'));
        if ($user->exists()) {
            $this->warn('This user is already exists on database');
            if ($this->confirm('Do you want overwrite this user?')) {
                $user->update([
                    'password' => Hash::make($password),
                    'email' => $email,
                    'status' => 2,
                ]);
                $this->info('Done overwrite');
                $this->info('Password: ' . $password);
                $this->info('Email: ' . $email);
            }
        } else {
            $user = new User();

            $user->email = $email;
            $user->password = Hash::make($password);
            $user->status = 2;
            $user->username = $this->argument('username');

            $user->save();
            $this->info('successfuly created.');
            $this->info('password: ' . $password);
            $this->info('username: ' . $this->argument('username') . '\nemail: ' . $email);
        }
    }
}
