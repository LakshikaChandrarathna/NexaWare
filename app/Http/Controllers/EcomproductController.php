<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Models\GroupName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EcomproductController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with([
            'images' => function ($query) {
                $query->orderBy('id', 'asc');
            }
        ])->get();

        foreach ($items as $item) {

            $item->color_string = DB::table('colors')
                ->where('item_id', $item->id)
                ->pluck('name')
                ->implode(',');


            $item->size_string = DB::table('sizes')
                ->where('item_id', $item->id)
                ->pluck('size_name')
                ->implode(',');
        }

        $categories = ItemCategory::where('isDelete', 0)
            ->select('item_category_name as group_name')
            ->orderBy('item_category_name', 'asc')
            ->get();

        $subcategories1 = ItemSubCategory::where('isDelete', 0)
            ->select('item_sub_category_name as group_name')
            ->orderBy('item_sub_category_name', 'asc')
            ->get();

        $groups = GroupName::where('isDelete', 0)
            ->select('group_name')
            ->orderBy('group_name', 'asc')
            ->get();

        return view('seller.selleraddproduct', compact('items', 'categories', 'subcategories1', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'subcategory1' => 'required|string',
            'subcategory2' => 'nullable|string',
            'productname' => 'required|string',
            'productcode' => 'required|string',
            'productno' => 'required|string',
            'productcolor' => 'nullable|string',
            'productsize' => 'nullable|string',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            \DB::beginTransaction();

            $category = ItemCategory::where('item_category_name', $request->category)->first();
            $subCategory = ItemSubCategory::where('item_sub_category_name', $request->subcategory1)->first();

            $groupId = null;
            if ($request->filled('subcategory2')) {
                $group = GroupName::where('group_name', $request->subcategory2)->first();
                $groupId = $group ? $group->id : null;
            }

            if (!$category || !$subCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected Category or Sub Category does not exist in database.'
                ], 422);
            }


            $item = Item::where('item_code', $request->productcode)->first();
            if (!$item) {
                $item = new Item();
            }

            $item->item_name = $request->productname;
            $item->item_code = $request->productcode;
            $item->item_no = $request->productno;
            $item->item_category = $category->id;
            $item->item_sub_category = $subCategory->id;
            $item->item_brand = 3;
            $item->save();

            if (!empty($groupId)) {
                \DB::table('item_groups')->where('item_id', $item->id)->delete();
                \DB::table('item_groups')->insert([
                    'item_id' => $item->id,
                    'group_id' => $groupId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            \DB::table('colors')->where('item_id', $item->id)->delete();

            if ($request->filled('productcolor')) {
                $colors = explode(',', $request->productcolor);


                $colorMap = [
                    'red' => '#FF0000',
                    'black' => '#000000',
                    'white' => '#FFFFFF',
                    'blue' => '#0000FF',
                    'green' => '#008000',
                    'yellow' => '#FFFF00',
                    'orange' => '#FFA500',
                    'pink' => '#FFC0CB',
                    'purple' => '#800080',
                    'grey' => '#808080',
                    'gray' => '#808080',
                    'brown' => '#A52A2A',
                    'gold' => '#FFD700',
                    'silver' => '#C0C0C0',
                    'maroon' => '#800000',
                    'navy' => '#000080',
                    'cyan' => '#00FFFF',
                    'magenta' => '#FF00FF',
                    'lime' => '#00FF00',
                    'olive' => '#808000',
                ];

                foreach ($colors as $color) {
                    $trimmedColor = trim($color);

                    if (!empty($trimmedColor)) {
                        $lowerColor = strtolower($trimmedColor);

                        $colorCode = $colorMap[$lowerColor] ?? '#000000';


                        \DB::table('colors')->insert([
                            'item_id' => $item->id,
                            'name' => $trimmedColor,
                            'code' => $colorCode,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // ─── SIZES MULTIPLE HANDLING (Clean & Insert) ───
            \DB::table('sizes')->where('item_id', $item->id)->delete();

            if ($request->filled('productsize')) {
                $sizes = explode(',', $request->productsize);

                foreach ($sizes as $size) {
                    $trimmedSize = trim($size);

                    if (!empty($trimmedSize)) {
                        \DB::table('sizes')->insert([
                            'item_id' => $item->id,
                            'size_name' => $trimmedSize,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Image Handling
            // if ($request->hasFile('product_img')) {
            //     $oldImages = ItemImage::where('item_id', $item->id)->get();
            //     foreach ($oldImages as $oldImg) {
            //         if (file_exists(public_path($oldImg->image_path))) {
            //             @unlink(public_path($oldImg->image_path));
            //         }
            //         $oldImg->delete();
            //     }

            //     $image = $request->file('product_img');
            //     $filename = 'img_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            //     $image->move(public_path('uploads/item_images'), $filename);

            //     $itemImage = new ItemImage();
            //     $itemImage->item_id = $item->id;
            //     $itemImage->image_path = 'uploads/item_images/' . $filename;
            //     $itemImage->status = 1;
            //     $itemImage->save();
            // }

            if ($request->hasFile('product_img')) {

                // Delete old images
                $oldImages = ItemImage::where('item_id', $item->id)->get();

                foreach ($oldImages as $oldImg) {

                    if ($oldImg->image_path && Storage::disk('s3')->exists($oldImg->image_path)) {
                        Storage::disk('s3')->delete($oldImg->image_path);
                    }

                    $oldImg->delete();
                }

                // Upload new image
                $image = $request->file('product_img');

                $filename = 'img_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $path = Storage::disk('s3')->put($filename, $image);
                $s3_url = Storage::disk('s3')->url($path);


                // Save database
                $itemImage = new ItemImage();
                $itemImage->item_id = $item->id;
                $itemImage->image_path = $s3_url; // uploads/item_images/img_xxxxx.jpg
                $itemImage->status = 1;
                $itemImage->save();

            }

            \DB::commit();
            return response()->json(['success' => true, 'message' => 'Product saved successfully!']);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
    public function storeInlineMeta(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:category,subcategory,group',
            'description' => 'nullable|string|max:255',
            'category_id' => 'nullable'
        ]);

        try {
            $id = null;
            $savedName = null;

            switch ($request->type) {

                case 'category':
                    $category = ItemCategory::firstOrCreate(
                        ['item_category_name' => $request->group_name],
                        ['description' => $request->description, 'isDelete' => 0]
                    );
                    $id = $category->id;
                    $savedName = $category->item_category_name;
                    break;

                case 'subcategory':
                    $parentCat = ItemCategory::where('id', $request->category_id)
                        ->orWhere('item_category_name', $request->category_id)
                        ->first();

                    $autoCode = 'SUB-' . strtoupper(substr(md5(time()), 0, 5));

                    $subCat = ItemSubCategory::firstOrCreate(
                        ['item_sub_category_name' => $request->group_name],
                        [
                            'item_category_id' => $parentCat ? $parentCat->id : null,
                            'item_sub_category_code' => $autoCode,
                            'description' => $request->description,
                            'isDelete' => 0
                        ]
                    );
                    $id = $subCat->id;
                    $savedName = $subCat->item_sub_category_name;
                    break;

                case 'group':
                    $group = GroupName::firstOrCreate(
                        ['group_name' => $request->group_name],
                        ['description' => $request->description, 'isDelete' => 0]
                    );
                    $id = $group->id;
                    $savedName = $group->group_name;
                    break;
            }

            return response()->json([
                'success' => true,
                'id' => $id,
                'group_name' => $savedName
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'subcategory' => 'required|string',
            'productname' => 'required|string',
            'productcode' => 'required|string',
            'productno' => 'required|string',
            'edit_product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'productcolor' => 'nullable|string',
            'productsize' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $item = Item::findOrFail($id);
            $item->item_name = $request->productname;
            $item->item_code = $request->productcode;
            $item->item_no = $request->productno;
            $item->item_category = $request->category;
            $item->item_sub_category = $request->subcategory;
            $item->save();

            \DB::table('colors')->where('item_id', $id)->delete();

            if (!empty($request->productcolor)) {
                $colorsArray = explode(',', $request->productcolor);
                foreach ($colorsArray as $color) {
                    $color = trim($color);
                    if ($color != '') {
                        \DB::table('colors')->insert([
                            'item_id' => $item->id,
                            'name' => $color,
                            'is_active' => 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }


            \DB::table('sizes')->where('item_id', $id)->delete();

            if (!empty($request->productsize)) {
                $sizesArray = explode(',', $request->productsize);
                foreach ($sizesArray as $size) {
                    $size = trim($size);
                    if ($size != '') {
                        \DB::table('sizes')->insert([
                            'item_id' => $item->id,
                            'size_name' => $size,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }


            // if ($request->hasFile('edit_product_img')) {
            //     $oldImages = ItemImage::where('item_id', $id)->get();
            //     foreach ($oldImages as $oldImg) {
            //         if (file_exists(public_path($oldImg->image_path))) {
            //             @unlink(public_path($oldImg->image_path));
            //         }
            //         $oldImg->delete();
            //     }

            //     $image = $request->file('edit_product_img');
            //     $filename = 'img_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            //     $image->move(public_path('uploads/item_images'), $filename);

            //     $itemImage = new ItemImage();
            //     $itemImage->item_id = $item->id;
            //     $itemImage->image_path = 'uploads/item_images/' . $filename;
            //     $itemImage->status = 1;
            //     $itemImage->save();
            // }
            if ($request->hasFile('edit_product_img')) {


                $oldImages = ItemImage::where('item_id', $item->id)->get();

                foreach ($oldImages as $oldImg) {
                    if ($oldImg->image_path) {

                        $filenameOnly = basename($oldImg->image_path);

                        if (Storage::disk('s3')->exists($filenameOnly)) {
                            Storage::disk('s3')->delete($filenameOnly);
                        }
                    }
                    $oldImg->delete();
                }


                $image = $request->file('edit_product_img');
                $filename = 'img_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();


                Storage::disk('s3')->put($filename, file_get_contents($image));


                $s3_url = Storage::disk('s3')->url($filename);


                $itemImage = new ItemImage();
                $itemImage->item_id = $item->id;
                $itemImage->image_path = $s3_url;
                $itemImage->status = 1;
                $itemImage->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product updated successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $item = Item::findOrFail($id);


            $images = ItemImage::where('item_id', $id)->get();
            foreach ($images as $img) {
                if (file_exists(public_path($img->image_path))) {
                    @unlink(public_path($img->image_path));
                }
                $img->delete();
            }

            $item->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function quickAddStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|min:1',
            'update_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $cleanPrice = 0;
            if ($request->price) {
                $cleanPrice = str_replace(['LKR', ' ', ','], '', $request->price);
            }

            $grnCode = 'GRN-QUICK-' . time();

            DB::table('grn_items')->insert([
                'item_id' => $request->product_id,
                'stock' => $request->quantity,
                'loose_stock' => 0,
                'active_stock' => $request->quantity,
                'selling_price' => $cleanPrice,
                'cost_price' => $cleanPrice * 0.8,
                'grn_no' => $grnCode,
                'store_id' => 1,
                'status' => 1,
                'note' => 'Quick Stock Add',
                'created_at' => $request->update_date,
                'updated_at' => now()
            ]);


            DB::table('grns')->insert([
                'com_id' => 1,
                'invoice_no' => 1,
                'grn_type' => $grnCode,
                'store_id' => 1,
                'status' => 1,
                'isDelete' => 0,
                'grn_code' => 'SG-5',
                'created_at' => $request->update_date,
                'updated_at' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Stock added to GRN successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }

    public function sellerstock()
    {
        $products = DB::table('items')
            ->select('id', 'item_name')
            ->get();

        $rawItems = DB::table('items')
            ->join('grn_items', 'items.id', '=', 'grn_items.item_id')
            ->select(
                'items.id as real_id',
                'items.*',
                'grn_items.stock',
                'grn_items.selling_price',
                'grn_items.updated_at as grn_updated'
            )
            ->get();


        $items = $rawItems->groupBy('real_id')->map(function ($group) {

            $firstItem = $group->first();


            $firstItem->stock = $group->sum('stock');


            $firstItem->cost_price = $group->max('cost_price');
            $firstItem->grn_updated = $group->max('grn_updated');

            return $firstItem;
        })->values();

        $outOfStockCount = $items->where('stock', '<=', 0)->count();


        $lowStockLimit = 10;
        $lowStockCount = $items->where('stock', '>', 0)->where('stock', '<=', $lowStockLimit)->count();

        return view('seller.sellerstock', compact('items', 'products', 'outOfStockCount', 'lowStockCount'));
    }

    public function stockupdate(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required',
            'update_date' => 'required|date'
        ]);


        $cleanPrice = str_replace([',', 'LKR', 'Rs.', ' '], '', $request->price);


        $grnCode = $request->grn_no ?? 'GRN-' . strtoupper(uniqid());
        $note = $request->note ?? 'Quick Stock Add';
        $addedQuantity = (int) $request->quantity;

        DB::table('grn_items')
            ->where('item_id', $request->product_id)
            ->update([
                'stock' => DB::raw("stock + $addedQuantity"),
                'loose_stock' => 0,
                'active_stock' => $request->quantity,
                'selling_price' => $cleanPrice,
                'cost_price' => $cleanPrice * 0.8,
                'grn_no' => $grnCode,
                'store_id' => 1,
                'status' => 1,
                'note' => $note,
                'updated_at' => now()
            ]);


        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

    public function stockremove($id)
    {
        DB::table('grn_items')->where('item_id', $id)->delete();

        return redirect()->back()->with('success', 'Stock records removed successfully!');


    }

    public function shopIndex(Request $request)
    {
        $now = now();

        $query = DB::table('items')
            ->leftJoin('item_images', function ($join) {
                $join->on('items.id', '=', 'item_images.item_id')
                    ->whereRaw('item_images.id = (SELECT MIN(id) FROM item_images WHERE item_id = items.id)');
            })
            ->leftJoin('grn_items', 'items.id', '=', 'grn_items.item_id')

            // 1. Reviews Subquery
            ->leftJoin(DB::raw('(SELECT item_title, AVG(rating) as avg_rating, COUNT(id) as total_reviews FROM ecom_order_reviews GROUP BY item_title) as reviews'), function ($join) {
                $join->on('items.item_name', '=', 'reviews.item_title');
            })

            ->leftJoin('promotional_offer_product', 'items.id', '=', 'promotional_offer_product.product_id')
            ->leftJoin('promotional_offers', function ($join) use ($now) {
                $join->on('promotional_offer_product.promotional_offer_id', '=', 'promotional_offers.id')
                    ->where(function ($q) use ($now) {
                        $q->whereNull('promotional_offers.start_date')
                            ->orWhere('promotional_offers.start_date', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('promotional_offers.end_date')
                            ->orWhere('promotional_offers.end_date', '>=', $now);
                    });
            })

            ->select(
                'items.id',
                'items.item_name as title',
                'item_images.image_path as image_url',
                DB::raw('COALESCE(SUM(grn_items.stock), 0) as total_stock'),
                DB::raw('COALESCE(MAX(grn_items.selling_price), 0) as price'),
                DB::raw('COALESCE(reviews.avg_rating, 0.0) as dynamic_rating'),
                DB::raw('COALESCE(reviews.total_reviews, 0) as dynamic_reviews_count'),

                'promotional_offers.discount_type',
                'promotional_offers.discount_value'
            );

        if ($request->has('categories') && !empty($request->input('categories'))) {
            $categoryParam = $request->input('categories');
            $level = $request->input('level', 'category');
            $categoryNames = explode(',', $categoryParam);

            $searchNames = array_map(function ($name) {
                return str_replace('-', ' ', trim($name));
            }, $categoryNames);

            if ($level === 'category') {
                $categoryIds = DB::table('item_categories')
                    ->where(function ($q) use ($searchNames) {
                        foreach ($searchNames as $name) {
                            $q->orWhereRaw('LOWER(item_category_name) LIKE ?', ['%' . strtolower($name) . '%']);
                        }
                    })->pluck('id')->toArray();

                if (!empty($categoryIds)) {
                    $query->whereIn('items.item_category', $categoryIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            } elseif ($level === 'subcategory') {
                $subCategoryIds = DB::table('item_sub_categories')
                    ->where(function ($q) use ($searchNames) {
                        foreach ($searchNames as $name) {
                            $q->orWhereRaw('LOWER(item_sub_category_name) LIKE ?', ['%' . strtolower($name) . '%']);
                        }
                    })->pluck('id')->toArray();

                if (!empty($subCategoryIds)) {
                    $query->whereIn('items.item_sub_category', $subCategoryIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            } elseif ($level === 'group') {
                $groupIds = DB::table('group_names')
                    ->where(function ($q) use ($searchNames) {
                        foreach ($searchNames as $name) {
                            $q->orWhereRaw('LOWER(group_name) LIKE ?', ['%' . strtolower($name) . '%']);
                        }
                    })->pluck('id')->toArray();

                if (!empty($groupIds)) {
                    $query->whereIn('items.id', function ($subQuery) use ($groupIds) {
                        $subQuery->select('item_id')
                            ->from('item_groups')
                            ->whereIn('group_id', $groupIds);
                    });
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        }

        $products = $query->groupBy(
            'items.id',
            'items.item_name',
            'item_images.image_path',
            'items.item_category',
            'items.item_sub_category',
            'reviews.avg_rating',
            'reviews.total_reviews',
            'promotional_offers.discount_type',
            'promotional_offers.discount_value'
        )->get();

        // Fetch colors and sizes
        $itemIds = $products->pluck('id')->toArray();

        $allColors = DB::table('colors')->whereIn('item_id', $itemIds)->get()->groupBy('item_id');
        $allSizes = DB::table('sizes')->whereIn('item_id', $itemIds)->get()->groupBy('item_id');

        foreach ($products as $product) {
            $product->badge = 'New';
            $product->rating = $product->dynamic_rating > 0 ? $product->dynamic_rating : 5.0;
            $product->reviews_count = $product->dynamic_reviews_count;
            $product->sold_count = 20;

            $product->supplier = (object) [
                'id' => 1,
                'name' => 'Verified Seller',
                'location' => 'Colombo'
            ];

            // Format Colors & Sizes
            $productColors = $allColors->get($product->id, collect());
            $product->formatted_colors = $productColors->map(function ($c) {
                return $c->name . ',' . (isset($c->code) ? $c->code : '#000000');
            })->implode('|');

            $productSizes = $allSizes->get($product->id, collect());
            $product->formatted_sizes = $productSizes->pluck('size_name')->implode(',');

            $discountPercent = 0;
            if (!empty($product->discount_value) && $product->discount_value > 0) {
                if ($product->discount_type === 'percentage') {
                    $discountPercent = (float) $product->discount_value;
                } elseif ($product->discount_type === 'fixed' && $product->price > 0) {

                    $discountPercent = round(($product->discount_value / $product->price) * 100);
                }
            }

            $product->computed_discount = $discountPercent;
        }


        if ($request->ajax() || $request->wantsJson() || $request->hasHeader('X-Requested-With')) {
            $html = '';

            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $badgeHTML = !empty($product->badge) ? '<span class="badge badge-bestseller">' . e($product->badge) . '</span>' : '';
                    $imageSrc = $product->image_url ? asset($product->image_url) : asset('/upload/default.png');
                    $ratingVal = number_format($product->rating, 1);

                    $colors = !empty($product->formatted_colors) ? $product->formatted_colors : 'White,#ffffff';
                    $sizes = !empty($product->formatted_sizes) ? $product->formatted_sizes : 'Free Size';
                    $deliveryFee = '350';

                    $basePrice = (float) $product->price;
                    $discountAmt = 0;

                    if ($product->discount_type === 'percentage') {
                        $discountAmt = $basePrice * ($product->discount_value / 100);
                    } elseif ($product->discount_type === 'fixed') {
                        $discountAmt = (float) $product->discount_value;
                    }

                    $finalPrice = $basePrice - $discountAmt;

                    $priceHTML = '';
                    if ($discountAmt > 0) {
                        $priceHTML = 'Rs. ' . number_format($finalPrice, 0) .
                            ' <span style="text-decoration: line-through; color: #aaa; font-size: 12px; margin-left: 5px;">Rs. ' . number_format($basePrice, 0) . '</span>';
                    } else {
                        $priceHTML = 'Rs. ' . number_format($basePrice, 0);
                    }

                    $starsHTML = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $starsHTML .= ($i <= round($product->rating)) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }

                    $html .= '
                <div class="card" style="cursor: pointer;" onclick="openProductModal(this)" 
                     data-title="' . e($product->title) . '" 
                     data-price="' . $basePrice . '" 
                     data-discount="' . $product->computed_discount . '"
                     data-delivery="Rs. ' . number_format($deliveryFee, 0) . '"
                     data-colors="' . e($colors) . '"
                     data-sizes="' . e($sizes) . '"
                     data-image="' . $imageSrc . '"
                     data-rating="' . $ratingVal . '"
                     data-reviews="' . $product->reviews_count . '">
                    <div class="card-img">
                        ' . $badgeHTML . '
                        <img src="' . $imageSrc . '" alt="' . e($product->title) . '">
                    </div>
                    <div class="card-body">
                        <p class="product-title">' . e($product->title) . '</p>
                        <div class="price">' . $priceHTML . '</div>
                        <div class="card-rating">
                            <div class="stars">' . $starsHTML . '</div>
                            <span class="rating-text">' . $ratingVal . ' (' . $product->reviews_count . '+ Reviews)</span>
                        </div>
                        <div class="supplier-info">
                            <span class="supplier-label">Sold by:</span>
                            <a href="#" class="supplier-name">' . e($product->supplier->name) . '</a>
                            <span class="supplier-location">| ' . e($product->supplier->location) . '</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">' . $product->sold_count . '+ sold</div>
                            <div class="cart-action-container" onclick="event.stopPropagation();">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="' . asset('/upload/shoppingcart3.png') . '" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            } else {
                $html = '<div style="color: #ffffff; grid-column: 1/-1; text-align:center; padding: 40px; font-size: 1.1rem;">No products found matching your filter selections.</div>';
            }

            return response()->json(['html' => $html]);
        }

        return view('shop', compact('products'));
    }
}