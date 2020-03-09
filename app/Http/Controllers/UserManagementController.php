<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;

class UserManagementController extends Controller
{
    public function index(User $model)
    {
        return view('vartotoju-valdymas', ['users' => $model->paginate(15)]);
    }
}
