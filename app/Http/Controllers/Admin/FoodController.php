<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Restaurant;
use App\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfAdminOrManager:role');
    }

    public function viewFood($foodID)
    {
        if(Helpers::checkIfAdmin()) {
            $food = Food::findOrFail($foodID);
            $restaurant = Restaurant::findOrFail($food->restaurantID);
        }

        elseif(Helpers::checkIfManager()) {
            $food = Food::findOrFail($foodID);
            $restaurantID = auth()->user()->restaurantID;

            if($restaurantID == $food->restaurantID) {
                $restaurant = Restaurant::findOrFail($food->restaurantID);
            }

            else {
                return back();
            }

        }

        return view('dashboard.restaurant.food.view', compact('food', 'restaurant'));
    }

    public function addFood($restaurantID)
    {
        if(Helpers::checkIfAdmin()) {
            $restaurant = Restaurant::findOrFail($restaurantID);
        }

        elseif(Helpers::checkIfManager()) {
            $resID = auth()->user()->restaurantID;

            if($resID == $restaurantID)
            {
                $restaurant = Restaurant::findOrFail($restaurantID);
            }

            else {
                return back();
            }
        }

        return view('dashboard.restaurant.food.add', compact('restaurant'));
    }

    public function addFoodPost(Request $request, $restaurantID)
    {
        //Handles the file upload
        if($request->hasFile('logo')) {
            //Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload the image
            $path = $request->file('logo')->storeAs('public/assets/admin/img/restaurants/foods', $fileNameToStore);
        }

        else {
            $fileNameToStore = 'no_image.jpg';
        }

        if(Helpers::checkIfAdmin()) {

            $restaurant = Restaurant::findOrFail($restaurantID);

            $food = new Food();
            $food->foodName = $request['name'];
            $food->foodPrice = $request['price'];
            $food->foodIngredient = $request['mainIngredient'];
            $food->foodImage = $fileNameToStore;
            $food->foodCategory = $request['category'];
            $food->restaurantID = $restaurant->restaurantID;
            $food->save();
        }

        elseif(Helpers::checkIfManager()) {

            $resID = auth()->user()->restaurantID;

            if($resID == $restaurantID) {
                $restaurant = Restaurant::findOrFail($restaurantID);

                $food = new Food();
                $food->foodName = $request['name'];
                $food->foodPrice = $request['price'];
                $food->foodIngredient = $request['mainIngredient'];
                $food->foodImage = $fileNameToStore;
                $food->foodCategory = $request['category'];
                $food->restaurantID = $restaurant->restaurantID;
                $food->save();
            }

            else {
                return back();
            }

        }

        swal()->success('Successfully added!');
        return redirect('dashboard/restaurants/view-menu/' . $restaurant->restaurantID);
    }

    public function editFood($foodID)
    {
        if(Helpers::checkIfAdmin()) {
            $food = Food::findOrFail($foodID);
            $restaurant = Restaurant::findOrFail($food->restaurantID);
        }

        elseif(Helpers::checkIfManager()) {
            $food = Food::findOrFail($foodID);
            $restaurantID = auth()->user()->restaurantID;

            if($restaurantID == $food->restaurantID) {
                $restaurant = Restaurant::findOrFail($food->restaurantID);
            }

            else {
                return back();
            }

        }

        return view('dashboard.restaurant.food.edit', compact('food', 'restaurant'));
    }

    public function editFoodPost(Request $request, $foodID)
    {
        $food = Food::findOrFail($foodID);

        //Handles the file upload
        if($request->hasFile('logo')) {
            //Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload the image
            $path = $request->file('logo')->storeAs('public/assets/admin/img/restaurants/foods', $fileNameToStore);
        }

        else {
            $fileNameToStore = $food->foodImage;
        }

        if(Helpers::checkIfAdmin()) {

            $restaurant = Restaurant::findOrFail($food->restaurantID);

            $food->foodName = $request['name'];
            $food->foodPrice = $request['price'];
            $food->foodIngredient = $request['mainIngredient'];
            $food->foodCategory = $request['category'];
            $food->foodImage = $fileNameToStore;
            $food->save();
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;

            if($restaurantID == $food->restaurantID) {
                $restaurant = Restaurant::findOrFail($food->restaurantID);

                $food->foodName = $request['name'];
                $food->foodPrice = $request['price'];
                $food->foodIngredient = $request['mainIngredient'];
                $food->foodCategory = $request['category'];
                $food->foodImage = $fileNameToStore;
                $food->save();
            }

            else {
                return back();
            }

        }

        swal()->success('Successfully updated!');
        return redirect('dashboard/restaurants/view-menu/' . $restaurant->restaurantID);
    }

    public function deleteFood($foodID)
    {
        if(Helpers::checkIfAdmin()) {
            Food::findOrFail($foodID)->delete();
        }

        elseif(Helpers::checkIfManager()) {
            $restaurantID = auth()->user()->restaurantID;
            $food = Food::findOrFail($foodID);

            if($restaurantID == $food->restaurantID) {
                $food->delete();
            }
        }

        swal()->success('Successfully deleted!');
        return back();
    }
}
