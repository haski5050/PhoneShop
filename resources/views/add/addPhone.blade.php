@extends('layout')
@section('name')
    Додати інформацію про телефон
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
        <form method="post" action="{{route('addPhoneSubmit')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="Mark">Марка</label>
                <input type="text" class="form-control" name="mark" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Model">Модель</label>
                <input type="text" class="form-control" name="model" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="DisplayDiagonal">Діагональ дисплея</label>
                <input type="text" class="form-control" name="display" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="ScreenResolution">Роздільна здатність</label>
                <input type="text" class="form-control" name="screen_resolution" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="ScreenType">Тип дисплею</label>
                <input type="text" class="form-control" name="screen_type" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="CommunicationStandards">Стандарти зв'язку</label>
                <input type="text" class="form-control" name="communication" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="SIMCount">Кількість сім-карт</label>
                <input type="number" class="form-control" name="sim" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="CPUmodel">Модель процесора</label>
                <input type="text" class="form-control" name="cpu" placeholder="">
            </div>
            <div class="form-group">
                <label for="CoreNumbers">Кількість ядер процесора</label>
                <input type="number" class="form-control" name="cores" placeholder="">
            </div>
            <div class="form-group">
                <label for="CPUfrequency">Частота процесора</label>
                <input type="number" class="form-control" name="cpu_frequency" placeholder="">
            </div>
            <div class="form-group">
                <label for="GPUmodel">Модель графічного процесора</label>
                <input type="text" class="form-control" name="gpu" placeholder="">
            </div>
            <div class="form-group">
                <label for="RAM">RAM</label>
                <input type="number" class="form-control" name="ram" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="ROM">ROM</label>
                <input type="number" class="form-control" name="rom" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="MainCamera">Кількість мегапікселів основної камери</label>
                <input type="number" class="form-control" name="back_camera" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="VideoResolution">Роздільна здатність зйомки</label>
                <input type="text" class="form-control" name="back_video" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="FrontCamera">Кількість мегапікселів фронтальної камери</label>
                <input type="number" class="form-control" name="front_camera" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Flash">Спалах</label>
                <input type="text" class="form-control" name="flash" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="Battery">Батарея</label>
                <input type="number" class="form-control" name="battery" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="LongDescription">Опис</label>
                <textarea class="form-control" name="description" rows="5"></textarea>
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
            </div>
            <div class="form-group">
                <label for="Image1">Картинка 2</label>
                <input type="file" class="form-control-file" name="Image2">
            </div>
            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
@endsection
