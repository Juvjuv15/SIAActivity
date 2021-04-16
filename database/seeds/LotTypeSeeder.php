<?php

use Illuminate\Database\Seeder;

class LotTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lotTypes=[
            [
                'id'=>'1',
                'lotType'=>'Residential Lot',
            ],
            [
                'id'=>'2',
                'lotType'=>'Commercial Lot',

            ],
            [
                'id'=>'3',
                'lotType'=>'Agricultural Lot',

            ],
        ];
        DB::table('lottypes')->insert($lotTypes);
            }
    }

