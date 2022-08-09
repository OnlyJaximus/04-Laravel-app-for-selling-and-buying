@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center mb-4 text-success">Edit post</h1>
        <div class="col-4">
                @include('home.partials.sidebar')
        </div>

        <div class="col-8">
           <form action="{{ route('home.updatePost', [$single_ad->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="text" name='title' placeholder="title"
            class="form-control {{ $errors->has('title') ? 'alert alert-danger' : '' }}" value={{$single_ad->title }}><br>

            <textarea name="body"  cols="30" rows="10"  placeholder="body"
            class="form-control {{ $errors->has('body') ? 'alert alert-danger' : '' }}" >{{ $single_ad->body }}
           </textarea><br>

            <input type="number" name="price" placeholder="price"
            class="form-control {{$errors->has('price') ? 'alert alert-danger': '' }}" value={{ $single_ad->price }}><br>

            {{-- hiden --}}
            <input type="hidden" name="old_image" value="{{ $single_ad->image1 }}">
            <input type="file" name="image1" class="form-control"><br>

            <img  src="{{ asset('ad_images/'.$single_ad->image1) }}" alt="Image" width="150px" height="150px"><br><br>

            <input type="file" name="image2" class="form-control"><br>
            <img src="{{ asset('ad_images/'.$single_ad->image2) }}" alt="Image" width="150px" height="150px"><br><br>

            <input type="file" name="image3" class="form-control"><br>
            <img src="{{ asset('ad_images/'.$single_ad->image3) }}" alt="Image" width="150px" height="150px"><br><br>

            <select name="category" class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
             </select><br>
             <button type="submit" class="btn btn-primary">Update</button>
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
