<?php

namespace App\Http\Controllers;

use App\Dislike;
use App\Http\Helpers;
use App\Like;
use App\Feedback;
use App\Restaurant;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeFeedback(Request $request, $feedbackID, $restaurantID, $category) {

        $feedback = Feedback::findOrFail($feedbackID);
        $restaurant = Restaurant::findOrFail($restaurantID);
        $dislike = Dislike::where('feedbackID', $feedback->feedbackID)->where('userID', Helpers::userID())->first();
        $like = Like::where('feedbackID', $feedback->feedbackID)->where('userID', Helpers::userID())->first();

        if($dislike != NULL && $dislike->count() != 0) {
            Dislike::findOrFail($dislike->dislikeID)->delete();
        }

        if($like == NULL) {
            $like = new Like();
            $like->userID = Helpers::userID();
            $like->feedbackID = $feedbackID;
            if($feedback->dislikeCount > 0) {
                $feedback->dislikeCount--;
            }
            $feedback->likeCount++;
            $feedback->save();
            $like->save();
        }

        if($category == "featured") {
            return redirect('restaurant/' . $restaurant->restaurantID . '#feedbacks');
        }
        elseif($category == "feedback") {
            return redirect('restaurant/view/feedback/' . $restaurant->restaurantID);
        }
    }
}
