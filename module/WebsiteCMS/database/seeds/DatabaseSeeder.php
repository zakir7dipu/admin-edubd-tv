<?php

namespace Module\WebsiteCMS\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\database\seeds\AboutTableSeeder;
use Module\WebsiteCMS\database\seeds\BecomeInstructorTableSeeder;
use Module\WebsiteCMS\database\seeds\PrivacyPolicyTableSeeder;
use Module\WebsiteCMS\database\seeds\ReturnAndRefundPolicyTableSeeder;
use Module\WebsiteCMS\database\seeds\SiteInfosTableSeeder;
use Module\WebsiteCMS\database\seeds\SupportTableSeeder;
use Module\WebsiteCMS\database\seeds\TermsAndConditionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SiteInfosTableSeeder::class,
            AboutTableSeeder::class,
            SupportTableSeeder::class,
            ReturnAndRefundPolicyTableSeeder::class,
            PrivacyPolicyTableSeeder::class,
            TermsAndConditionTableSeeder::class,
            BecomeInstructorTableSeeder::class
        ]);
    }
}
