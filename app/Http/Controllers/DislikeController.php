<?php

namespace App\Http\Controllers;

use App\Dislike;
use App\Feedback;
use App\Http\Helpers;
use App\Like;
use App\Restaurant;
use Illuminate\Http\Request;

class DislikeController extends Controller
{
    public function dislikeFeedback(Request $request, $feedbackID, $restaurantID, $category) {

        $feedback = Feedback::findOrFail($feedbackID);
        $restaurant = Restaurant::findOrFail($restaurantID);

        $like = Like::where('feedbackID', $feedback->feedbackID)->where('userID', Helpers::userID())->first();
        $dislike = Dislike::where('feedbackID', $feedback->feedbackID)->where('userID', Helpers::userID())->first();

        if($like != NULL && $like->count() != 0) {
            Like::findOrFail($like->likeID)->delete();
        }

        if($dislike == NULL) {
            $dislike = new Dislike();
            $dislike->userID = Helpers::userID();
            $dislike->feedbackID = $feedbackID;
            if($feedback->likeCount > 0) {
                $feedback->likeCount--;
            }
            $feedback->dislikeCount++;
            $feedback->save();
            $dislike->save();
        }

        if($category == "featured") {
            return redirect('restaurant/' . $restaurant->restaurantID . '#feedbacks');
        }
        elseif($category == "feedback") {
            return redirect('restaurant/view/feedback/' . $restaurant->restaurantID);
        }
    }
}
