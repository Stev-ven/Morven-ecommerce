<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\ImageGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get filter parameters
        $paymentStatus = $request->get('payment_status');
        $orderStatus = $request->get('order_status');
        $paymentMethod = $request->get('payment_method');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build orders query with filters
        $ordersQuery = Order::query();
        
        if ($paymentStatus) {
            $ordersQuery->where('payment_status', $paymentStatus);
        }
        
        if ($orderStatus) {
            $ordersQuery->where('order_status', $orderStatus);
        }
        
        if ($paymentMethod) {
            $ordersQuery->where('payment_method', $paymentMethod);
        }
        
        if ($dateFrom) {
            $ordersQuery->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $ordersQuery->whereDate('created_at', '<=', $dateTo);
        }

        // Get statistics (filtered)
        $stats = [
            'total_orders' => (clone $ordersQuery)->count(),
            'pending_orders' => (clone $ordersQuery)->where('order_status', 'pending')->count(),
            'total_revenue' => (clone $ordersQuery)->where('payment_status', 'paid')->sum('total'),
            'total_users' => User::where('account_type', 'user')->count(),
            'total_products' => Product::count(),
        ];

        // Recent orders (filtered)
        $recentOrders = (clone $ordersQuery)->with('items', 'user')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Revenue by payment method (filtered)
        $revenueByMethodQuery = Order::where('payment_status', 'paid');
        if ($orderStatus) $revenueByMethodQuery->where('order_status', $orderStatus);
        if ($dateFrom) $revenueByMethodQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $revenueByMethodQuery->whereDate('created_at', '<=', $dateTo);
        
        $revenueByMethod = $revenueByMethodQuery
            ->select('payment_method', DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();

        // Orders by status (filtered)
        $ordersByStatusQuery = Order::query();
        if ($paymentStatus) $ordersByStatusQuery->where('payment_status', $paymentStatus);
        if ($paymentMethod) $ordersByStatusQuery->where('payment_method', $paymentMethod);
        if ($dateFrom) $ordersByStatusQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $ordersByStatusQuery->whereDate('created_at', '<=', $dateTo);
        
        $ordersByStatus = $ordersByStatusQuery
            ->select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->get();

        // Get unique payment methods for filter dropdown
        $paymentMethods = Order::select('payment_method')
            ->distinct()
            ->pluck('payment_method');

        return view('admin.dashboard', compact(
            'stats', 
            'recentOrders', 
            'revenueByMethod', 
            'ordersByStatus',
            'paymentMethods',
            'paymentStatus',
            'orderStatus',
            'paymentMethod',
            'dateFrom',
            'dateTo'
        ));
    }



    public function products(Request $request)
    {
        $query = Product::with('image_groups');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('subcategory', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        // Define categories that don't require colors/sizes
        $noColorSizeCategories = ['grooming', 'accessories'];
        $requiresColorSize = !in_array($request->category, $noColorSizeCategories);

        $validationRules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string',
            'subcategory' => 'nullable|string',
            'brand' => 'nullable|string',
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add color/size validation only if required
        if ($requiresColorSize) {
            $validationRules['colors'] = 'required|array';
            $validationRules['colors.*'] = 'required|string';
            $validationRules['sizes'] = 'required|array';
            $validationRules['sizes.*'] = 'required|string';
        } else {
            $validationRules['colors'] = 'nullable|array';
            $validationRules['colors.*'] = 'nullable|string';
            $validationRules['sizes'] = 'nullable|array';
            $validationRules['sizes.*'] = 'nullable|string';
        }

        $validated = $request->validate($validationRules);

        DB::beginTransaction();
        try {
            // Upload images and create image group
            $imageData = ['name' => $validated['name'] . ' Images'];
            
            for ($i = 1; $i <= 4; $i++) {
                $fieldName = "image_$i";
                if ($request->hasFile($fieldName)) {
                    $path = $request->file($fieldName)->store('product_images', 'public');
                    $imageData[$fieldName] = $path;
                }
            }

            $imageGroup = ImageGroup::create($imageData);

            // Create product
            $product = Product::create([
                'image_group_id' => $imageGroup->id,
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'quantity' => $validated['quantity'],
                'category' => $validated['category'],
                'subcategory' => $validated['subcategory'] ?? null,
                'brand' => $validated['brand'] ?? null,
                'colors' => $requiresColorSize ? $validated['colors'] : [],
                'sizes' => $requiresColorSize ? $validated['sizes'] : [],
            ]);

            DB::commit();
            return redirect()->route('admin.products')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    public function editProduct($id)
    {
        $product = Product::with('image_groups')->findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::with('image_groups')->findOrFail($id);

        // Define categories that don't require colors/sizes
        $noColorSizeCategories = ['grooming', 'accessories'];
        $requiresColorSize = !in_array($request->category, $noColorSizeCategories);

        $validationRules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string',
            'subcategory' => 'nullable|string',
            'brand' => 'nullable|string',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add color/size validation only if required
        if ($requiresColorSize) {
            $validationRules['colors'] = 'required|array';
            $validationRules['colors.*'] = 'required|string';
            $validationRules['sizes'] = 'required|array';
            $validationRules['sizes.*'] = 'required|string';
        } else {
            $validationRules['colors'] = 'nullable|array';
            $validationRules['colors.*'] = 'nullable|string';
            $validationRules['sizes'] = 'nullable|array';
            $validationRules['sizes.*'] = 'nullable|string';
        }

        $validated = $request->validate($validationRules);

        DB::beginTransaction();
        try {
            // Update product details
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'quantity' => $validated['quantity'],
                'category' => $validated['category'],
                'subcategory' => $validated['subcategory'] ?? null,
                'brand' => $validated['brand'] ?? null,
                'colors' => $requiresColorSize ? $validated['colors'] : [],
                'sizes' => $requiresColorSize ? $validated['sizes'] : [],
            ]);

            // Update images if new ones are uploaded
            $imageGroup = $product->image_groups;
            $imageData = [];

            for ($i = 1; $i <= 4; $i++) {
                $fieldName = "image_$i";
                if ($request->hasFile($fieldName)) {
                    // Delete old image if exists
                    if ($imageGroup && $imageGroup->$fieldName) {
                        Storage::disk('public')->delete($imageGroup->$fieldName);
                    }
                    // Upload new image
                    $path = $request->file($fieldName)->store('product_images', 'public');
                    $imageData[$fieldName] = $path;
                }
            }

            if (!empty($imageData) && $imageGroup) {
                $imageGroup->update($imageData);
            }

            DB::commit();
            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with('image_groups')->findOrFail($id);
            
            // Delete images from storage
            if ($product->image_groups) {
                for ($i = 1; $i <= 4; $i++) {
                    $fieldName = "image_$i";
                    if ($product->image_groups->$fieldName) {
                        Storage::disk('public')->delete($product->image_groups->$fieldName);
                    }
                }
                $product->image_groups->delete();
            }

            // Delete product
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}