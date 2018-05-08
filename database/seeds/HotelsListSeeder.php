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
             'On 8 Sukhumvit',
             'Citin Pratunam',
             'Citrus Sukhumvit 11 Bangkok',
             'Citrus Sukhumvit 13 Bangkok',
             'Citrus Suites Sukhumvit 6 Bangkok',
             'Citrus Grande Pattaya',
             'Citrus Parc',
             'Admiral Premier',
             'Admiral Suites',
             'Aspen Suites',
             'Arcadia Suites',
             'Arcadia Residence',
             'Grand Swiss',
             'Legacy Suites',
             'Legacy Express',
             'Omni Tower',
             'The Key',
             'Nimman Mai',
             'Parasol',
             'Art Mai',
             'Galleria 10',
             'Galleria 12',
             'Adelphi Grande',
             'The Continent Hotel',
             'Citin MJ',
             'Citrus Hotel JB',
             'Citin Pudu',
             'Lion Hotel',
             'White Swan',
             'Columba',
             'Citrus Eastbourne',
             'Citrus Cheltemham',
             'Citrus Cardiff',
             'Lace Market',
             'Victoria Hotel Manchester',
             'Hawkwell House Oxford',
             'Citrus Coventry'

         ];

         foreach ($hotel_names as $name){
             $hotels = New App\Hotels();
             $hotels->hotel_name = $name;
             $hotels->active_id = 1;
             //$hotels->hotel_comment = '';
             $hotels->save();
         }

        /*for ($i = 1; $i < 50; $i++) {
            $status = 1;

            if ($i > 20) {
                $status = 2;
            }

        }*/


    }

}
