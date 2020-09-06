<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Permission;
use App\Role;
use Cache;

class PermissionInitializeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes the defined permissions and roles in "config/permissions.php"';

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
        $storedPermissions = Permission::all();
        $configuredPermissions = config('permission.permissions', []);
        
        foreach($configuredPermissions as $permission => $label) {
            // Check if the configured permission already exists in database
            if($storedPermissions->contains('name', $permission)) {
                continue;
            }

            // Generate new permission
            $generatedPermission = Permission::create([
                'name' => $permission,
                'description' => $label
            ]);

            $this->info('New Permission Generated: #' . $generatedPermission->id . ' "' . $generatedPermission->name . ' "');

            $storedPermissions->push($generatedPermission);
        }

        $storedRoles = Role::all();
        $configuredRoles = config('permission.roles', []);

        foreach($configuredRoles as $role => $data) {
            // Check if the role does not exist in database
            if(!$storedRoles->contains('name', $role)) {
                // Create a new role
                $role = Role::create([
                    'name' => $role,
                    'description' => $data['description'],
                ]);

                $this->info('New Role Generated: #' . $role->id . ' "' . $role->name . ' "');
            } else {
                // Fetch the role from database
                $role = $storedRoles->where('name', $role)->first();
            }

            // Check if the role should have every avaliable permission linked
            if($data['permissions'] == '*') {
                // Syncs all permissions
                $role->permissions()->sync($storedPermissions);
            } else {
                // Get all permissions for the role 
                $permissions = $storedPermissions->whereIn('name', $data['permissions']);
                // Syncs fetched permissions
                $role->permissions()->sync($permissions);
            }

            $this->info('Permissions linked for Role "' . $role->name . '": ' . $role->permissions->pluck('name'));
        }

        Cache::flush();

        return 0;
    }
}
