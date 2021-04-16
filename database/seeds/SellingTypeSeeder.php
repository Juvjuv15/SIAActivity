<?php

use Illuminate\Database\Seeder;

class SellingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sellingTypes=[
            [
                'id'=>'1',
                'sellingType'=>'For Sale',
            ],
            // [
            //     'id'=>'2',
            //     'sellingType'=>'For Rent',

            // ],
            [
                'id'=>'2',
                'sellingType'=>'For Lease',

            ],
            
        ];
        DB::table('sellingtypes')->insert($sellingTypes);
    }
}
