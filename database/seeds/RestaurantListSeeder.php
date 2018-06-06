<?php

use Illuminate\Database\Seeder;

class RestaurantListSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $restaurants = [
            ['restaurant_name' => '180 Degree', 'restaurant_email' => 'enquiry@grandswissbangkok.com', 'hotel_id' => 29],
            ['restaurant_name' => '@G', 'restaurant_email' => 'enquiry@galleriatenbangkok.com', 'hotel_id' => 26],
            ['restaurant_name' => 'Avenue', 'restaurant_email' => 'enquiry@grandswissbangkok.com', 'hotel_id' => 29],
            ['restaurant_name' => 'Axis & Spin', 'restaurant_email' => 'rsvns@thecontinenthotel.com', 'hotel_id' => 39],
            ['restaurant_name' => 'Bangkok Heights', 'restaurant_email' => 'rsvns@thecontinenthotel.com', 'hotel_id' => 39],
            ['restaurant_name' => 'Beats', 'restaurant_email' => 'enquiry@citrussuitessukhumvit.com', 'hotel_id' => 20],
            ['restaurant_name' => 'Bodega', 'restaurant_email' => 'enquiry@arcadiasuites.com', 'hotel_id' => 5],
            ['restaurant_name' => 'Bridge Restaurant', 'restaurant_email' => 'enquiry@citrushotelcoventry.co.uk', 'hotel_id' => 15],
            ['restaurant_name' => 'CITIN CAFÉ (Citin Masjid Jamek)', 'restaurant_email' => 'enquiry@citinmj.com', 'hotel_id' => 10],
            ['restaurant_name' => 'CITIN CAFÉ (Citin Seacare Pudu)', 'restaurant_email' => 'enquiry@citinpudu.com', 'hotel_id' => 12],
            ['restaurant_name' => 'CITRUS CAFE (Citrus Johor Bahru)', 'restaurant_email' => 'enquiry@citrushoteljb.com', 'hotel_id' => 18],
            ['restaurant_name' => 'COCK AND HOOP PUB', 'restaurant_email' => 'enquiry@lacemarkethotel.co.uk', 'hotel_id' => 31],
            ['restaurant_name' => 'Cafe', 'restaurant_email' => 'enquiry@citrus13bangkok.com', 'hotel_id' => 22],
            ['restaurant_name' => 'GoGrill Restaurant', 'restaurant_email' => 'res@goglasgowhotel.com', 'hotel_id' => 28],
            ['restaurant_name' => 'Hotel Bar & Lounge (Hawkwell House)', 'restaurant_email' => 'enquiry@hawkwellhouse.co.uk', 'hotel_id' => 30],
            ['restaurant_name' => 'Hotel Bar (Best Western Plus Milford)', 'restaurant_email' => 'enquiries@mlh.co.uk', 'hotel_id' => 8],
            ['restaurant_name' => 'Hotel Lounge (Columba)', 'restaurant_email' => 'enquiry@columbahotelinverness.co.uk', 'hotel_id' => 23],
            ['restaurant_name' => 'Hotel Lounge (Victoria Hotel Manchester)', 'restaurant_email' => 'enquiry@thevictoriamanchester.com', 'hotel_id' => 41],
            ['restaurant_name' => 'Hotel Lounge (White Swan)', 'restaurant_email' => 'enquiry@whiteswanhalifax.com', 'hotel_id' => 42],
            ['restaurant_name' => 'Iffley Blue', 'restaurant_email' => 'enquiry@hawkwellhouse.co.uk', 'hotel_id' => 30],
            ['restaurant_name' => 'Jarid', 'restaurant_email' => 'enquiry@artmaigalleryhotel.com', 'hotel_id' => 6],
            ['restaurant_name' => 'Leap Frog', 'restaurant_email' => 'enquiry@galleriatenbangkok.com', 'hotel_id' => 26],
            ['restaurant_name' => 'MERCHANTS RESTAURANT', 'restaurant_email' => 'enquiry@lacemarkethotel.co.uk', 'hotel_id' => 31],
            ['restaurant_name' => 'Mr. Brown`s Restaurant', 'restaurant_email' => 'enquiry@thevictoriamanchester.com', 'hotel_id' => 41],
            ['restaurant_name' => 'MacNabs Bar and Bistro', 'restaurant_email' => 'enquiry@columbahotelinverness.co.uk', 'hotel_id' => 23],
            ['restaurant_name' => 'Medinii', 'restaurant_email' => 'rsvns@thecontinenthotel.com', 'hotel_id' => 39],
            ['restaurant_name' => 'Mojjo', 'restaurant_email' => 'enquiry@compassskyviewhotel.com', 'hotel_id' => 24],
            ['restaurant_name' => 'Munch', 'restaurant_email' => 'enquiry@citrus11sukhumvit.com', 'hotel_id' => 21],
            ['restaurant_name' => 'Pitstop', 'restaurant_email' => 'rsvns@thekeybangkok.com', 'hotel_id' => 40],
            ['restaurant_name' => 'Pitz', 'restaurant_email' => 'rsvns@thekeybangkok.com', 'hotel_id' => 40],
            ['restaurant_name' => 'Prime & Prime', 'restaurant_email' => 'enquiry@compassskyviewhotel.com', 'hotel_id' => 24],
            ['restaurant_name' => 'Q-Bar & Eatery', 'restaurant_email' => 'enquiries@queenshotel-dundee.com', 'hotel_id' => 9],
            ['restaurant_name' => 'Rodeo', 'restaurant_email' => 'enquiry@citrusgrandepattaya.com', 'hotel_id' => 17],
            ['restaurant_name' => 'SAINT BAR', 'restaurant_email' => 'enquiry@lacemarkethotel.co.uk', 'hotel_id' => 31],
            ['restaurant_name' => 'Shiso', 'restaurant_email' => 'enquiry@admiralpremier.com', 'hotel_id' => 2],
            ['restaurant_name' => 'Spice', 'restaurant_email' => 'enquiry@citrusgrandepattaya.com', 'hotel_id' => 17],
            ['restaurant_name' => 'Tabloid Bistro', 'restaurant_email' => 'enquiry@galleria12bangkok.com', 'hotel_id' => 27],
            ['restaurant_name' => 'Taste Restaurant', 'restaurant_email' => 'info@crownspahotel.com', 'hotel_id' => 25],
            ['restaurant_name' => 'Terrace', 'restaurant_email' => 'enquiry@nimmanmaihotel.com', 'hotel_id' => 35],
            ['restaurant_name' => 'The Hayward', 'restaurant_email' => 'enquiry@thelionhotelshrewsbury.com', 'hotel_id' => 34],
            ['restaurant_name' => 'The Oak Bar', 'restaurant_email' => 'enquiry@thelionhotelshrewsbury.com', 'hotel_id' => 34],
            ['restaurant_name' => 'Vanilla Sky & Club', 'restaurant_email' => 'enquiry@compassskyviewhotel.com', 'hotel_id' => 1],
            ['restaurant_name' => 'Victoria Restaurant', 'restaurant_email' => 'enquiry@columbahotelinverness.co.uk', 'hotel_id' => 23],
            ['restaurant_name' => 'Watermill Bat & Restaurant', 'restaurant_email' => 'enquiries@mlh.co.uk', 'hotel_id' => 8]
        ];

        foreach ($restaurants as $res) {
            $restaurant = New App\Restaurants();
            $restaurant->restaurant_name = $res['restaurant_name'];
            $restaurant->restaurant_email = $res['restaurant_email'];
            $restaurant->hotel_id = $res['hotel_id'];
            $restaurant->active_id = '1';
            //$restaurant->restaurant_comment = '';
            $restaurant->save();
        }
    }
}
