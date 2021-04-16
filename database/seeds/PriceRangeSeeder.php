<?php

use Illuminate\Database\Seeder;

class PriceRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criteria=[
            [
                'rangeId'=>'1',
                'rangedesc'=>'low',
                'rangescore'=>'-500',
            ],
            [
                'rangeId'=>'2',
                'rangedesc'=>'fair',
                'rangescore'=>'500',
            ],
        ];
    
        DB::table('priceranges')->insert($criteria);
    }
}
