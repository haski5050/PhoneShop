@extends('layout')
@section('name')
    Відгуки
@endsection
@section('content')
    @empty(!$feedback)
        <div class="container p-4">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Оцінка</th>
                <th scope="col">Текст</th>
                <th scope="col">Час публікації</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($feedback as $el)
            <tr>
                <th scope="row">{{$el->id}}</th>
                <td>{{$el->rating}}</td>
                <td>{{$el->message}}</td>
                <td>{{$el->send_at}}</td>
                <td><a href="{{route('deleteFeedbackSubmit',[$el->id])}}" class="btn btn-danger">Відхилити</a></td>
                <td><a href="{{route('updateFeedbackSubmit',[$el->id])}}" class="btn btn-success">Підтвердити</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    @else
        <div class="text-center p-4">
            <h3>Немає що перевіряти</h3>
        </div>
    @endempty
@endsection
