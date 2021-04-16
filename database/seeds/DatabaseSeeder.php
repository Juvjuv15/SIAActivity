<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(LotTypeSeeder::class);
        $this->call(SellingTypeSeeder::class);
        $this->call(MonthsSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(TertiarySectorSeeder::class);
        $this->call(CriteriaSeeder::class);
        $this->call(EstabScoreSeeder::class);
        $this->call(PriceRangeSeeder::class);
        $this->call(PriceScoreSeeder::class);
        $this->call(RadiusRangeSeeder::class);
        $this->call(RadiusSeeder::class);
    }
}
