<?php

namespace Database\Seeders;

use App\Models\UserComments;
use Illuminate\Database\Seeder;

class UserCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserComments::factory(1)->create();
    }
}
