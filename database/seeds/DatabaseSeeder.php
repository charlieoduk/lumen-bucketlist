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
          factory(User::class, 3)->create();
          factory(Bucketlist::class, 50)->create();
          factory(Item::class, 20)->create();
    }
}
