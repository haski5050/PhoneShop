@extends('layout')
@section('name')
    Кошик
@endsection
@section('content')
    <style>
        @media (max-device-width: 768px){
            .mob-fix {
                height: auto !important;
                line-height: 20px !important;
                text-align: center;
            }
        }
    </style>
    @if($isProducts)
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 25px; line-height: 25px;">
                    <span>Зображення:</span>
                </div>
                <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
                    <span>Категорія:</span>
                </div>
                <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
                    <span>Назва:</span>
                </div>
                <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
                    <span>Ціна:</span>
                </div>
                <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
                    <span>Кількість:</span>
                </div>
            </div>
            <hr>
            @empty(!$data['Смартфони'])
                @foreach($data['Смартфони'] as $el)
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 100px; line-height: 100px;">
                            <img  src="{{ URL::asset('images/'.$el->cid.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                        </div>
                        <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>Смартфони</span>
                        </div>
                        <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->mark}} {{$el->model}}</span>
                        </div>
                        <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->price}}</span>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->count}}</span>
                        </div>
                        <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <a href="" class="btn btn-outline-danger">Видалити</a>
                        </div>
                    </div>
                </div>
        </div>
        <br>
        @endforeach
    @endempty
        <div style="width: 100%; text-align: right;" class="container">
            <hr>
            <div style="width: 50%; float: right;" class="p-1">
                <a class="btn btn-outline-success" href="">Оформити замовлення</a>
            </div>
        </div>
    @else
        <div class="text-center">
            <h3>Товарів в кошику немає</h3>
            <a href="{{route('homePage')}}" class="btn btn-outline-success">Повернутися до товарів</a>
        </div>
    @endif
@endsection
