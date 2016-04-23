<?php
namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use DB;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
    protected $loginPath = '/';
    protected $redirectAfterLogout = '/';
    protected $redirectPath = '/frontpages';
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //be careful of spaces
        //unique:Table, column
        return Validator::make($data, [
            'username' => 'required|max:255|unique:USER,username',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:USER,email',
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
        DB::getQueryLog();
        $username = $data['username'];
        $name = $data['name'];
        $email = $data['email'];
        $password = bcrypt($data['password']);
        
        //this currently is incorrect. but ill leave it hear for temp use
        //this is suppose to insert after User create I believe create
        //create a model for this and insert after User::create
        //I need this to happen after user is valid... dont know how to do
        //that right now

        $list[0] = "friendlist";
        $list[1] = "followlist";
        $list[2] = "contactlist";
        $list[3] = "pagelist";
        $list[4] = "holder4";
        $list[5] = "holder5";
        $list[6] = "holder6";
        $list[7] = "holder7";
        $list[8] = "holder8";
        $list[9] = "holder9";
          
        for ($i=0; $i < 10; $i++)
        {   
            $affected = DB::insert('insert into USER_LIST
                                (list_type) values 
                                (?)',
                                [$list[$i]]);
            //store_user_id_value
            $suv[$i] = intval(DB::getPdo()->lastInsertId());


        }

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'friendlist_id' => $suv[0],
            'followlist_id' => $suv[1],
            'contactlist_id' => $suv[2],
            'pagelist_id' => $suv[3],
            'holderid4' => $suv[4],
            'holderid5' => $suv[5],
            'holderid6' => $suv[6],
            'holderid7' => $suv[7],
            'holderid8' => $suv[8],
            'holderid9' => $suv[9],
        ]);


    }

    


}