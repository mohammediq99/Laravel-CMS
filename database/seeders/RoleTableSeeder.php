<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Role;
use \App\Models\User;
use Carbon\Carbon;
use Faker\Factory;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        // user - editor - admin
        $adminRole = Role::create(['name' => 'admin' , 'display_name' => 'Administrator' , 'description' => 'System Administrator' , 'allowed_route' => 'admin']);
        $editorRole = Role::create(['name' => 'editor' , 'display_name' => 'Editor' , 'description' => 'System Edotor' , 'allowed_route' => 'admin']);
        $userRole = Role::create(['name' => 'user' , 'display_name' => 'User' , 'description' => 'normail User' , 'allowed_route' => null]);
    $admin = User::create([
        'name' => 'admin',
        'username' => 'admin',
        'email' => 'admin@cms.com',
        'mobile' => '07832847233',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::create('123456789'),
        'status' => 1,
        ]);
        $admin->attachRole($adminRole);
        $editor = User::create([
            'name' => 'editor',
            'username' => 'editor',
            'email' => 'editor@cms.com',
            'mobile' => '02832847233',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::create('123456789'),
            'status' => 1,
            ]);
            $editor->attachRole($editorRole);
            $user1 = User::create([
                'name' => 'user1',
                'username' => 'user1',
                'email' => 'user1@cms.com',
                'mobile' => '02832841233',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::create('123456789'),
                'status' => 1,
                ]);
                $user1->attachRole($userRole);
                $user2 = User::create([
                    'name' => 'user2',
                    'username' => 'user2',
                    'email' => 'user2@cms.com',
                    'mobile' => '02822847233',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::create('123456789'),
                    'status' => 1,
                ]);
                $user->attachRole($userRole);
                $user = User::create([
                        'name' => 'user3',
                        'username' => 'user3',
                        'email' => 'user3@cms.com',
                        'mobile' => '02821847233',
                        'email_verified_at' => Carbon::now(),
                        'password' => Hash::create('123456789'),
                        'status' => 1,
                ]);
                $user->attachRole($userRole);
               for ($i=0; $i < 20 ; $i++) { 
                  
                $user  = User::create([
                    'name' => $faker->name,
                    'username' => $faker->UserName,
                    'email' =>   $faker->email,
                    'mobile' => random_int(10000000 , 99999999),
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::create('123456789'),
                    'status' => 1,
            ]);
            $user->attachRole($userRole);
               } 
    }
}
