<?php

namespace Database\Seeders;


use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run ()
    {
        $group = Group::factory()->create([
            'name' => 'head',
        ]);

        $headGroupId = $group->getAttribute('id');

        Group::factory()->create([
            'name' => 'employee',
            'default' => true,
        ]);

        $user = \App\Models\User::factory()->create([
            'email' => 'head@mgtest.ru',
        ]);

        $headUserId = $group->getAttribute('id');

        \App\Models\UserGroup::factory()->create([
            'user_id' => $headUserId,
            'group_id' => $headGroupId,
        ]);
    }
}
