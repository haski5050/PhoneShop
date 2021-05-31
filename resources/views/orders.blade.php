@extends('layout')
@section('name')
    Замовлення
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <div class="accordion" id="accordionExample">
        @isset($buyers)
            @foreach($buyers as $b)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne{{$b->id}}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $b->pib }}
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne{{$b->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Товар</th>
                                    <th scope="col">Ціна</th>
                                    <th scope="col">Дата</th>
                                    <th scope="col">Підтверджено</th>
                                    <th scope="col">Відправлено</th>
                                    <th scope="col">Доставлено</th>
                                </tr>
                                </thead>
                                @isset($orders[$b->id])
                                    <tbody>
                                    @foreach($orders[$b->id] as $o)
                                        <tr>
                                            <th scope="row">{{ $o->pid }}</th>
                                            <td>{{$o->type}}</td>
                                            <td>{{ $o->name }}</td>
                                            <td>{{$o->total}}</td>
                                            <td>{{$o->add_at}}</td>
                                            <form method="post" action="{{route('ordersUpdateSubmit',$o->pid)}}">
                                                @csrf
                                                <td>
                                                    @if($o->submit)
                                                        <input type="checkbox" name="submit" checked>
                                                    @else
                                                        <input type="checkbox" name="submit">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($o->send)
                                                        <input type="checkbox" name="send" checked>
                                                    @else
                                                        <input type="checkbox" name="send">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($o->delivered)
                                                        <input type="checkbox" name="delivered" checked>
                                                    @else
                                                        <input type="checkbox" name="delivered">
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn-primary">Оновити</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    <h2>Даних нема</h2>
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    @endisset
@endsection
