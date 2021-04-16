<?php

use Illuminate\Database\Seeder;

class RadiusRangeSeeder extends Seeder
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
                'radiusId'=>'1',
                'radiusdesc'=>'near',
                'radiuskm'=>10,
            ],
            [
                'radiusId'=>'2',
                'radiusdesc'=>'fair',
                'radiuskm'=>20,
            ],
        ];
    
    DB::table('radiusranges')->insert($criteria);
    }
}
