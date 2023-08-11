<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\GetAllCompanyReviewsRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function add(CreateReviewRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['user_id']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if($user->user_type_id != 2) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a customer',
            ], 400);
        }

        $company = User::find($data['company_id']);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found',
            ], 404);
        }

        if($company->user_type_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a company',
            ], 400);
        }

        $review = new Review();
        $review->company()->associate($company);
        $review->user()->associate($user);
        $review->rating = $data['rating'];
        $review->review = $data['review'] ?? null;
        $review->save();

        $companyId = $company->id;
        $newRating = $data['rating'];
        $cacheKey = 'company_rating_' . $companyId;

        $review->load('user', 'company');

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully',
            'review' => $review,
        ]);
    }

    public function get(GetAllCompanyReviewsRequest $request)
    {
        $data = $request->validated();

        $company = User::find($data['company_id']);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found',
            ], 404);
        }

        if($company->user_type_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a company',
            ], 400);
        }

        $reviews = $company->reviews()->with('user')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get reviews success',
            'reviews' => $reviews,
        ]);
    }
}
