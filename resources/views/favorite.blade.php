@extends('layout')
@section('name')
    Вподобання
@endsection
@section('content')
    @empty(!$data['Смартфони'])
        @foreach($data['Смартфони'] as $el)
            <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
                <img src="{{ URL::asset('images/'.$el->cid.'/1.png') }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
                <div class="card-body" >
                    <h5 class="card-title">{{$el->mark}} {{$el->model}}</h5>
                    <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                    <a href="{{route('aboutPhonePage',$el->cid)}}" class="btn btn-primary">Детальніше</a>
                    @auth('admin')
                        <a href="{{route('updatePhonePage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                    @endauth
                    @auth('web')
                        <a href="{{route('deleteFavoriteSubmit',$el->product_id)}}" class="btn btn-danger mt-2">Видалити із вподобань</a>
                    @endauth
                </div>
            </div>
        @endforeach
    @endempty
    @empty(!$data['Чохли'])
        @foreach($data['Чохли'] as $el)
            <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
                <img src="{{ URL::asset('images/cases/'.$el->cid.'/1.png') }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
                <div class="card-body" >
                    <h5 class="card-title">{{$el->name}}</h5>
                    <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                    <a href="{{route('aboutCasePage',$el->cid)}}" class="btn btn-primary">Детальніше</a>
                    @auth('admin')
                        <a href="{{route('updateCasePage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                    @endauth
                    @auth('web')
                        <a href="{{route('deleteFavoriteSubmit',$el->product_id)}}" class="btn btn-danger mt-2">Видалити із вподобань</a>
                    @endauth
                </div>
            </div>
        @endforeach
    @endempty
    @empty(!$data['Зарядки'])
        @foreach($data['Зарядки'] as $el)
            <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
                <img src="{{ URL::asset('images/chargers/'.$el->cid.'/1.png') }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
                <div class="card-body" >
                    <h5 class="card-title">{{$el->name}}</h5>
                    <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                    <a href="{{route('aboutChargerPage',$el->cid)}}" class="btn btn-primary">Детальніше</a>
                    @auth('admin')
                        <a href="{{route('updateChargerPage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                    @endauth
                    @auth('web')
                        <a href="{{route('deleteFavoriteSubmit',$el->product_id)}}" class="btn btn-danger mt-2">Видалити із вподобань</a>
                    @endauth
                </div>
            </div>
        @endforeach
    @endempty
    @empty(!$data['Батареї'])
        @foreach($data['Батареї'] as $el)
            <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
                <img src="{{ URL::asset('images/powers/'.$el->cid.'/1.png') }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
                <div class="card-body" >
                    <h5 class="card-title">{{$el->name}}</h5>
                    <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                    <a href="" class="btn btn-primary">Детальніше</a>
                    @auth('admin')
                        <a href="{{route('updatePowerPage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                    @endauth
                    @auth('web')
                        <a href="{{route('deleteFavoriteSubmit',$el->product_id)}}" class="btn btn-danger mt-2">Видалити із вподобань</a>
                    @endauth
                </div>
            </div>
        @endforeach
    @endempty
    @empty(!$data['Пам\'ять'])
        @foreach($data['Пам\'ять'] as $el)
            <div class="card " style="width: 18rem; display: inline-block; margin: 20px;">
                <img src="{{ URL::asset('images/powers/'.$el->cid.'/1.png') }}" class="card-img-top" style="width: 100%;height: 20vw;object-fit: contain">
                <div class="card-body" >
                    <h5 class="card-title">{{$el->name}} {{$el->memory}} GB</h5>
                    <h3 class="card-title" style="color: #2a9055">{{$el->price}} грн</h3>
                    <a href="" class="btn btn-primary">Детальніше</a>
                    @auth('admin')
                        <a href="{{route('updateMemoryPage',$el->cid)}}" class="btn btn-success">Редагувати</a>
                    @endauth
                    @auth('web')
                        <a href="{{route('deleteFavoriteSubmit',$el->product_id)}}" class="btn btn-danger mt-2">Видалити із вподобань</a>
                    @endauth
                </div>
            </div>
        @endforeach
    @endempty
@endsection
