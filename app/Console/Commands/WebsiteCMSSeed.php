<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class WebsiteCMSSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website-cms:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Website CMS Module Data Seed.';

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
        Artisan::call('db:seed', ['--class' => 'Module\WebsiteCMS\database\seeds\DatabaseSeeder']);

        $this->info('WebsiteCMS Module Data Seeded Successfully!');
    }
}
