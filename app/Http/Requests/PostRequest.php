<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post=$this->route()->parameter('post');//null
        // ?reglas de validacion para cuando crea un registro
       $rules=[
           'name'=>'required',
           'slug'=>'required|unique:posts', 
           'status'=>'required|in:1,2',
           'file'=>'image'
       ];
    //    ?cuando vamos a editar un registro corre esta validacion
       if($post){
           $rules['slug']='required|unique:posts,slug, ' . $post->id;
       }
       if( $this -> status == 2){
        //    fusiona dos array este metodo
          $rules= array_merge($rules,[
               'category_id'=>'required',
               'tags'=>'required',
               'extract'=>'required',
               'body'=>'required'
           ]);
        //    llgue 14:10

       }
       return $rules;

    }
}
