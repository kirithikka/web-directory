<?php

namespace App\Http\Controllers\V1;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Data\Votes\VoteUnvoteData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class VoteController extends Controller
{
    /**
     * Vote a website
     */
    public function store(Request $request)
    {
        try
        {
            $voteData = VoteUnvoteData::validate($request->all());

            $user = Auth::user();
            $vote = $user->votes->where('website_id', $voteData['website_id'])->first();

            if ($vote) {
                return response()->json(['error' => 'You have already voted!']);
            }

            Vote::create([
                'user_id' => $user->id,
                'website_id' => $voteData['website_id'],
            ]);

            return response()->json(['message' => 'Successfully voted!']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Unvote a website
     */
    public function delete(Request $request)
    {
        try
        {
            $voteData = VoteUnvoteData::validate($request->all());

            $user = Auth::user();
            $vote = $user->votes->where('website_id', $voteData['website_id'])->first();

            if (!$vote) {
                return response()->json(['error' => 'You have not already voted!']);
            }

            $vote->delete();

            return response()->json(['message' => 'Successfully unvoted!']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
