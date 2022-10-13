<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    private $models = [
        'Product' => 'Product',
        'Order' => 'Order',
        'Category' => 'Category',
        'Type' => 'Type',
        'Slider' => 'Slider',
    ];

    public function globalSearch(Request $request)
    {
        $search = $request->input('search');

        if ($search === null || !isset($search['term'])) {
            return response()->json([
                'results' => 'Error'
            ]);
        }

        $term = $search['term'];
        $searchableData = [];

        foreach ($this->models as $model => $translation) {
            $modelClass = 'App\Models\\' . $model;
            $query = $modelClass::query();

            $fields = $modelClass::$searchable;

            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $term . '%');
            }

            $results = $query->take(10)->get();

            foreach ($results as $result) {
                $parsedData = $result->only($fields);
                $parsedData['model'] = trans($translation);
                $parsedData['fields'] = $fields;
                $formattedFields = [];
                foreach ($fields as $field) {
                    $formattedFields[$field] = Str::title(str_replace('_', $result, $field));
                }
                $parsedData['fields_formated'] = $formattedFields;
                $parsedData['url'] = url('/mobile/admin/' . Str::plural(Str::snake($modelClass)));

                $searchableData[] = $parsedData;
            }
        }

        return response()->json([
            'results' => $searchableData
        ]);
    }

    public function searching()
    {
        $product = Product::query()->when(request('search'), function ($query) {
            $query->where('name_en', 'LIKE', '%' . request('search') . '%')
                ->orWhere('name_ar', 'LIKE', '%' . request('search') . '%')
                ->orWhere('price', 'LIKE', '%' . request('search') . '%');
        })->paginate();


        $products = Product::search(request('search'))->paginate();

        if (auth('api')->check()) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $product,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error',
                'data' => $products,
            ]);
        }
        return view('cms.search', compact('products'));
    }
}
