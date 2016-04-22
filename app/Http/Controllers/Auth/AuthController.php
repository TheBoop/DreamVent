<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;

use DB;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\CustomUser;
use App\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:USER',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    
    protected  function create(array $data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = bcrypt($data['password']);
        

        $list[0] = "user_id";
        $list[1] = "friendlist";
        $list[2] = "followlist";
        $list[3] = "contactlist";
        $list[4] = "pagelist";
        $list[5] = "holder5";
        $list[6] = "holder6";
        $list[7] = "holder7";
        $list[8] = "holder8";
        $list[9] = "holder9";

        $namer = "Bob Ross";
          
        for ($i=0; $i < 10; $i++)
        {   
            $affected = DB::insert('insert into USER_LIST
                                (list_type) values 
                                (?)',
                                [$list[$i]]);
            //store_user_id_value
            $suv[$i] = intval(DB::getPdo()->lastInsertId());


        }
        /*

        $affected = DB::insert('insert into USER
                                (user_id, username, email, password, name, 
                                friendlist_id, followlist_id, contactlist_id, 
                                pagelist_id, holder_id5, holder_id6, holder_id7,
                                holder_id8, holder_id9 ) values 
                                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                                [$suv[0], $name, $email, $password, $namer, $suv[1],
                                 $suv[2], $suv[3], $suv[4], $suv[5], $suv[6], $suv[7], 
                                 $suv[8], $suv[9]]);

        */

        return User::create([
            'id' => $suv[0],
            'username' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $namer,
            'friendlistid' => $suv[1],
            'followlistid' => $suv[2],
            'contactlistid' => $suv[3],
            'pagelistid' => $suv[4],
            'holderid5' => $suv[5],
            'holderid6' => $suv[6],
            'holderid7' => $suv[7],
            'holderid8' => $suv[8],
            'holderid9' => $suv[9],//?
        ]);
    }
    


}
