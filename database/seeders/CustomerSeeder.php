<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert(
            [
                'user_id'=> 3,
                'cust_name'=>'Maman Sulaiman',
                'cust_address'=>'Kudus',
                'cust_phone'=>'089776555443'
            ]
        );
    }
}
