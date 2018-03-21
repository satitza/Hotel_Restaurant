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
        $languages->language = 'ภาษาไทย';
        $languages->save();

        $languages = new App\Language;
        $languages->language = 'English';
        $languages->save();

        $languages = new App\Language;
        $languages->language = '中国';
        $languages->save();
    }
}
