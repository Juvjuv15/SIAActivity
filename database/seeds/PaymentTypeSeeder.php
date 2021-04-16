<?php

use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymenttypes=[
            [
                'id'=>'1',
                'paymentType'=>'Monthly'
            ],
            [
                'id'=>'2',
                'paymentType'=>'Quarterly'
            ],
            [
                'id'=>'3',
                'paymentType'=>'Semi-Annual'
            ],
            [
                'id'=>'4',
                'paymentType'=>'Anually'
            ],
        ];
        DB::table('paymenttypes')->insert($paymenttypes);

    }
}
