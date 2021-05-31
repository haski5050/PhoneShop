@extends('layout')
@section('name')
    {{$memory->name}}
@endsection
@section('content')
    <div class="product_image_area">
        <div class="container p-4">
            <div class="row s_product_inner">
                <style>.carousel-inner > .carousel-item > img { width:100%; height:570px; object-fit: contain;} </style>
                <div class="col-6">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ URL::asset($image[0]) }}" class="d-block w-100">
                            </div>
                            @isset($image[1])
                                <div class="carousel-item">
                                    <img src="{{ URL::asset($image[1]) }}" class="d-block w-100">
                                </div>
                            @endisset
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev" style="filter: invert(100%) ">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Попередня</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next" style="filter: invert(100%) " >
                            <span class="carousel-control-next-icon" aria-hidden="true" ></span>
                            <span class="visually-hidden" >Наступна</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>{{$memory->name}}</h3>
                        <h2 style="color: #2a9055;">{{$memory->price}}₴</h2>
                        <ul class="list">
                            @if($memory->count>0)
                                <li><p class="active">В наявності</p></li>
                            @else
                                <li><p class="active">Немає в наявності</p></li>
                            @endif
                            @auth('web')
                                <li><a href="{{route('addFavorite',$memory->product_id)}}">Додати до вподобань</a></li>
                            @endauth
                        </ul>
                        <div class="product_count">
                            <form method="post" action="{{route('addToBasketSubmit',[$memory->product_id])}}" class="p-5">
                                @csrf
                                @if($memory->count>0)
                                    <span>Кількість:</span>
                                    <input type="number" name="count" value="1" style="width: 11%" min="1" max="{{$memory->count}}">
                                    <input type="submit" class="btn btn-success p-2" value="В кошик" >
                                @else
                                    <span>Кількість:</span>
                                    <input type="number" name="count" value="1" style="width: 11%" disabled >
                                    <input type="submit" class="btn btn-success p-2" value="В кошик" disabled>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" style="font-size:large;" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Характеристики</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="history-tab" style="font-size:large;" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Відгуки</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h5>Обсяг пам'яті</h5>
                            </td>
                            <td>
                                <h5>{{$memory->memory}} gb</h5>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                @include('feedback_layout',array('some'=>'memory->product_id'))
            </div>
        </div>
    </div>

@endsection
