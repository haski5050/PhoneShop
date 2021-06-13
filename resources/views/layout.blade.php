<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('name')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<header class="p-3 bg-dark text-white noprint">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{route('homePage')}}" class="nav-link px-2 text-white">Головна</a></li>
                <li><a href="{{route('accessoriesPage')}}" class="nav-link px-2 text-white">Аксесуари</a></li>
                <li><a href="{{route('favoritePage')}}" class="nav-link px-2 text-white">Вподобане</a></li>
                <li><a href="{{route('basketPage')}}" class="nav-link px-2 text-white">Кошик</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="{{route('searchResultPage')}}" method="post">
                @csrf
                <input type="search" name="search" class="form-control form-control-dark" placeholder="Пошук..." aria-label="Search" required>
            </form>

            @auth('admin')
            <div class="text-end">
                <a href="{{route('adminIndex')}}" class="btn btn-outline-warning">Admin</a>
                <a href="{{route('adminLogout')}}" class="btn btn-danger">Вихід</a>
            </div>
            @else
                @auth('web')
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                        <li><a class="dropdown-item" href="{{route('aboutUserPage')}}">Особистий кабінет</a></li>
                        <li><a class="dropdown-item" href="{{route('getOrdersPage')}}">Мої замовлення</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Вихід</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                @else
                <div class="text-end">
                    <a href="{{route('login')}}" class="btn btn-outline-light me-2">Вхід</a>
                    <a href="{{route('register')}}" class="btn btn-warning">Реєстрація</a>
                </div>
                @endauth
            @endauth
        </div>
    </div>
</header>
@yield('content')
</body>
</html>
