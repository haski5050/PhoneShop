@extends('layout')
@section('name')
    Головна
@endsection
@section('content')
    @foreach($phones as $el)
        <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
            @isset($image[$el->cid])
            <img src="{{ URL::asset($image[$el->cid]) }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
            @endisset
            <div class="card-body" >
                <h5 class="card-title">{{$el->mark}} {{$el->model}}</h5>
                <p class="card-text">{{\Illuminate\Support\Str::limit($el->description,100,"...")}}</p>
                <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                <a href="{{route('aboutPhonePage',$el->cid)}}" class="btn btn-primary">Детальніше</a>
                @auth('admin')
                    <a href="{{route('updatePhonePage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                @endauth
            </div>
        </div>
    @endforeach
@endsection
