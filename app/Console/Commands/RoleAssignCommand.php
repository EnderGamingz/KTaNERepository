<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Role;

class RoleAssignCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns the role for a user';

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
        // Ask for the user id
        $userId = $this->ask('Please specify the user id');
        // Try to fetch the user
        $user = User::find($userId);

        // Check if the user exists
        if(!$user) {
            $this->error('User with id #' . $userId . ' could not be found');
            return -1; 
        }

        // Ask for the role name
        $roleName = $this->ask('Please specify the role you want to assign to user #'. $user->id);
        // Try to fetch the role name
        $role = Role::where('name', $roleName)->first();

        // Check if the role exists
        if(!$role) {
            $this->error('Role with name "' . $roleName . '" could not be found');
            return -1;
        }

        // Attaching the role to the user
        $user->roles()->attach($role);
        $this->info('Role has been successfully attached');

        return 0;
    }
}
