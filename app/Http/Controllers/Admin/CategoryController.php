<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    // ? Protege las url para que un usuario si rol no pueda acceder
    public function __construct()
    {
        $this->middleware('can:admin.categories.index')->only('index');
        $this->middleware('can:admin.categories.create')->only('create','store');
        $this->middleware('can:admin.categories.edit')->only('edit','update');
        $this->middleware('can:admin.categories.destroy')->only('destroy');
    }
    
    public function index()
    {
        // recupero todas las categorias
        $categories= Category::all();
        return view('admin.categories.index', compact('categories'));
    }

   
    public function create()
    {
        return view('admin.categories.create');
    }

    
    public function store(Request $request)
    {
        // reglas de validacion
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories'

        ]);
       $category= Category::create($request->all());
       return redirect()->route('admin.categories.edit',$category)->with('info','La categoría se créo con exito');
        
    }


    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        /// reglas de validacion
        $request->validate([
            'name'=>'required',
            'slug'=>"required|unique:categories,slug,$category->id"

        ]);
        $category->update($request->all());
        return redirect()->route('admin.categories.edit',$category)->with('info','La categoría se actualizo con exito');
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('info','La categoría se elminó con exito');
    }
}
