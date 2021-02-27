<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // ? Protege las url para que un usuario si rol no pueda acceder
    public function __construct()
    {
        $this->middleware('can:admin.posts.index')->only('index');
        $this->middleware('can:admin.posts.create')->only('create','store');
        $this->middleware('can:admin.posts.edit')->only('edit','update');
        $this->middleware('can:admin.posts.destroy')->only('destroy');
    }
    public function index()
    {
        return view('admin.posts.index');
    }

    
    public function create()
    {
        $categories = Category::pluck('name','id');
        $tags=Tag::all();
        
        return view('admin.posts.create',compact('categories','tags'));
    }

    
    public function store(PostRequest $request)
    {
        
       $post= Post::create(request()->all());

       if($request->file('file')){

          $url= Storage::put('posts',$request->file('file'));
          $post->Image()->create([
              'url'=>$url
          ]);

       }
       
       if($request->tags){
        // ?recupero la relacion de muchos a muchos   
           $post->tags()->attach($request->tags);

       }
       return redirect()->route('admin.posts.edit',$post);
    }

    
   
    
    public function edit(Post $post)
    {
        $this->authorize('author',$post);
        $categories = Category::pluck('name','id');
        $tags=Tag::all();
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    
    public function update(PostRequest $request,Post $post)
    {
        // regla de validacion
        $this->authorize('author',$post);
        $post->update($request->all());
        if($request->file('file')){
           $url= Storage::put('posts',$request->file('file'));
        //    consulta si ya existe una imagen y si existe la elimino
           if($post->image){
               Storage::delete($post->image->url);
               $post->image->update([
                   'url'=>$url
               ]);
           }else{
            // ?   cree un nuevo registro en la tabla image y lo relaciones con este post
            
            $post->image()->create([
                'url'=>$url

            ]);

           }

        }
        if($request->tags){
            // ?recupero la relacion de muchos a muchos  el metodo sync sincroniza los registros existentes con los que quiero actualizar  
               $post->tags()->sync($request->tags);
    
           }


        return redirect()->route('admin.posts.edit',$post)->with('info','El post se actualizo con exito');
    }

    
    public function destroy(Post $post)
    {
        // regla de validacion
        $this->authorize('author',$post);
        $post->delete();
        return redirect()->route('admin.posts.index',$post)->with('info','El post se elimino con exito');
    }
}
