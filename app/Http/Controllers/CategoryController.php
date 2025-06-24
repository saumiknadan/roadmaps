<?php

namespace App\Http\Controllers;
use Validator;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            try{
                $category = new Category;
                $category->name = $request->name;
                
                $category->save();
                return response()->json(['status' => 1, 'success' => 'Information has been created !!']);
            }catch (\Exception $e){
                return response()->json(['status' => 2, 'success' => 'Something']);
                session()->flash('error','Something went wrong');
                return redirect()->back();
            }
        }
    }

    public function change_status(Category $category)
    {
        
        if($category->status==1)
        {
            $category->update(['status'=>0]);
        }
        else
        {
            $category->update(['status'=>1]);
        }

        session()->flash('success', 'Status changed successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
       
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            try{
                $category = Category::findOrFail($id);
                $category->name = $request->name;
                
                $category->save();
        
                
                return response()->json(['status' => 1, 'success' => 'Information has been created !!']);
            }catch (\Exception $e){
                return response()->json(['status' => 2, 'success' => 'Something']);
                session()->flash('error','Something went wrong');
                return redirect()->back();
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        try{
            $category = Category::findOrFail($id);

            $delete = $category->delete();
            session()->flash('success', 'Category deleted successfully');

            return redirect()->back();
        }catch (\Exception $e){
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }
               
    
    }
}
