<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Retrieves all categories and their associated data.
     *
     * This method calls the service layer to fetch all categories and returns a JSON response
     * with the list of categories.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the collection of categories.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return ApiResponse::success(
            CategoryResource::collection($categories),
            'List of categories'
        );
    }

    /**
     * Creates a new category and returns the response.
     *
     * This method validates the request data, creates a new category, and returns the created category
     * in the response.
     *
     * @param \App\Http\Requests\CreateCategoryRequest $request The request containing category data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the created category details.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory(
            $request->validated()
        );

        return ApiResponse::created(
            new CategoryResource($category),
            'Category created successfully'
        );
    }
}
