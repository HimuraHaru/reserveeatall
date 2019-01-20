<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function construct()
    {
        $this->middleware('auth');
    }

    public function accountList() {

        if(Helpers::checkIfAdmin()) {
            $accounts = User::orderBy('name', 'asc')->paginate(10);

            return view('dashboard.account.list', compact('accounts'));
        }

        else {
            return back();
        }
    }

}
