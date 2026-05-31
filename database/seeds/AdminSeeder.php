<?php

use Illuminate\Database\Seeder;
use App\User;

use App\Models\StaffProfile;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reg_no = $this->generateCode(10);

        $reg_no ='QUK'.$reg_no.'CUS';
       $user= User::create([
          'email'=>'kingsleyohiaeri74@gmail.com',
          'phone'=>'2347045086558',
          'username'=>'kingsoe',
          'password'=>Hash::make(12345678),
          'user_type'=>"staff",
        ]);
        
        StaffProfile::create([
            'user_id'=>$user->id,
            'role'=>'MD',
            'reg_no'=>$reg_no
            ]);
    }
    
    
    public function generateCode($limit)
{
    $code="";
    for($i=0; $i<$limit; $i++)
    {
        $code .=mt_rand(0,9);
        
    }
    return $code;
}


}
