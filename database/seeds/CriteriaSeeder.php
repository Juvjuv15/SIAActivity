<?php

use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
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
                'cId'=>'1',
                'cdesc'=>'pricereasonability',
                'cscore'=>40,
            ],
            [
                'cId'=>'2',
                'cdesc'=>'establishment',
                'cscore'=>30,
            ],
            [
                'cId'=>'3',
                'cdesc'=>'userpreference',
                'cscore'=>20,
            ],
            [
                'cId'=>'4',
                'cdesc'=>'proximity',
                'cscore'=>10,
            ],
        ];
    
    DB::table('criterias')->insert($criteria);
    
        }
}
