<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use App\Models\ImageGroup;
use App\Models\ProductCards;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductCardsController extends Controller
{
    use HasApiTokens;
    public function addProdcutCard(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|string|max:30',
                'description' => 'required|string|max:255',
                'colors' => 'required|array',
                'image_path' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'is_main' => 'required|boolean',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed',
                    'errors' => $validatedData->errors()
                ], 422);
            }
            $image_64 = $request->image_path;
            $image_parts = explode(";base64,", $image_64);
            $image_base64 = base64_decode($image_parts[1]);

            // generate file name
            $file_name = uniqid() . '.png';
            $relative_path = 'images/product_cards/' . $file_name; // relative path
            $absolute_path = public_path($relative_path);          // absolute for saving

            // // store file physically
            // file_put_contents($absolute_path, $image_base64);

            // $file_path = $absolute_path.$file_name;
            // ensure folder exists
            if (!file_exists(dirname($absolute_path))) {
                mkdir(dirname($absolute_path), 0755, true);
            }

            file_put_contents($absolute_path, $image_base64);

            ProductCards::create([
                'title' => $request->title,
                'description' => $request->description,
                'colors' => $request->colors,
                'image_path' => $relative_path,
                'is_main' => $request->is_main
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product card added successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function addImageGroup(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'name' => 'required|string|unique:image_groups,name',
                'image_1' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'image_2' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'image_3' => ['nullable', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'image_4' => ['nullable', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
            ]);
            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed',
                    'errors' => $validatedData->errors()
                ], 422);
            }
            $data = $request->only(['image_1', 'image_2', 'image_3', 'image_4']);

            $paths = [];
            foreach ($data as $key => $image) {
                if ($image) {
                    //extract image extension
                    preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $image, $matches);
                    $extension = $matches[1] ?? 'png';

                    //Remove base64 prefix
                    $image = preg_replace('/^data:image\/(jpeg|jpg|png);base64,/', '', $image);

                    //decode base64
                    $image = base64_decode($image);

                    //generate filename
                    $filename = uniqid() . '.' . $extension;


                    $relative_path = 'product_images/' . $filename; // relative path    

                    Storage::disk('public')->put($relative_path, $image);


                    $paths[$key] = $relative_path;
                }
            }

            //create image group
            ImageGroup::create([
                'name' => $request->name,
                'image_1' => $paths['image_1'],
                'image_2' => $paths['image_2'],
                'image_3' => $paths['image_3'] ?? null,
                'image_4' => $paths['image_4'] ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Image group created successfully',
                // 'data' => $imageGroup
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function addProduct(Request $request)
    {
        try {
            $validatedProduct = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'category' => 'required|in:men,women,kids',
                'subcategory' => 'nullable|in:official,casual,t_shirts, shirts, skirts, dress, sportswear,shoes,footwear,sneakers,accessories,jewelry,bags,perfumes,cosmetics',
                'colors' => 'required|array',
                'colors.*' => 'in:black,white,blue,green,red,yellow,orange,purple,pink,gray',
                'brand' => 'nullable|string',
                'sizes' => 'required|array',
                'sizes.*' => ['regex:/^(xs|s|m|l|xl|xxl|xxxl|\d{1,2})$/i'],
                'quantity' => 'nullable|integer',
            ]);

            if ($validatedProduct->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed',
                    'errors' => $validatedProduct->errors()
                ], 422);
            }

            $image_group = ImageGroup::where('name', $request->name)->first();
            if (!$image_group) {
                return response()->json([
                    'status' => 'failed',
                    'message' => "Add images of $request->name first to create a product",
                ], 404);
            }
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'colors' => $request->colors,
                'brand' => $request->brand,
                'sizes' => $request->sizes,
                'quantity' => $request->quantity,
                'image_group_id' => $image_group->id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function addCollection(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|string|unique:collections',
                'starting_from' => 'nullable|integer',
                'image_1' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'image_2' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],
                'image_3' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png);base64,/'],

            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed',
                    'errors' => $validatedData->errors()
                ], 422);
            }
            $data = $request->only(['image_1', 'image_2', 'image_3']);

            $paths = [];
            foreach ($data as $key => $image) {
                if ($image) {
                    //extract image extension
                    preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $image, $matches);
                    $extension = $matches[1] ?? 'png';

                    //Remove base64 prefix
                    $image = preg_replace('/^data:image\/(jpeg|jpg|png);base64,/', '', $image);

                    //decode base64
                    $image = base64_decode($image);

                    //generate filename
                    $filename = uniqid() . '.' . $extension;


                    $relative_path = 'product_collections/' . $filename; // relative path    

                    Storage::disk('public')->put($relative_path, $image);

                    $paths[$key] = $relative_path;
                }
            }

            Collection::create([
                'title' => $request->title,
                'starting_from' => $request->starting_from,
                'collection_image_1' => $paths['image_1'],
                'collection_image_2' => $paths['image_2'],
                'collection_image_3' => $paths['image_3'],
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Collection created successfully',
                // 'data' => $imageGroup
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
