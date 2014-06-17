<?php
/**
 * Created by PhpStorm.
 * User: gertjan
 * Date: 06/11/13
 * Time: 18:05
 */

class UserTableSeeder extends Seeder
{
    public function run()
    {

        $administrator = [
            'email' => 'gert@gmail.be',
            'givenname' => 'Admin',
            'surname' => 'Istrator',
            'birthday' => '1992-01-20',
            'password' => 'admin',
            'chef' => 0,
            'role' => 'Administrator',
            'picture' => 'DKbbPS_oogkleppen.jpg',
            'blacklist' => 'false'
        ];

        $user = [
            'email' => 'gertjan@gmail.be',
            'givenname' => 'Gertjan',
            'surname' => 'Vermeir',
            'birthday' => '1992-01-20',
            'password' => 'admin',
            'chef' => 1,
            'role' => 'User',
            'picture' => 'DKbbPS_oogkleppen.jpg',
            'blacklist' => 'false'
        ];

        User::create($administrator);
        User::create($user);

    }
} 