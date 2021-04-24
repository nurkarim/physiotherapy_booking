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
         $this->call(TimesSeeder::class);
         $this->call(create_users_seed::class);
         $this->call(AppointmentTypeSeed::class);
         $this->call(CountrySeed::class);
         $this->call(VatSeed::class);
         $this->call(create_days_seed::class);
         $this->call(create_menu_seed::class);
         $this->call(SubMenuSeed::class);
         $this->call(CategorySeed::class);
         $this->call(CompanySeed::class);
    }
}
