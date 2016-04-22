<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Repositories\TaskRepository;

class AccountController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $account;
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('account.new');
    }
    
}
