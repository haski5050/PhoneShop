@extends('layout')
@section('name')
    Зарядні пристрої
@endsection
@section('content')
    @foreach($chargers as $el)
        <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
            @isset($image[$el->cid])
                <img src="{{ URL::asset($image[$el->cid]) }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
            @endisset
            <div class="card-body" >
                <h5 class="card-title">{{$el->name}}</h5>
                <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                <a href="{{route('aboutChargerPage',$el->cid)}}" class="btn btn-primary">Детальніше</a>
                @auth('admin')
                    <a href="{{route('updateChargerPage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                @endauth
            </div>
        </div>
    @endforeach
@endsection
