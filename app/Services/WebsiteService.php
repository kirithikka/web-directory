<?php

namespace App\Services;

use App\Models\Website;
use App\Models\Category;
use App\Models\CategoryWebsite;
use Illuminate\Http\JsonResponse;
use App\Data\Websites\WebsiteData;
use Illuminate\Support\Facades\Auth;
use App\Data\Websites\WebsiteQueryParamsData;
use Illuminate\Pagination\LengthAwarePaginator;

class WebsiteService
{
    /**
     * Get websites grouped by categories
     */
    public function getCategoryGroupedWebsites(WebsiteQueryParamsData $queryParams)
    {
        $categoryWebsites = Category::search($queryParams->q)
            ->query(function($query) {
                $query
                    ->select(
                        'categories.name as category_name',
                        'categories.description as category_description',
                        'websites.*'
                    )
                    ->join('category_website', 'category_website.category_id', '=', 'categories.id')
                    ->join('websites', 'websites.id', '=', 'category_website.website_id')
                    ->whereNull('websites.deleted_at')
                    ->whereNull('category_website.deleted_at');
            })
            ->get()
            ->groupBy('category_name')
            ->toArray();

        $groupedWebsites = [];

        // group the websites by category
        foreach ($categoryWebsites as $categoryName => $websites) {
            if (empty($websites)) {
                continue;
            }

            $categoryDescription = $websites[0]['category_description'];
            $websites = array_map(function($website) {
                unset($website['category_name']);
                unset($website['category_description']);

                return $website;
            }, $websites);

            $categoryData = [];
            $categoryData['category_name'] = $categoryName;
            $categoryData['category_decription'] = $categoryDescription;
            $categoryData['websites'] = WebsiteData::collect($websites);

            $groupedWebsites[] = $categoryData;
        }

        // paginate the response
        $pageSize = 10;
        $currentPage  = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($groupedWebsites, ($currentPage - 1) * $pageSize, $pageSize);

        return new LengthAwarePaginator(
            $currentItems,
            count($groupedWebsites),
            $pageSize,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $queryParams->toArray()]
        );
    }

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

        foreach ($websiteData['category_id'] as $categoryId){
            CategoryWebsite::create([
                'category_id' => $categoryId,
                'website_id' => $website->id,
            ]);
        }

        return response()->json(['website' => WebsiteData::from($website)]);
    }
}
