@extends('layout')
@section('name')
    Редагувати інформацію про чохол
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
        <form method="post" action="{{route('updateCaseSubmit')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="id" id="id" value="{{$case->id}}">
            </div>
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="product_id" id="product_id" value="{{$case->product_id}}">
            </div>
            <div class="form-group">
                <label for="name">Назва</label>
                <input type="text" class="form-control" value="{{$case->name}}" name="name" placeholder=""required>
            </div>
            <div class="form-group">
                <label for="material">Матеріал</label>
                <input type="text" class="form-control" value="{{$case->material}}" name="material" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="price">Ціна</label>
                <input type="number" class="form-control" value="{{$case->price}}" name="price" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="count">Кількість</label>
                <input type="number" class="form-control" value="{{$case->count}}" name="count" placeholder="" required>
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
                <a href="{{route('deleteCaseSubmit',['id'=>$case->product_id])}}" class="btn btn-danger p-2">Видалити</a>
            </div>
        </form>

    </div>
@endsection
