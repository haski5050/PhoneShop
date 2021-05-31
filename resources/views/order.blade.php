@extends('layout')
@section('name')
    Замовлення
@endsection
@section('content')
    @auth('web')
        @isset($buyer)
            @empty(!$buyer)
            <form action="{{route('addOrderSubmit')}}" method="POST">
                @csrf
                <div class="container">
                    <input type="number" name="check" hidden value="0">
                    <div class="form-group">
                        <label for="pib">ПІБ</label>
                        <input type="text" class="form-control" name="pib" value="{{$buyer->pib}}" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Вік</label>
                        <input type="text" class="form-control" name="age" value="{{$buyer->age}}" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Номер телефону</label>
                        <input type="text" class="form-control" name="phone_number" value="{{$buyer->phone_number}}" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Адреса</label>
                        <input type="text" class="form-control" name="address" value="{{$buyer->address}}" placeholder="" required>
                    </div>
                    <b>Оплата здійснюється накладним платежом!</b>
                <div class="p-3">
                    <button type="submit" class="btn btn-outline-success">Підтвердити</button>
                </div>
                </div>
            </form>
            @else
                <form action="{{route('addOrderSubmit')}}" method="POST">
                    @csrf
                    <div class="container">
                        <input type="number" name="check" hidden value="1">
                        <div class="form-group">
                            <label for="pib">ПІБ</label>
                            <input type="text" class="form-control" name="pib" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Вік</label>
                            <input type="text" class="form-control" name="age" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Номер телефону</label>
                            <input type="text" class="form-control" name="phone_number" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Адреса</label>
                            <input type="text" class="form-control" name="address" placeholder="" required>
                        </div>
                        <b>Оплата здійснюється накладним платежом!</b>
                    <div class="p-3">
                        <button type="submit" class="btn btn-outline-success">Підтвердити</button>
                    </div>
                    </div>
                </form>
            @endempty
        @endisset
    @else
        <form action="{{route('addOrderSubmit')}}" method="POST">
            @csrf
            <div class="container">
                <input type="number" name="check" hidden value="2">
                <div class="form-group">
                    <label for="pib">ПІБ</label>
                    <input type="text" class="form-control" name="pib" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="age">Вік</label>
                    <input type="text" class="form-control" name="age" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Номер телефону</label>
                    <input type="text" class="form-control" name="phone_number" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="address">Адреса</label>
                    <input type="text" class="form-control" name="address" placeholder="" required>
                </div>
                <b>Оплата здійснюється накладним платежом!</b>
            <div class="p-3">
                <button type="submit" class="btn btn-outline-success">Підтвердити</button>
            </div>
            </div>
        </form>
    @endauth
@endsection
