<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model\Role;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        DB::table('roles')->insert([
            ['name' => config('constant.user_roles.admin')],
            ['name' => config('constant.user_roles.trainer')],
            ['name' => config('constant.user_roles.user')],
        ]);
        DB::table('category')->insert([
            ['category_name' => 'Muscle Group','category_desc' => 'growing muscle','category_image'=>'muscle_group.png'],
            ['category_name' => 'Program','category_desc' => 'essential programs','category_image'=>'program.png'],
            ['category_name' => 'Trainer','category_desc' => 'essential programs','category_image'=>'trainers.png'],
        ]);
        $role_admin = Role::where('name', config('constant.user_roles.admin'))->first();
        $admin = new User();
        $admin->first_name = 'admin';
        $admin->last_name = 'user';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('Qwerty@123');
        $admin->mobile_number = '1111111111';
        $admin->save();
        $admin->roles()->attach($role_admin->id);
        
        $roleTrainer = Role::where('name', config('constant.user_roles.trainer'))->first();
        $partner = new User();
        $partner->first_name = 'trainer';
        $partner->last_name = 'user';
        $partner->email = 'trainer_user@yopmail.com';
        $partner->password = Hash::make('Qwerty@123');
        $partner->mobile_number = '1211111111';
        $partner->save();
        $partner->roles()->attach($roleTrainer->id);
        
        $roleUser = Role::where('name', config('constant.user_roles.user'))->first();
        $user = new User();
        $user->first_name = 'admin';
        $user->last_name = 'user';
        $user->email = 'user@yopmail.com';
        $user->password = Hash::make('Qwerty@123');
        $user->mobile_number = '1231111111';
        $user->save();
        $user->roles()->attach($roleUser->id);


        Schema::enableForeignKeyConstraints();
    }

}
