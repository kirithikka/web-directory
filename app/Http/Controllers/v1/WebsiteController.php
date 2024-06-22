<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\WebsiteService;
use Illuminate\Http\JsonResponse;
use App\Data\Websites\WebsiteData;
use App\Http\Controllers\Controller;
use App\Data\Websites\CreateWebsiteData;
use App\Data\Websites\WebsiteQueryParamsData;
use Illuminate\Validation\ValidationException;

class WebsiteController extends Controller
{
    public function __construct(private WebsiteService $websiteService)
    {
    }

    /**
     * Get the list of websites
     */
    public function index(Request $request)
    {
        $queryParams = $this->_getQueryParams($request);
        $groupedWebsites = $this->websiteService->getCategoryGroupedWebsites($queryParams);

        return response()->json([
            'groupedWebsites' => $groupedWebsites
        ]);
    }

    /**
     * Get query params
     */
    public function _getQueryParams(Request $request)
    {
        return WebsiteQueryParamsData::from([
            'q' => $request->query('q'),
        ]);
    }

    /**
     * Add a website to the web directory
     */
    public function store(Request $request): JsonResponse
    {
        try
        {
            $websiteData = CreateWebsiteData::validate($request->all());

            return $this->websiteService->create($websiteData);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
