<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CourseManagementSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course-management:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Course Management Module Data Seed.';

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
        Artisan::call('db:seed', ['--class' => 'Module\CourseManagement\database\seeds\DatabaseSeeder']);

        $this->info('CourseManagement Module Data Seeded Successfully!');

        Artisan::call('migrate');
        $this->info('Migration Successfully!');
    }
}
