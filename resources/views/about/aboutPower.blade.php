@extends('layout')
@section('name')
    {{$power->name}}
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
                        <h3>{{$power->name}}</h3>
                        <h2 style="color: #2a9055;">{{$power->price}}₴</h2>
                        <ul class="list">
                            @if($power->count>0)
                                <li><p class="active">В наявності</p></li>
                            @else
                                <li><p class="active">Немає в наявності</p></li>
                            @endif
                            @auth('web')
                                <li><a href="{{route('addFavorite',$power->product_id)}}">Додати до вподобань</a></li>
                            @endauth
                        </ul>
                        <div class="product_count">
                            <form method="post" action="{{route('addToBasketSubmit',[$power->product_id])}}" class="p-5">
                                @csrf
                                @if($power->count>0)
                                    <span>Кількість:</span>
                                    <input type="number" name="count" value="1" style="width: 11%" min="1" max="{{$power->count}}">
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
                                <h5>Тип виходу</h5>
                            </td>
                            <td>
                                <h5>{{$power->output}}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Місткість</h5>
                            </td>
                            <td>
                                <h5>{{$power->energy}} mAh</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Сила струму</h5>
                            </td>
                            <td>
                                <h5>{{$power->power}} А</h5>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <div class="p-4">
                    <div class="col-xs-12 col-md-6">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-12 col-md-6 text-center">
                                    <h1 class="rating-num">4.0</h1>
                                    <div>
                                        <span class="glyphicon glyphicon-user"></span>1,050,008 Всього
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="row rating-desc">
                                        <div class="col-xs-3 col-md-3 text-right">
                                            <span class="glyphicon glyphicon-star"></span>5
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    <span class="sr-only">80%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 5 -->
                                        <div class="col-xs-3 col-md-3 text-right">
                                            <span class="glyphicon glyphicon-star"></span>4
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                    <span class="sr-only">60%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 4 -->
                                        <div class="col-xs-3 col-md-3 text-right">
                                            <span class="glyphicon glyphicon-star"></span>3
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 3 -->
                                        <div class="col-xs-3 col-md-3 text-right">
                                            <span class="glyphicon glyphicon-star"></span>2
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                    <span class="sr-only">20%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 2 -->
                                        <div class="col-xs-3 col-md-3 text-right">
                                            <span class="glyphicon glyphicon-star"></span>1
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                                    <span class="sr-only">15%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end 1 -->
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                    <h5 class="mb-4">Залиште відгук</h5>
                    <div class="mb-4">
		 <span class="star-rating">
		 <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></a>
		 <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></i></a>
		 <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></i></a>
		 <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></i></a>
		 <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></i></a>
		 </span></div>
                    <form>
                        <div class="form-group">
                            <label>Ваш відгук</label>
                            <textarea class="form-control">
			</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm p-1" type="button"> Залишити відгук </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
