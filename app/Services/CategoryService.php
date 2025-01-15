<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Retrieves all categories from the repository.
     *
     * This method interacts with the CategoryRepository to fetch all category records
     * from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of category models.
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * Creates a new category in the repository.
     *
     * This method passes the provided data to the CategoryRepository to create a new
     * category record in the database.
     *
     * @param array $data The data for creating the category.
     *
     * @return \App\Models\Category The created category model.
     */
    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->createCategory($data);
    }
}
