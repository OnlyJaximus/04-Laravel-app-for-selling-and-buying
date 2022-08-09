@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
                @include('home.partials.sidebar')
        </div>

        <div class="col-8">
           <form action="{{ route('home.saveAd')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name='title' placeholder="title"
            class="form-control {{ $errors->has('title') ? 'alert alert-danger' : '' }}" value={{ old('title') }}><br>

            <textarea name="body"  cols="30" rows="10"  placeholder="body"
            class="form-control {{ $errors->has('body') ? 'alert alert-danger' : '' }}" >{{ old('body') }}
           </textarea><br>

            <input type="number" name="price" placeholder="price"
            class="form-control {{$errors->has('price') ? 'alert alert-danger': '' }}"><br>

            <input type="file" name="image1" class="form-control">
            <input type="file" name="image2" class="form-control">
            <input type="file" name="image3" class="form-control"><br>
            <select name="category" class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
             </select><br>
             <button type="submit" class="btn btn-primary">Save</button>
           </form><br>
           @if($errors->any())
           <div class="alert alert-danger" role="alert">
            {{-- <p class="text-danger">There was an error, try again latter</p> --}}
            <p >There was an error, try again latter!</p>
           </div>


           @endif
        </div>
    </div>
</div>
@endsection
