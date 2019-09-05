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
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Andrey',
            'email' => str_random(10).'@example.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Boris',
            'email' => str_random(10).'@example.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Vladimir',
            'email' => str_random(10).'@example.com',
            'password' => bcrypt('123456'),
        ]);



        DB::table('messages')->insert([
            'user_id' => 1,
            'text' => 'Акции НИИ из Новосибирска выставлены на торги',
            'created_at' => '2019-09-01 14:00:00',
        ]);

        DB::table('messages')->insert([
            'user_id' => 2,
            'text' => 'В Бердске уволилась начальник отдела по делам молодежи',
            'created_at' => '2019-09-02 14:00:00',
        ]);

        DB::table('messages')->insert([
            'user_id' => 3,
            'text' => 'В Центральном парке Новосибирска запускают светомузыкальный фонтан',
            'created_at' => '2019-09-03 14:00:00',
        ]);

        DB::table('messages')->insert([
            'user_id' => 1,
            'text' => 'Два самолета столкнулись в Толмачево при буксировке',
            'created_at' => '2019-09-03 15:00:00',
        ]);


    }
}
