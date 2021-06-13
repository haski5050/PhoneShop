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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css" rel="stylesheet"/>

    <a href="#myModal" id="btn" class="btn btn-lg btn-primary" data-toggle="modal" hidden></a>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Помилка</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Кількість товару в корзині більше ніж на складі!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(request()->get('problem'))
        document.getElementById('btn').click();
        @endif
    </script>


    @if($isProducts)
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 25px; line-height: 25px;">
                    <span>Зображення:</span>
                </div>
                <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
                    <span>Категорія:</span>
                </div>
                <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 25px; line-height: 25px;">
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
                            <img  src="{{ URL::asset('images/'.$el->id.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                        </div>
                        <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>Смартфони</span>
                        </div>
                        <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->mark}} {{$el->model}}</span>
                        </div>
                        <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->price}}</span>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <span>{{$el->count}}</span>
                        </div>
                        <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                            <a href="{{route('deleteFromBasketSubmit',$el->product_id)}}" class="btn btn-outline-danger">Видалити</a>
                        </div>
                    </div>
                </div>
        <br>
        @endforeach
    @endempty
    @empty(!$data['Чохли'])
        @foreach($data['Чохли'] as $el)
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 100px; line-height: 100px;">
                        <img  src="{{ URL::asset('images/cases/'.$el->id.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                    </div>
                    <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>Чохли</span>
                    </div>
                    <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->name}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->price}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->count}}</span>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <a href="{{route('deleteFromBasketSubmit',$el->product_id)}}" class="btn btn-outline-danger">Видалити</a>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
    @endempty
    @empty(!$data['Зарядки'])
        @foreach($data['Зарядки'] as $el)
            <div class="container ">
                <div class="row">
                    <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 100px; line-height: 100px;">
                        <img  src="{{ URL::asset('images/chargers/'.$el->id.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                    </div>
                    <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>Зарядки</span>
                    </div>
                    <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->name}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->price}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->count}}</span>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <a href="{{route('deleteFromBasketSubmit',$el->product_id)}}" class="btn btn-outline-danger">Видалити</a>
                    </div>
                </div>
            </div>
            <br>
            @endforeach
            @endempty
    @empty(!$data['Батареї'])
        @foreach($data['Батареї'] as $el)
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 100px; line-height: 100px;">
                        <img  src="{{ URL::asset('images/powers/'.$el->id.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                    </div>
                    <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>Портативні батареї</span>
                    </div>
                    <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->name}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->price}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->count}}</span>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <a href="{{route('deleteFromBasketSubmit',$el->product_id)}}" class="btn btn-outline-danger">Видалити</a>
                    </div>
                </div>
            </div>
            <br>
            @endforeach
            @endempty
    @empty(!$data['Пам\'ять'])
        @foreach($data['Пам\'ять'] as $el)
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-sm-2 col-xs-12" style="height: 100px; line-height: 100px;">
                        <img  src="{{ URL::asset('images/memory/'.$el->id.'/1.png') }}" style="width: 80px; height: 80px; object-fit: contain;" />
                    </div>
                    <div  class="col-lg-2 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>Карти пам'яті</span>
                    </div>
                    <div  class="col-lg-3 col-sm-3 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->name}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-1 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->price}}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <span>{{$el->count}}</span>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-xs-12 mob-fix" style="height: 100px; line-height: 100px;">
                        <a href="{{route('deleteFromBasketSubmit',$el->product_id)}}" class="btn btn-outline-danger">Видалити</a>
                    </div>
                </div>
            </div>
            </div>
            <br>
            @endforeach
            @endempty
        </div>
        <div style="width: 100%; text-align: right;" class="container">
            <hr>
            <div style="width: 50%; float: right;" class="p-1">
                <a class="btn btn-outline-success" href="{{route('orderPage')}}">Оформити замовлення</a>
            </div>
        </div>
    @else
        <div class="text-center">
            <h3>Товарів в кошику немає</h3>
            <a href="{{route('homePage')}}" class="btn btn-outline-success">Повернутися до товарів</a>
        </div>
    @endif
@endsection
