<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = new App\Language;
        $languages->language = 'TH';
        $languages->save();

        $languages = new App\Language;
        $languages->language = 'EN';
        $languages->save();

        $languages = new App\Language;
        $languages->language = 'CN';
        $languages->save();
    }
}
