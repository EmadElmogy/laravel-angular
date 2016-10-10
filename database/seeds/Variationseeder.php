<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;


class Variationseeder extends CsvSeeder
{

  public function __construct()
    {
        $this->table = 'variations';
        $this->filename = base_path().'/database/seeds/csvs/variations.csv';
    }

    public function run()
    {


        // Uncomment the below to wipe the table clean before populating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        parent::run();
    }
}
