<?php

use Illuminate\Database\Seeder;

class MonthsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $months=[
            [
                'id'=>'1',
                'month'=>'1 month'
            ],
            [
                'id'=>'2',
                'month'=>'2 months'
            ],
            [
                'id'=>'3',
                'month'=>'3 months'
            ],
            [
                'id'=>'4',
                'month'=>'4 months'
            ],
            [
                'id'=>'5',
                'month'=>'5 months'
            ],
            [
                'id'=>'6',
                'month'=>'6 months'
            ],
            [
                'id'=>'7',
                'month'=>'7 months'
            ],
            [
                'id'=>'8',
                'month'=>'8 months'
            ],
            [
                'id'=>'9',
                'month'=>'9 months'
            ],
            [
                'id'=>'10',
                'month'=>'10 months'
            ],
            [
                'id'=>'11',
                'month'=>'11 months'
            ],
            [
                'id'=>'12',
                'month'=>'12 months'
            ],
            [
                'id'=>'13',
                'month'=>'2 years'
            ],
            [
                'id'=>'14',
                'month'=>'3 years'
            ],
            [
                'id'=>'15',
                'month'=>'4 years'
            ],
            [
                'id'=>'16',
                'month'=>'5 years'
            ],
            [
                'id'=>'17',
                'month'=>'6 years'
            ],
            [
                'id'=>'18',
                'month'=>'7 years'
            ],
            [
                'id'=>'19',
                'month'=>'8 years'
            ],
            [
                'id'=>'20',
                'month'=>'9 years'
            ],
            [
                'id'=>'21',
                'month'=>'10 years'
            ],
            [
                'id'=>'22',
                'month'=>'11 years'
            ],
            [
                'id'=>'23',
                'month'=>'12 years'
            ],
            [
                'id'=>'24',
                'month'=>'13 years'
            ],
            [
                'id'=>'25',
                'month'=>'14 years'
            ],
            [
                'id'=>'26',
                'month'=>'15 years'
            ],
            [
                'id'=>'27',
                'month'=>'16 years'
            ],
            [
                'id'=>'28',
                'month'=>'17 years'
            ],
            [
                'id'=>'29',
                'month'=>'18 years'
            ],
            [
                'id'=>'30',
                'month'=>'19 years'
            ],
            [
                'id'=>'31',
                'month'=>'20 years'
            ],
           
        ];
        DB::table('months')->insert($months);
            }
}
