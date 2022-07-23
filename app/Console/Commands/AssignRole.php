<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:role {user} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Role to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));

        $role = Role::where("name", $this->argument('role'))->first();

        $user->assignRole($role);

        $this->comment("Assign role Success");
    }
}
