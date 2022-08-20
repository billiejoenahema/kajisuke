<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $name . '@example.com';
        $password = str()->random(random_int(16, 32));

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('user email: ' . $email);
        $this->info('user password: ' . $password);
    }
}
