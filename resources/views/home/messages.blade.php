@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
                @include('home.partials.sidebar')
        </div>

        <div class="col-8">
            <h2>All Messages</h2>
            <ul class="list-group">
                @foreach ($messages as $message)

         <li class="list-group-item mb-2">
    <p>Oglas: {{ $message->ad->title }} <span  class="float-end">{{ $message->created_at->format('d M Y') }}</span></p>
                <p>From:  {{$message->sender->name }}</p>
                <p><strong>{{ $message->text }}</strong></p>
     <a  class="btn btn-primary" href="{{ route('home.reply', ['sender_id'=>$message->sender->id, 'ad_id'=>$message->ad_id])}}">Reply msg</a>


     <a class="btn btn-danger btn-sm text-right"   href="/home/{{ $message->id }}/delete">Delete msg</a>
        </li>
                @endforeach
                @if (session()->has('poruka'))
                <div class="alert alert-success">
                    {{session()->get('poruka')}}
                </div>

                @elseif(session()->has('msgDel'))
                <div class="alert alert-success">
                    {{session()->get('msgDel')}}
                </div>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
