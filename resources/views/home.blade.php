@extends('layout')
@section('name')
    Головна
@endsection
@section('content')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css" rel="stylesheet"/>

    <a href="#myModal" id="btn" class="btn btn-lg btn-primary" data-toggle="modal" hidden></a>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Замовлення успішно оформлене</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Замовлення оформлене! Ближчим часом із вами зв'яжеться продавець для підтвердження. Не вимикайте телефон.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(request()->get('ok'))
        document.getElementById('btn').click();
        @endif
    </script>
    @isset($categories)
        <div class="text-center">
        @foreach($categories as $category)
            <a href="{{route('selectPhonesFromCategory',[$category->id])}}" class="btn btn-outline-secondary m-2">{{$category->name}}</a>
        @endforeach
        </div>
        <hr>
    @endisset
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
