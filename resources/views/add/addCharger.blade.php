@extends('layout')
@section('name')
    Додати інформацію про зарядний пристрій
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{route('addChargerSubmit')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Назва</label>
                <input type="text" class="form-control" name="name" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="output">Тип виходу</label>
                <input type="text" class="form-control" name="output" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="output_count">Кількість виходів</label>
                <input type="number" class="form-control" name="output_count" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="power">Потужність</label>
                <input type="number" class="form-control"  name="power" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Price">Ціна</label>
                <input type="number" class="form-control" name="price" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Count">Кількість</label>
                <input type="number" class="form-control" name="count" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Image1">Картинка 1</label>
                <input type="file" class="form-control-file" name="Image1">
            </div>
            <div class="form-group">
                <label for="Image1">Картинка 2</label>
                <input type="file" class="form-control-file" name="Image2">
            </div>
            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
@endsection
