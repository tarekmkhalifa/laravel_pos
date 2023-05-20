<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\ProductStoreRequest;
use App\Http\Requests\dashboard\ProductUpdateRequest;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // middleware permissions
    public function __construct()
    {
        $this->middleware('permission:read_products')->only('index');
        $this->middleware('permission:create_products')->only('create');
        $this->middleware('permission:update_products')->only('edit');
        $this->middleware('permission:delete_products')->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request) {
            // search by product name
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            // filter by category_id
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(10);

        return view('dashboard.products.index', compact('categories', 'products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        // validate request

        // prepare data
        $data = [];

        // image
        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('uploads/product_images/' . $request->image->hashName());
            $data['image'] = $request->image->hashName();
        }
        $data += [
            'category_id' => $request->category_id,
            'ar' => $request->ar,
            'en' => $request->en,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
        ];

        // insert in db
        Product::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        // validate request

        // prepare data
        $data = [];

        // image
        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('uploads/product_images/' . $request->image->hashName());
            $data['image'] = $request->image->hashName();

            // delete old photo
            if ($product->image !== 'default.png') {
                $directory = "uploads/product_images/$product->image";
                if ($directory) unlink($directory);
            }
        }
        $data += [
            'category_id' => $request->category_id,
            'ar' => $request->ar,
            'en' => $request->en,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
        ];

        // update in db
        $product->update($data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image !== 'default.png') {
            $directory = "uploads/product_images/$product->image";
            if ($directory) unlink($directory);
        }
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
