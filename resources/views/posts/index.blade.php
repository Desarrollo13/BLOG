<x-app-layout>
    <div class="container py-8 ">
        {{-- parte responisve --}}
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
           @foreach ($posts as $post)
           {{-- pregunto si me encuentro en la primera interacion $loop->first --}}
           <article class="w-full h-80 bg-cover bg-center @if($loop->first) md:col-span-2 @endif " style="background-image: url(@if($post->image) {{ Storage::url($post->image->url) }} @else https://cdn.pixabay.com/photo/2020/12/10/10/17/jasper-national-park-5819878_960_720.jpg @endif)">
            
               {{-- vamos a trabajar en nombre del post --}}
               <div class="w-full h-full px-8 flex flex-col justify-center">
                   {{-- tambien voy mostrar las etiquetas los tag --}}
                <div>
                    @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.tag',$tag) }}" class="inline-block px-3 h-6 bg-{{ $tag->color }}-600 text-white rounded-full">{{ $tag->name }}</a>
                        
                    @endforeach
                 </div>
                 {{-- titulo de las etiquetas --}}
                   <h1 class="text-4xl text-white leading-8 font-bold mt-2">
                       <a href="{{ route('posts.show', $post) }}">
                           {{-- vamos a imprimir el nombre del posts --}}
                           {{ $post->name }}
                       </a>
                   </h1>

               </div>
           </article>
           {{-- llegue hasta el minuto 21:14 capitulo 06 --}}
               
           @endforeach

       </div>
       {{-- paginacion nuestro link  --}}
       <div class="mt-4">
           {{ $posts->links() }}

       </div>

    </div>
</x-app-layout>