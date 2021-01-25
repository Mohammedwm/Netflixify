<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    public function _construct()
    {
        $this->middleware('permission:read_categories')->only(['index']);
        $this->middleware('permission:create_categories')->only(['create','store']);
        $this->middleware('permission:update_categories')->only(['edit','update']);
        $this->middleware('permission:delete_categories')->only(['destroy']);
    }

    public function index(){
        $categories = Category::whenSearch(request()->search)
        ->withCount('movies')
        ->paginate(2);
        return view('dashboard.categories.index',compact('categories'));
    }
    public function create(){
        return view('dashboard.categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required|unique:categories,name',
        ]);

        Category::create($request->all());
        session()->flash('success','Data added successfully');
        return redirect()->route('dashboard.categories.index');
    }

    public function show(){

    }

    public function edit(Category $category){
        return view('dashboard.categories.edit',compact('category'));
    }

    public function update(Request $request ,Category $category){
        $request->validate([
            'name'=> 'required|unique:categories,name,' .$category->id,
        ]);

        $category->update($request->all());
        session()->flash('success','Data updated successfully');
        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category){
        $category->delete();
        session()->flash('success','Data deleted successfully');
        return redirect()->route('dashboard.categories.index');
    }
}
