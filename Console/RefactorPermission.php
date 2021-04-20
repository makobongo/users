<?php

namespace Ignite\Users\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RefactorPermission extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'system:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "changes the permission authority from Asgard's default sentinel to Laratrust";

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
     * @return mixed
     */
    public function handle()
    {
        //1. Create laratrust tables
        $this->info("----> Migrating laratrust tables");

        Artisan::call("module:migrate", [ "module" => "users" ]);

        $this->info("Done :)");

        //2. Seed the laratrust roles table, add a sudo user
        $this->info("----> Seeding users and creating sudoers");

        Artisan::call("module:seed", [ "module" => "users" ]);

        $this->info("Done :)");

        //3. Set the permissions defined in laratrust config files
        $this->info("----> Setting permissions from config files");

        Artisan::call("collabmed:set-permissions");

        $this->info("Done :)");
    }
}
