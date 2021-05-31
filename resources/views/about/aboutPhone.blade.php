@extends('layout')
@section('name')
    {{$phone->mark}} {{$phone->model}}
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
                        <h3>{{$phone->mark}} {{$phone->model}}</h3>
                        <h2 style="color: #2a9055;">{{$phone->price}}₴</h2>
                        <ul class="list">
                            @if($phone->count>0)
                            <li><p class="active">В наявності</p></li>
                            @else
                            <li><p class="active">Немає в наявності</p></li>
                            @endif
                            <li><a href="{{route('selectPhonesFromCategory',[$category->id])}}"><span>Категорія</span> : {{$category->name}}</a></li>
                            @auth('web')
                            <li><a href="{{route('addFavorite',$phone->product_id)}}">Додати до вподобань</a></li>
                            @endauth
                        </ul>
                        <p>{{$phone->description}}</p>
                        <div class="product_count">
                            <form method="post" action="{{route('addToBasketSubmit',[$phone->product_id])}}" class="p-5">
                                @csrf
                                @if($phone->count>0)
                                    <span>Кількість:</span>
                                    <input type="number" name="count" value="1" style="width: 11%" min="1" max="{{$phone->count}}">
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
                            <h5>Діагональ дисплея</h5>
                        </td>
                        <td>
                            <h5>{{$phone->display}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Роздільна здатність</h5>
                        </td>
                        <td>
                            <h5>{{$phone->screen_resolution}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Тип екрану</h5>
                        </td>
                        <td>
                            <h5>{{$phone->screen_type}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Стандарти зв'язку</h5>
                        </td>
                        <td>
                            <h5>{{$phone->communication}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість сім карт</h5>
                        </td>
                        <td>
                            <h5>{{$phone->sim}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Модель процесора</h5>
                        </td>
                        <td>
                            <h5>{{$phone->cpu}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість ядер</h5>
                        </td>
                        <td>
                            <h5>{{$phone->cores}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Частота ядер</h5>
                        </td>
                        <td>
                            <h5>{{$phone->cpu_frequency}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Модель графічного процесора</h5>
                        </td>
                        <td>
                            <h5>{{$phone->gpu}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість оперативної пам'яті</h5>
                        </td>
                        <td>
                            <h5>{{$phone->ram}} gb</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість пам'яті</h5>
                        </td>
                        <td>
                            <h5>{{$phone->rom}} gb</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість мегапікселів основної камери</h5>
                        </td>
                        <td>
                            <h5>{{$phone->back_camera}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Роздільна здатність зйомки відео</h5>
                        </td>
                        <td>
                            <h5>{{$phone->back_video}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Кількість мегапікселів фронтальної камери</h5>
                        </td>
                        <td>
                            <h5>{{$phone->front_camera}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Спалах</h5>
                        </td>
                        <td>
                            <h5>{{$phone->flash}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Батарея</h5>
                        </td>
                        <td>
                            <h5>{{$phone->battery}} mAh</h5>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
           @include('feedback_layout',array('some'=>'phone->product_id'))
        </div>
    </div>
</div>

@endsection
