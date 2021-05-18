@extends('layout')
@section('name')
    Аксесуари
@endsection
@section('content')
    <style>
        img {
            width:100%;
            height:200px;
            object-fit: contain;
        }
        a {
            color: black;
            text-decoration: none;
        }
    </style>

    <div class="row p-4" style="">
        <a href="{{route('casesPage')}}" class="col-lg-6">
        <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{URL::asset('images/system/1.png')}}" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Чохли</h5>
                    <p class="card-text">Персоналізуйте свій телефон по своєму стилю!</p>
                </div>
            </div>
        </div>
    </div>
        </a>
        <a href="{{route('chargersPage')}}" class="col-lg-6">
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{URL::asset('images/system/2.png')}}" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Зарядні пристрої</h5>
                    <p class="card-text">Довго заряджається телефон? Нова зарядка поможе!</p>
                </div>
            </div>
        </div>
    </div>
        </a>
        <a href="{{route('powerPage')}}" class="col-lg-6">
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{URL::asset('images/system/4.png')}}" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Портативні батареї</h5>
                    <p class="card-text">Часто подорожуєте але не маєте де зарядити телефон? Не проблема! Портативна батерея ідеально підійде!</p>
                </div>
            </div>
        </div>
    </div>
        </a>
        <a href="{{route('memoryPage')}}" class="col-lg-6">
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{URL::asset('images/system/3.png')}}" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Карти пам'яті</h5>
                    <p class="card-text">Поліпшіть свій телефон! Карта пам'яті ідеально для цього підійде.</p>
                </div>
            </div>
        </div>
        </div>
        </a>
    </div>
@endsection
