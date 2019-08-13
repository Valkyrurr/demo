<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // TODO: this will conflict with TenantController (User::find(1)), overwriting values
        // is likely not to happen if User model uses 'tenant' connection instead
        $user = new App\User();
        $user->name = 'Administrator';
        $user->password = Hash::make('123456');
        $user->email = 'web@master.com';
        $user->save();
    }
}
