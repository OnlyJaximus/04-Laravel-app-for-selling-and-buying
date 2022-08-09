@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
                @include('home.partials.sidebar')
        </div>

        <div class="col-8">
            <h2>Vasi aktivni oglasi</h2>
            {{-- <h2>All Ads</h2> --}}
            <ul class="list-group">
                @foreach ($all_ads as $ad)

                    <li class="list-group-item">
                    <a class="btn btn-warning"   href="{{ route('home.singleAd', ['id' => $ad->id]) }}">{{ $ad->title }} <small class="text-white bg-dark">view</small></a>


                            <img src="{{ asset('ad_images/'.$ad->image1) }}"  width="70px"  height="70px" alt="Img">


                            {{-- Edit --}}
                            {{-- <a class="btn btn-sm btn-info
                            position-absolute top-0 start-50 translate-middle-x my-1"

                            href="{{ route('home.editPost', [$ad->id]) }}">Edit Oglas</a> --}}


                            <a class="btn btn-sm btn-info
                            position-absolute top-50 start-50  translate-middle-y"

                            href="{{ route('home.editPost', [$ad->id]) }}">Izmeni Oglas</a>





             <a class="btn btn-sm btn-danger position-absolute top-50 end-0 translate-middle-y"
                      href="{{ route('home.dltPost', [$ad->id]) }}">Obrisi Oglas</a>   </li>


                @endforeach
            </ul><br><br>

            @if (session()->has('dlt'))
            <div class="alert alert-success">
                {{session()->get('dlt')}}
            </div>
           @endif
        </div>
    </div>
</div>
@endsection
