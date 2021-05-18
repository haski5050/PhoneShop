@extends('layout')
@section('name')
    Редагувати інформацію про телефон
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
        <form method="post" action="{{route('updatePhoneSubmit')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="id" id="id" value="{{$phone->id}}">
            </div>
            <div class="form-group m-0 p-0" hidden>
                <input type="text" class="form-control" name="product_id" id="product_id" value="{{$phone->product_id}}">
            </div>
            <div class="form-group">
                <label for="mark">Марка</label>
                <input type="text" class="form-control" value="{{$phone->mark}}" name="mark" placeholder=""required>
            </div>
            <div class="form-group">
                <label for="model">Модель</label>
                <input type="text" class="form-control" value="{{$phone->model}}" name="model" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="display">Діагональ дисплея</label>
                <input type="text" class="form-control" value="{{$phone->display}}" name="display" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="screen_resolution">Роздільна здатність</label>
                <input type="text" class="form-control" value="{{$phone->screen_resolution}}" name="screen_resolution" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="screen_type">Тип дисплею</label>
                <input type="text" class="form-control" value="{{$phone->screen_type}}" name="screen_type" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="communication">Стандарти зв'язку</label>
                <input type="text" class="form-control" value="{{$phone->communication}}" name="communication" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="sim">Кількість сім-карт</label>
                <input type="number" class="form-control" value="{{$phone->sim}}" name="sim" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="cpu">Модель процесора</label>
                <input type="text" class="form-control" value="{{$phone->cpu}}" name="cpu" placeholder="">
            </div>
            <div class="form-group">
                <label for="cores">Кількість ядер процесора</label>
                <input type="number" class="form-control" value="{{$phone->cores}}" name="cores" placeholder="">
            </div>
            <div class="form-group">
                <label for="cpu_frequency">Частота процесора</label>
                <input type="number" class="form-control" value="{{$phone->cpu_frequency}}" name="cpu_frequency" placeholder="">
            </div>
            <div class="form-group">
                <label for="gpu">Модель графічного процесора</label>
                <input type="text" class="form-control" value="{{$phone->gpu}}" name="gpu" placeholder="">
            </div>
            <div class="form-group">
                <label for="ram">ram</label>
                <input type="number" class="form-control" value="{{$phone->ram}}" name="ram" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="rom">rom</label>
                <input type="number" class="form-control" value="{{$phone->rom}}" name="rom" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="back_camera">Кількість мегапікселів основної камери</label>
                <input type="number" class="form-control" value="{{$phone->back_camera}}" name="back_camera" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="back_video">Роздільна здатність зйомки</label>
                <input type="text" class="form-control" value="{{$phone->back_video}}" name="back_video" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="front_camera">Кількість мегапікселів фронтальної камери</label>
                <input type="number" class="form-control" value="{{$phone->front_camera}}" name="front_camera" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="flash">Спалах</label>
                <input type="text" class="form-control" value="{{$phone->flash}}" name="flash" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="battery">Батарея</label>
                <input type="number" class="form-control" value="{{$phone->battery}}" name="battery" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="description">Довгий опис</label>
                <textarea class="form-control" name="description" rows="5">{{$phone->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Ціна</label>
                <input type="number" class="form-control" value="{{$phone->price}}" name="price" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="count">Кількість</label>
                <input type="number" class="form-control" value="{{$phone->count}}" name="count" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Категорія</label>
                <select class="form-control form-control-lg" name="phone_category">
                    @foreach($category as $el)
                        <option value="{{ $el->id }}">{{ $el->name }}</option>
                    @endforeach
                </select>
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
                <a href="{{route('deletePhoneSubmit',['id'=>$phone->product_id])}}" class="btn btn-danger p-2">Видалити</a>
            </div>
        </form>


    </div>
@endsection
