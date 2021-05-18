@extends('layout')
@section('name')
    Особистий кабінет
@endsection
@section('content')
   <div class="container p-4">
    <form method="post" enctype="multipart/form-data" action="{{route('aboutUserSubmit')}}">
        @csrf
        <div class="form-group m-0 p-0" hidden>
            <input type="text" class="form-control" name="id" id="id" value="{{$info->id}}">
        </div>
        <div class="form-group">
            <label for="pib">ПІБ</label>
            <input type="text" class="form-control" name="pib" placeholder="" value="{{$info->pib}}">
        </div>
        <div class="form-group">
            <label for="age">Вік</label>
            <input type="text" class="form-control" name="age" placeholder="" value="{{$info->age}}">
        </div>
        <div class="form-group">
            <label for="phone_number">Номер телефону (0670000000)</label>
            <input type="text" class="form-control" name="phone_number" placeholder="" value="{{$info->phone_number}}">
        </div>
        <div class="form-group">
            <label for="address">Адреса</label>
            <input type="text" class="form-control" name="address" placeholder="" value="{{$info->address}}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Оновити інформацію</button>
    </form>
   </div>
@endsection
