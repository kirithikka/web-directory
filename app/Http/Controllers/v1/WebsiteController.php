<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\WebsiteService;
use Illuminate\Http\JsonResponse;
use App\Data\Websites\WebsiteData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Data\Websites\CreateWebsiteData;
use Illuminate\Validation\ValidationException;

class WebsiteController extends Controller
{
    public function __construct(private WebsiteService $websiteService)
    {
    }

    /**
     * Get the list of websites
     */
    public function index()
    {
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
