@extends('layout')
@section('name')
    Мої замовлення
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <div class="container">
        <div class="card">
         <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                    Актуальні замовлення
                </button>
            </h2>
             <div id="collapseOne1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                 <div class="card-body">
                     <table class="table">
                         <thead>
                         <tr>
                             <th scope="col">Тип</th>
                             <th scope="col">Товар</th>
                             <th scope="col">Ціна</th>
                             <th scope="col">Дата</th>
                             <th scope="col">Підтверджено</th>
                             <th scope="col">Відправлено</th>
                             <th scope="col">Доставлено</th>
                         </tr>
                         </thead>
                         @empty(!$actual)
                             <tbody>
                             @foreach($actual as $o)
                                 <tr>
                                     <td>{{$o->type}}</td>
                                     <td>{{ $o->name }}</td>
                                     <td>{{$o->total}}</td>
                                     <td>{{$o->add_at}}</td>
                                         <td>
                                             @if($o->submit)
                                                 <input type="checkbox" name="submit" checked disabled="disabled">
                                             @else
                                                 <input type="checkbox" name="submit" disabled="disabled">
                                             @endif
                                         </td>
                                         <td>
                                             @if($o->send)
                                                 <input type="checkbox" name="send" checked disabled="disabled">
                                             @else
                                                 <input type="checkbox" name="send" disabled="disabled">
                                             @endif
                                         </td>
                                         <td>
                                             @if($o->delivered)
                                                 <input type="checkbox" name="delivered" checked disabled="disabled">
                                             @else
                                                 <input type="checkbox" name="delivered" disabled="disabled">
                                             @endif
                                         </td>
                                 </tr>
                             @endforeach
                             </tbody>
                         @else
                             <h2>Даних нема</h2>
                         @endempty
                     </table>
                 </div>
             </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                        Минулі замовлення
                    </button>
                </h2>
                <div id="collapseOne2" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Тип</th>
                                <th scope="col">Товар</th>
                                <th scope="col">Ціна</th>
                                <th scope="col">Дата</th>
                            </tr>
                            </thead>
                            @empty(!$history)
                                <tbody>
                                @foreach($history as $o)
                                    <tr>
                                        <td>{{$o->type}}</td>
                                        <td>{{ $o->name }}</td>
                                        <td>{{$o->total}}</td>
                                        <td>{{$o->add_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @else
                                <h2>Даних нема</h2>
                            @endempty
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection
