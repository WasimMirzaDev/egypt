<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserReview;


class UserReviewController extends Controller
{
    public function store(Request $request)
    {

        if (!Auth::user()) {

            return response()->json(['success'=>false,'error' => 'You must be logged in to submit a review.'], 401);
        }


        $validator = Validator::make($request->all(), [

            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['success'=>false,'message' => $validator->errors()->first()], 401);
        }

        $review = new UserReview();
        $review->description = $request->input('description');
        $review->rating = $request->input('rating');
        $review->user_id = Auth::user()->id; // Assuming user authentication
        $review->save();

        return response()->json(['success'=>true,'message' => 'Thanks for you Review.']);
    }
    public function show(Request $request)
    {
        $reviews=UserReview::all();
        $pageTitle  = "Menage Reviews";

     return view('admin.review.menage_review',compact('reviews','pageTitle'));
    }
    public function approve($id)
    {
        $review = UserReview::find($id);

        if (!$review) {
            return redirect()->route('show.reviews')->withNotify([
                ['error', 'Review not found.']
            ]);
        }

        $review->approved = 1; // Assuming 'approved' is the field in your review table

        if ($review->save()) {
            return redirect()->route('show.reviews')->withNotify([
                ['success', 'Review approved successfully.']
            ]);
        } else {
            return redirect()->route('show.reviews')->withNotify([
                ['error', 'Failed to approve review.']
            ]);
        }
    }
    public function destroy($id)
    {

        $review = UserReview::find($id);

        if (!$review) {
            return redirect()->route('show.reviews')->withNotify([
                ['error', 'Review not found.']
            ]);
        }

        if ($review->delete()) {
            // Notify user about the review deletion


            return redirect()->route('show.reviews')->withNotify([
                ['success', 'Review deleted successfully.']
            ]);
        } else {
            return redirect()->route('show.reviews')->withNotify([
                ['error', 'Failed to delete review.']
            ]);
        }
    }








}
