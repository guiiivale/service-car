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

        $customer = $request->customer;

        $company = $request->company;

        $appointment = $request->appointment;

        $review = new Review();
        $review->company()->associate($company);
        $review->user()->associate($customer);
        $review->appointment()->associate($appointment);
        $review->rating = $data['rating'];
        $review->review = $data['review'] ?? null;
        $review->save();

        $companyId = $company->id;

        $newRating = $data['rating'];
        $cacheKey = 'company_rating_' . $companyId;

        $review->load('user', 'company', 'appointment');

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully',
            'review' => $review,
        ]);
    }

    public function get(GetAllCompanyReviewsRequest $request)
    {
        $data = $request->validated();

        $company = $request->company;

        $reviews = $company->reviews()->with(['user', 'appointment.service', 'appointment.vehicle', 'appointment.status', 'appointment.activity'])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get reviews success',
            'reviews' => $reviews,
        ]);
    }
}
