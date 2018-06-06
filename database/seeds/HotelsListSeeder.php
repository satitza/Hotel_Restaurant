<?php

use Illuminate\Database\Seeder;

class HotelsListSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel_names = [
            'Adelphi Grande', //1
            'Admiral Premier', //2
            'Admiral Suites', //3
            'Arcadia Residence', //4
            'Arcadia Suites', //5
            'Art Mai Gallery Hotel', //6
            'Aspen Suites', //7
            'Best Western Plus Milford', //8
            'Best Western Queens Dundee', //9
            'Citin Masjid Jamek', //10
            'Citin Pratunam', //11
            'Citin Pudu', //12
            'Citrus Cardiff', //13
            'Citrus Cheltemham', //14
            'Citrus Coventry', //15
            'Citrus Eastbourne', //16
            'Citrus Grande Pattaya', //17
            'Citrus Johor Bahru', //18
            'Citrus Parc', //19
            'Citrus Suites Sukhumvit 6 Bangkok', //20
            'Citrus Sukhumvit 11 Bangkok', //21
            'Citrus Sukhumvit 13 Bangkok', //22
            'Columba', //23
            'Compass Skyview', //24
            'Crown Spa Hotel', //25
            'Galleria 10', //26
            'Galleria 12', //27
            'Go Glasgow Hotel', //28
            'Grand Swiss', //29
            'Hawkwell House Oxford', //30
            'Lace Market', //31
            'Legacy Express', //32
            'Legacy Suites', //33
            'Lion Hotel', //34
            'Nimman Mai', //35
            'Omni Tower', //36
            'On 8 Sukhumvit', //37
            'Parasol', //38
            'The Continent Hotel', //39
            'The Key Premier', //40
            'Victoria Hotel Manchester', //41
            'White Swan' //42
        ];

        foreach ($hotel_names as $name) {
            $hotels = New App\Hotels();
            $hotels->hotel_name = $name;
            $hotels->active_id = 1;
            //$hotels->hotel_comment = '';
            $hotels->save();
        }
    }

}
