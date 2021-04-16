<?php

use Illuminate\Database\Seeder;

class RadiusSeeder extends Seeder
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
                'rId'=>'1',
                'rdesc'=>'near',
                'rscore'=>100,
            ],
            [
                'rId'=>'2',
                'rdesc'=>'fair',
                'rscore'=>67,
            ],
            [
                'rId'=>'3',
                'rdesc'=>'far',
                'rscore'=>33,
            ],
        ];
    
    DB::table('radiusscores')->insert($criteria);
    }
}
