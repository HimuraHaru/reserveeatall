<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);

        return view('dashboard.account.account', compact('user'));
    }

    public function editAccount($category)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $convertCategory = ucwords($category);

        return view('dashboard.account.edit-account', compact('user','convertCategory'));
    }

    public function editAccountPost(Request $request, $category, $id)
    {
        $user = User::findOrFail($id);

        if($category == "name")
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $user->name = $request['name'];
        }

        elseif($category == "email")
        {
            $request->validate([
                'email' => 'required|string|max:255|email|unique:users',
            ]);

            $user->email = $request['email'];
        }

        elseif($category == "password")
        {
            if( Hash::check($request['current'],$user->password) == false )
            {
                return back()->with('invalidPassword', 'The current password is incorrect!');
            }

            else {
                $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                ]);

                $user->password = Hash::make($request['password']);
            }

        }

        elseif($category == "contact")
        {
            $request->validate([
                'contact' => ['required', 'regex:/^(09|639)\d{9}$/', 'numeric', 'digits:12'],
            ]);

            $user->contact = $request['contact'];
        }

        elseif($category == "image")
        {
            $request->validate([
                'profileImage' => ['required', 'mimes:jpeg,jpg,png'],
            ]);

            //Handles the file upload
            if($request->hasFile('profileImage')) {
                //Get filename with the extension
                $filenameWithExt = $request->file('profileImage')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('profileImage')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                //Upload the image
                $path = $request->file('profileImage')->storeAs('public/assets/admin/img/users/', $fileNameToStore);
            }

            $user->profileImage = $fileNameToStore;
        }

        elseif($category == "gender")
        {
            $user->gender = $request['gender'];
        }

        elseif($category == "address")
        {
            $user->address = $request['address'];
        }

        elseif($category == "age")
        {
            $user->age = $request['age'];
        }

        $user->save();
        swal()->success('Successfully updated!');
        return back();
    }
}
