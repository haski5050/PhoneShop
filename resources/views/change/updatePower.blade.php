@extends('layout')
@section('name')
    Редагувати інформацію про портативну батарею
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
        <form method="post" action="{{route('updatePowerSubmit')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="id" id="id" value="{{$power->id}}">
            </div>
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="product_id" id="product_id" value="{{$power->product_id}}">
            </div>
            <div class="form-group">
                <label for="name">Назва</label>
                <input type="text" class="form-control" value="{{$power->name}}" name="name" placeholder=""required>
            </div>
            <div class="form-group">
                <label for="output">Тип виходу</label>
                <input type="text" class="form-control" value="{{$power->output}}" name="output" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="energy">Заряд</label>
                <input type="number" class="form-control" value="{{$power->energy}}" name="energy" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="power">Потужність</label>
                <input type="number" class="form-control" value="{{$power->power}}" name="power" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="price">Ціна</label>
                <input type="number" class="form-control" value="{{$power->price}}" name="price" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="count">Кількість</label>
                <input type="number" class="form-control" value="{{$power->count}}" name="count" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Image1">Картинка 1</label>
                <input type="file" class="form-control-file" name="Image1">
                <input type="checkbox" name="Check1">Видалити фото
            </div>
            <div class="form-group">
                <label for="Image2">Картинка 2</label>
                <input type="file" class="form-control-file" name="Image2">
                <input type="checkbox" name="Check2">Видалити фото
            </div>
            <div class="p-3">
                <button type="submit" class="btn btn-primary p-2">Оновити</button>
                <a href="{{route('deletePowerSubmit',['id'=>$power->product_id])}}" class="btn btn-danger p-2">Видалити</a>
            </div>
        </form>

    </div>
@endsection
