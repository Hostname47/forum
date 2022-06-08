<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Forum, ForumStatus};
use App\Exceptions\{DuplicateCategoryException, ForumClosedException};

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:sitecreator']);
    }
    
    public function store() {
        $data = request()->validate([
            'category'=>'required|min:2|max:800',
            'slug'=>'required|min:2|max:800',
            'description'=>'required|min:2|max:4000',
            'forum_id'=>'required|exists:forums,id',
            'status'=>'required|exists:category_status,id',
        ]);

        $this->authorize('store', [Category::class, $data['forum_id'], $data['slug']]);

        Category::create($data);
    }

    public function update(Category $category) {
        $data = request()->validate([
            'category'=>'sometimes|min:2|max:800', // This is title of category
            'description'=>'sometimes|min:2|max:1600',
            'slug'=>'sometimes|min:2|max:400',
            'status'=>'sometimes|exists:category_status,id',
        ]);
        $slug = isset($data['slug']) ? $data['slug'] : $category->slug;
        $c = isset($data['category']) ? $data['category'] : $category->category;

        $this->authorize('update', [Category::class, $category, $slug, $c]);

        $category->update($data);
    }

    public function destroy(Category $category) {
        // Before delete a category you have to delete all attached threads
        // $category->delete();
    }
}
