<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Http\JsonResponse;
use App\Data\Websites\WebsiteData;
use Illuminate\Support\Facades\Auth;

class WebsiteService
{
    /**
     * Create a website
     */
    public function create(array $websiteData): JsonResponse
    {
        $website = Website::create([
            'user_id' => Auth::user()->id,
            'name' => $websiteData['name'],
            'url' => $websiteData['url'],
            'description' => $websiteData['description'],
        ]);

        $website->categories()->attach(
            $websiteData['category_id'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return response()->json(['website' => WebsiteData::from($website)]);
    }
}