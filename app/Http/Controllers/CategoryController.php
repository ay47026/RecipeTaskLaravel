<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Recipe;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return view('home',["cat" => $category]);
    }

    public function list()
    {
       
        $recipe = Recipe::with('category')->get();
    
        foreach($recipe as $rec){
            $rec->category_id = $rec->category->name;
        }
        return response($recipe);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $recipe = new Recipe;
        // $users = DB::table('users')
        $recipe->recipe_name = $request->recipe_name;
        $recipe->range_from = $request->range_from;
        $recipe->range_to = $request->range_to;
        $recipe->category_id = $request->category_id;

        $name =   $recipe->where('recipe_name', '=', $request->recipe_name)
            ->get();
        $flag = false;

        // $name = $recipe->intersect(Recipe::whereIn('recipe_name',$request->recipe_name )->get());
        if ($name->isEmpty()) {
            $recipe->save();
            return response('successfully added!');
        } else {
            $same =   $recipe->where('recipe_name', '=', $request->recipe_name)
                ->where('category_id', '=', $request->category_id)
                ->get();
            if ($same->isEmpty()) {

                foreach ($name as $name) {

                    if ($name->category_id < $request->category_id) {
                        if ($name->range_to  < $request->range_from) {
                            $recipe->save();
                            return response('successfully added!');
                        } else {
                            return response("  Please enter large range");
                        }
                    } else {
                        return response(" Please enter another category");
                    }
                }
            } else {

                return response(" Recipci nnot added due to name and category are same");
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'recipe.csv';
        $recipe = Recipe::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'name', 'range from', 'range to', 'category id');

        $callback = function () use ($recipe, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($recipe as $recipe) {

                fputcsv($file, array($recipe->id, $recipe->recipe_name, $recipe->range_from, $recipe->range_to, $recipe->category_id));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
