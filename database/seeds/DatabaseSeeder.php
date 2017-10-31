<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bucketlist;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $this->call('UserTableSeeder');
          factory(Bucketlist::class, 20)->create();
          factory(Item::class, 50)->create();
    }
}
