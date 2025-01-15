<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Retrieves a category by its ID.
     *
     * This method fetches a single category from the database using its primary key.
     * If the category is not found, it returns null.
     *
     * @param int $id The ID of the category to retrieve.
     *
     * @return \App\Models\Category|null The category model if found, or null if not found.
     */
    public function getCategory(int $id): Category
    {
        return Category::find($id);
    }

    /**
     * Retrieves all categories with their associated influencers.
     *
     * This method fetches all category records from the database, eager loading
     * their associated influencers to optimize the number of queries.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of category models with associated influencers.
     */
    public function getAllCategories(): Collection
    {
        return Category::with('influencers')->get();
    }

    /**
     * Creates a new category in the database.
     *
     * This method accepts an array of data and creates a new category record
     * in the database.
     *
     * @param array $data The data to create a new category.
     *
     * @return \App\Models\Category The created category model.
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }
}
