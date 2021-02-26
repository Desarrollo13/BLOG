@extends('adminlte::page')
@section('title', 'Desarrollo13')

@section('content_header')
    @can('admin.tags.create')
        <a class="btn btn-secondary btn-sm float-right" href="{{ route('admin.tags.create') }}">Nueva etiqueta</a>
        
    @endcan


    <h1>Mostrar listado de etiqueta</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert  alert-success">
            <strong>{{ session('info') }}</strong>

        </div>
        
    @endif
   <div class="card">
       <div class="card-body">
           <table class="table table-striped">
               <thead>
                   <tr>
                       <th>Id</th>
                       <th>Name</th>
                       <th colspan="2"></th>
                   </tr>

               </thead>
               <tbody>
                   @foreach ($tags as $tag)
                   <tr>
                       <td>
                           <td>{{ $tag->id }}</td>
                           <td>{{ $tag->name }}</td>
                           <td width="10px">
                               @can('admin.tags.edit')
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.tags.edit', $tag) }}">Editar</a>
                                   
                               @endcan
                           </td>
                           <td  width="10px">
                               @can('admin.tags.destroy')
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                 </form>
                                   
                               @endcan

                           </td>
                       </td>
                   </tr>
                       
                   @endforeach
                   {{-- llegue hasta el minuto 9:20 --}}

               </tbody>

           </table>
       </div>
   </div>
@stop

