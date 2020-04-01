<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = new App\User;
      $admin->username = "administrator";
      $admin->name = "Site Administrator";
      $admin->email = "administrator@larashop.test";
      $admin->roles = json_encode(["ADMIN"]);
      $admin->password = Hash::make("larashop");

      $admin->save();
      $this->command->info("User admin berhasil diinsert");
    }
}
