<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return Inertia::render('products', ['data' => $data]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'qty' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'image' => ['required'],
            'availability' => ['required'],
        ])->validate();

        Product::create($request->all());

        return redirect()->back()
                    ->with('message', 'Product Created Successfully.');
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'qty' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'image' => ['required'],
            'availability' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Product::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Product Updated Successfully.');
        }
    }


    public function update_google_sheets()
    {
        $sheet = '1-1_yVsyktQXCOXk2rSEDWUe2tUeVXcg5G2EgeE-RjY0';
        $gid = '0';

        $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' .  $sheet . '/export?format=csv&gid=' . $gid);
        $csv = explode("\r\n", $csv);
        $products = array_map('str_getcsv', $csv);

        foreach ($products as $k => $product) {
            if ($k > 0) {
                 $save_product = Product::updateOrInsert(
                     ['id' =>  intval($product[0])],
                     [
                        'name' => strval($product[1]),
                        'qty' => intval($product[2]),
                        'description' => strval($product[3]),
                        'price' => intval($product[4]),
                        'image' => strval($product[5]),
                        'availability' => intval($product[6]),
                     ]
                 );
            }
        }

        return redirect()->back()
                ->with('message', 'Product Updated Successfully.');
    }

    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Product::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
