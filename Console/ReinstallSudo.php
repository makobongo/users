<?php

namespace Ignite\Users\Console;

use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\Permission;
use Ignite\Users\Entities\Role;
use Ignite\Users\Entities\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReinstallSudo extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'system:reinstall-sudo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For some reason when upgrading csp is not seeding permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("\n\n This is one time thing \n\n");

        $this->info('Fetch/creating sudo user');
        $sudo = User::firstOrCreate(['username' => 'sudo']); //  fetch sudo user

        $sudo_role = Role::firstOrCreate(['name' => 'sudo']); // fetch sudo role

        $this->info('Attach role sudo if not existing');
        if(!$sudo->hasRole('sudo')) {
            $sudo->attachRole($sudo_role);
        }

        $this->info("\n Getting permissions ........... ");
        $permissions = Permission::get()->pluck('id'); // get all permissions

        $this->info('sync permissions');
        $sudo_role->syncPermissions($permissions); // assign all the permissions to this role(sudo)

        $this->info('assign clinic');
        $clinic = Clinics::first();

        $user_clinics = json_decode($sudo->profile->clinics);

        if(!in_array($clinic->id, $user_clinics))
        {
            $sudo->profile()->create([
                'clinics' => $clinic->id
            ]);
        }
    }
}
