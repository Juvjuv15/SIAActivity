<?php

use Illuminate\Database\Seeder;

class PriceScoreSeeder extends Seeder
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
                'pId'=>'1',
                'pdesc'=>'low',
                'pscore'=>100,
            ],
            [
                'pId'=>'2',
                'pdesc'=>'fair',
                'pscore'=>67,
            ],
            [
                'pId'=>'3',
                'pdesc'=>'high',
                'pscore'=>33,
            ],
        ];
    
    DB::table('pricescores')->insert($criteria);
    }
}
