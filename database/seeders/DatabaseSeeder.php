<?php

namespace Database\Seeders;

use App\Models\MService;
use App\Models\MServiceCategory;
use App\Models\SettingWeb;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);



        MServiceCategory::insert([
                [
                    'name_service_categori' =>'Gel-X'
                ],
                [
                    'name_service_categori' =>'Builder Gel Overlay'
                ],
                [
                    'name_service_categori' =>'Removal'
                ],
                [
                    'name_service_categori' =>'Other Services'
                ],
        ]);

        MService::insert([
            [
                'name_service' => 'Short Set',
                'order' => 1,
                'price_service' => 75,
                'm_service_category_id' => 1
            ],
            [
                'name_service' => 'Medium Set',
                'order' => 2,
                'price_service' => 80,
                'm_service_category_id' => 1
            ],
            [
                'name_service' => 'Long Set',
                'order' => 3,
                'price_service' => 85,
                'm_service_category_id' => 1
            ],
            [
                'name_service' => 'Short',
                'order' => 1,
                'price_service' => 55,
                'm_service_category_id' => 2
            ],
            [
                'name_service' => 'Medium',
                'order' => 2,
                'price_service' => 60,
                'm_service_category_id' => 2
            ],
            [
                'name_service' => 'Long',
                'order' => 3,
                'price_service' => 65,
                'm_service_category_id' => 2
            ],
            [
                'name_service' => 'Removal',
                'order' => 1,
                'price_service' => 20,
                'm_service_category_id' => 3
            ],
            [
                'name_service' => 'Removal w/ Set',
                'order' => 2,
                'price_service' => 10,
                'm_service_category_id' => 3
            ],
            [
                'name_service' => 'Foreign Removal',
                'order' => 3,
                'price_service' => 30,
                'm_service_category_id' => 3
            ],
            [
                'name_service' => 'Foreign Removal w/ Set',
                'order' => 4,
                'price_service' => 25,
                'm_service_category_id' => 3
            ],
            [
                'name_service' => 'Basic Gel Manicure',
                'order' => 1,
                'price_service' => 50,
                'm_service_category_id' => 4
            ],
            [
                'name_service' => 'French Manicure',
                'order' => 2,
                'price_service' => 40,
                'm_service_category_id' => 4
            ],
            [
                'name_service' => 'Nail Designs',
                'order' => 3,
                'price_service' => 15,
                'm_service_category_id' => 4
            ],
        ]);

        MService::insert([
            [
                'name_service' => 'Fills',
                'order' => 4,
                'price_service' => 50,
                'is_merge' => 1,
                'm_service_category_id' => 1
            ]
            ]);


            SettingWeb::insert([
                [
                    'name' => 'Tax',
                    'value' => '0'
                ],
                [
                    'name' => 'Deposit',
                    'value' => '20'
                ],
                [
                    'name' => 'PaymentEmail',
                    'value' => 'maixesthetics@gmail.com'
                ],
                [
                    'name' => 'PaymentAccount',
                    'value' => 'maixesthetics'
                ],
                [
                    'name' => 'LimitDepositPayment_h',
                    'value' => '2'
                ],
                [
                    'name' => 'Currency',
                    'value' => '$'
                ],
                [
                    'name' => 'Address',
                    'value' => '1575 West 6th Avenue, Vancouver, British Columbia V6J1R1'
                ],
                [
                    'name' => 'gmapsLinks',
                    'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2603.5295883764643!2d-123.1401908!3d49.266361499999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x548673c86fe6431d%3A0xdf5b49dddbcddb5e!2s1575%20W%206th%20Ave%2C%20Vancouver%2C%20BC%20V6J%201R1%2C%20Canada!5e0!3m2!1sen!2sid!4v1736835948202!5m2!1sen!2sid'
                ],
                [
                    'name' => 'Gmaps',
                    'value' => 'https://maps.app.goo.gl/6hQSYyuvK3f2MuK97'
                ],
                [
                    'name' => 'instagram',
                    'value' => 'onlymainails'
                ],


            ]);
    }
}
