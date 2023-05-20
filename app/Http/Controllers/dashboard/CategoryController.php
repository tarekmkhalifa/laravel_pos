<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\CategoryStoreRequest;
use App\Http\Requests\dashboard\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // middleware permissions
    public function __construct()
    {
        $this->middleware('permission:read_categories')->only('index');
        $this->middleware('permission:create_categories')->only('create');
        $this->middleware('permission:update_categories')->only('edit');
        $this->middleware('permission:delete_categories')->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })
            ->latest()->paginate(10);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        // validate on request

        // prepare data
        $data = [
            'ar' => $request->ar,
            'en' => $request->en
        ];

        // insert in db
        Category::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        // validate on request

        // prepare data
        $data = [
            'ar' => $request->ar,
            'en' => $request->en
        ];

        // update in db
        $category->update($data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
