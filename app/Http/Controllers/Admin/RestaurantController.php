<?php

namespace App\Http\Controllers\Admin;

use App\Food;
use App\User;
use App\Restaurant;
use App\Http\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Helper\Helper;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfAdminOrManager:role');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Helpers::checkIfAdmin()) {
            $restaurants = Restaurant::paginate(10);
            return view('dashboard.restaurant.list', compact('restaurants'));
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;
            $restaurant = Restaurant::findOrFail($restaurantID);

            return view('dashboard.restaurant.list', compact('restaurant'));
        }

    }

    public function viewMenu($id)
    {
        if(Helpers::checkIfAdmin()) {
            $restaurant = Restaurant::findOrFail($id);

            $foods = Food::where('restaurantID', $restaurant->restaurantID)->paginate(10);
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;

            if($restaurantID == $id) {
                $restaurant = Restaurant::findOrFail($id);

                $foods = Food::where('restaurantID', $restaurant->restaurantID)->paginate(10);
            }

            else {
                return back();
            }

        }

        return view('dashboard.restaurant.menu', compact('restaurant', 'foods'));
    }

    public function addRestaurant()
    {
        if(Helpers::checkIfAdmin()) {
            return view('dashboard.restaurant.add');
        }

        else {
            return back();
        }
    }

    public function addRestaurantPost(Request $request)
    {
        if(Helpers::checkIfAdmin()) {
            //Handles the file upload
            if ($request->hasFile('logo')) {
                //Get filename with the extension
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('logo')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                //Upload the image
                $path = $request->file('logo')->storeAs('public/assets/admin/img/restaurants/', $fileNameToStore);
            } else {
                $fileNameToStore = 'no_image.jpg';
            }

            $name = $request['name'];

            $restaurant = new Restaurant();
            $restaurant->restaurantName = $name;
            $restaurant->restaurantAddress = $request['address'];
            $restaurant->openingTime = $request['openingTime'];
            $restaurant->closingTime = $request['closingTime'];
            $restaurant->restaurantLogo = $fileNameToStore;
            $restaurant->save();

            $findRestaurant = Restaurant::where('restaurantName', $name)->get()->first();
            $getRestaurant = Restaurant::findOrFail($findRestaurant->restaurantID);

            if ($getRestaurant == true) {
                $restaurant->save();
                $user = new User();
                $user->name = $name;
                $user->email = Helpers::generateEmail($name);
                $user->password = Hash::make('1234');
                $user->role = 'MANAGER';
                $user->email_verified_at = Carbon::now();
                $user->restaurantID = $getRestaurant->restaurantID;
                $user->save();
            }

            swal()->success('Successfully added!');
            return redirect('dashboard/restaurants');
        }

        else {
            return back();
        }
    }

    public function editRestaurant(Request $request, $id)
    {
        if(Helpers::checkIfAdmin()) {
            $restaurant = Restaurant::findOrFail($id);
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;

            if($restaurantID == $id) {
                $restaurant = Restaurant::findOrFail($id);
            }

            else {
                return back();
            }

        }

        return view('dashboard.restaurant.edit', compact('restaurant'));
    }

    public function editRestaurantPost(Request $request, $id)
    {
        if(Helpers::checkIfAdmin()) {
            $restaurant = Restaurant::findOrFail($id);

            //Handles the file upload
            if ($request->hasFile('logo')) {
                //Get filename with the extension
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('logo')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                //Upload the image
                $path = $request->file('logo')->storeAs('public/assets/admin/img/restaurants/', $fileNameToStore);
            } else {
                $fileNameToStore = $restaurant->restaurantLogo;
            }

            $restaurant->restaurantName = $request['name'];
            $restaurant->restaurantAddress = $request['address'];
            $restaurant->openingTime = $request['openingTime'];
            $restaurant->closingTime = $request['closingTime'];
            $restaurant->restaurantLogo = $fileNameToStore;
            $restaurant->save();
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;

            if ($restaurantID == $id) {
                $restaurant = Restaurant::findOrFail($id);

                //Handles the file upload
                if ($request->hasFile('logo')) {
                    //Get filename with the extension
                    $filenameWithExt = $request->file('logo')->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    //Filename to store
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    //Upload the image
                    $path = $request->file('logo')->storeAs('public/assets/admin/img/restaurants/', $fileNameToStore);
                } else {
                    $fileNameToStore = $restaurant->restaurantLogo;
                }
                
                $restaurant->restaurantName = $request['name'];
                $restaurant->restaurantAddress = $request['address'];
                $restaurant->openingTime = $request['openingTime'];
                $restaurant->closingTime = $request['closingTime'];
                $restaurant->restaurantLogo = $fileNameToStore;
                $restaurant->save();
            }

            else {
                return back();
            }

        }

        swal()->success('Successfully updated!');
        return redirect('dashboard/restaurants');
    }

    public function deleteRestaurant(Request $request, $restaurantID)
    {
        if(Helpers::checkIfAdmin()) {
            $user = User::where('restaurantID', $restaurantID)->first();
            User::findOrFail($user->id)->delete();
            Restaurant::findOrFail($restaurantID)->delete();

            swal()->success('Successfully deleted!');
            return back();
        }

        else {
            return back();
        }
    }
}
