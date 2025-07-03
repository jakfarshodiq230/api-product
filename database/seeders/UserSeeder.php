<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // Insert all user data here following the structure
            // Example for first user:
            [
                'first_name' => 'Emily',
                'last_name' => 'Johnson',
                'maiden_name' => 'Smith',
                'age' => 28,
                'gender' => 'female',
                'email' => 'emily.johnson@x.dummyjson.com',
                'phone' => '+81 965-431-3024',
                'username' => 'emilys',
                'password' => bcrypt('emilyspass'),
                'birth_date' => '1996-5-30',
                'image' => 'https://dummyjson.com/icon/emilys/128',
                'blood_group' => 'O-',
                'height' => 193.24,
                'weight' => 63.16,
                'eye_color' => 'Green',
                'ip' => '42.48.100.32',
                'mac_address' => '47:fa:41:18:ec:eb',
                'university' => 'University of Wisconsin--Madison',
                'ein' => '977-175',
                'ssn' => '900-590-289',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
                'role' => 'admin',
                'hair' => [
                    'color' => 'Brown',
                    'type' => 'Curly'
                ],
                'address' => [
                    'address' => '626 Main Street',
                    'city' => 'Phoenix',
                    'state' => 'Mississippi',
                    'state_code' => 'MS',
                    'postal_code' => '29112',
                    'country' => 'United States',
                    'coordinates' => [
                        'lat' => -77.16213,
                        'lng' => -92.084824
                    ]
                ],
                'bank' => [
                    'card_expire' => '03/26',
                    'card_number' => '9289760655481815',
                    'card_type' => 'Elo',
                    'currency' => 'CNY',
                    'iban' => 'YPUXISOBI7TTHPK2BR3HAIXL'
                ],
                'company' => [
                    'department' => 'Engineering',
                    'name' => 'Dooley, Kozey and Cronin',
                    'title' => 'Sales Manager',
                    'address' => [
                        'address' => '263 Tenth Street',
                        'city' => 'San Francisco',
                        'state' => 'Wisconsin',
                        'state_code' => 'WI',
                        'postal_code' => '37657',
                        'country' => 'United States',
                        'coordinates' => [
                            'lat' => 71.814525,
                            'lng' => -161.150263
                        ]
                    ]
                ],
                'crypto' => [
                    'coin' => 'Bitcoin',
                    'wallet' => '0xb9fc2fe63b2a6c003f1c324c3bfa53259162181a',
                    'network' => 'Ethereum (ERC20)'
                ]
            ],
            // Add all other users in the same format
        ];

        foreach ($users as $userData) {
            $user = User::create(Arr::except($userData, ['hair', 'address', 'bank', 'company', 'crypto']));

            // Create hair record
            $user->hair()->create($userData['hair']);

            // Create address with coordinates
            $address = $user->address()->create(Arr::except($userData['address'], ['coordinates']));
            $address->coordinates()->create($userData['address']['coordinates']);

            // Create bank record
            $user->bank()->create($userData['bank']);

            // Create company with address and coordinates
            $company = $user->company()->create(Arr::except($userData['company'], ['address']));
            $companyAddress = $company->address()->create(Arr::except($userData['company']['address'], ['coordinates']));
            $companyAddress->coordinates()->create($userData['company']['address']['coordinates']);

            // Create crypto record
            $user->crypto()->create($userData['crypto']);
        }
    }
}

