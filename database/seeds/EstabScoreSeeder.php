<?php

use Illuminate\Database\Seeder;

class EstabScoreSeeder extends Seeder
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
                'eId'=>'1',
                'estab'=>'convenience_store',
                'escore'=>1,
            ],
            [
                'eId'=>'2',
                'estab'=>'home_goods_store',
                'escore'=>2,
            ],
            [
                'eId'=>'3',
                'estab'=>'department_store',
                'escore'=>3,
            ],
            [
                'eId'=>'4',
                'estab'=>'pharmacy',
                'escore'=>4,
            ],
            [
                'eId'=>'5',
                'estab'=>'police',
                'escore'=>5,
            ],
            [
                'eId'=>'6',
                'estab'=>'fire_station',
                'escore'=>6,
            ],
            [
                'eId'=>'7',
                'estab'=>'hospital',
                'escore'=>7,
            ],
            [
                'eId'=>'8',
                'estab'=>'school',
                'escore'=>8,
            ],
        ];
    
    DB::table('estabscores')->insert($criteria);
    }
}
