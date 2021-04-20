<?php

namespace Ignite\Users\Console;

use Ignite\Users\Database\Seeders\PermissionsTableSeeder;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetPermissions extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'system:set-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update laratrust permissions.';

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
     * Seed the users_permissions table. Takes permissions from laratrust.php config of every module
     */
    public function handle()
    {
        \Artisan::call("cache:clear");

        $this->info('Divergents will receive all powers. Taking care of the aliens....');

        (new PermissionsTableSeeder)->run();

        $this->info('All aliens kept in their respective factions.');
    }
}
