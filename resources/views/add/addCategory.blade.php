@extends('layout')
@section('name')
    Додати інформацію про категорію
@endsection
@section('content')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <div class="container">
        <div class="card">
            <div class="card-body">
                @isset($categories)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Назва</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category )
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td>{{$category->name}}</td>
                        <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal" data-whatever="{{$category->id}}/{{$category->name}}">Редагувати</button></td>
                        <td>
                        <form action="{{route('deleteCategorySubmit')}}" method="POST">
                        @csrf
                            <div class="form-group m-0 p-0" hidden>
                                <input type="text" class="form-control" name="id" id="id" value="{{$category->id}}">
                            </div>
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Категорії відсутні</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Редагування категорії</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('updateCategorySubmit')}}" method="POST">
                                        @csrf
                                        <div class="form-group m-0 p-0" hidden>
                                            <input type="text" class="form-control" name="id" id="id">
                                        </div>
                                        <div class="form-group m-0 p-0">
                                            <label for="name" class="col-form-label">Назва</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Введіть назву" required="">
                                        </div>
                                        <div style="text-align:center;">
                                            <input type="submit" value="Оновити" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $('#editModal').on('show.bs.modal', function (event) {
                                        var button = $(event.relatedTarget) ;
                                        var data = button.data('whatever').split('/');
                                        var id = data[0];
                                        var name = data[1];
                                        var modal = $(this);
                                        modal.find('.modal-body #id').val(id);
                                        modal.find('.modal-body #name').val(name);
                                        modal.find('.modal-body #editModalLabel').val('Редагування '+name);
                                    });
                                });
                            </script>
                @endisset
            </div>
        </div>
        <form action="{{route('addCategorySubmit')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="CategoryName">Категорія</label>
                <input type="text" class="form-control" name="name" placeholder="" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Додати</button>
        </form>
    </div>
@endsection
