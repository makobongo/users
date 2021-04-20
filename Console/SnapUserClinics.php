<?php

namespace Ignite\Users\Console;

use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SnapUserClinics extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'system:snap-user-clinics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user clinics to their new found home.';

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
        $this->info('Started moving user clinics to their new destination. Moving records from clinics (users_user_profiles) to a pivot table');

        $count = $notFixed = 0;

        User::chunk(300, function($users) use (&$count, &$notFixed) {
            foreach($users as $item) {
                $userClinics = $item->profile->clinics; // will be cast to an array automatically via $casts

                if($userClinics)
                {
                    $clinics = Clinics::whereIn("id", $userClinics)->pluck("id")->all();

                    $item->clinics()->sync($clinics);

                    if($item->clinics()->sync($clinics))
                    {
                        $count++;
                    } else {
                        $notFixed++;
                    }
                }
                else {
                    $notFixed++;
                }

            }
        });

        $this->info('Well, looks like we\'re done here! Records affected: ' . $count. '. Unaffected: ' . $notFixed);

    }
}
