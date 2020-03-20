@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Управление пользователями &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{{ Auth::user()->name }}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('logout') }}">Выход</div>

                <div class="card-body">
              

                        <div class="form-group row">
                            <div class="col-md-5 text-md-left offset-md-1">
<a href="{{ route('/auth/create_form') }}">Создать пользователя</a>
<br><a href="{{ route('/auth/add_permissions_form') }}">Создать разрешение</a>
<br><a href="{{ route('/auth/add_role_form') }}">Создать роль</a>
<br><a href="users.php?action=del_partner_form">Удалить партнеров</a>
<br><a href="users.php?action=view">Отобразить партнеров и их ЧОПы</a>

                           </div>

                           
                        </div>

          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
