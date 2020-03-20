@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создано новое разрешение</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                       <div class="form-group row">
                            <div class="col-md-4 text-md-right">Новое разрешение:</div>
                            <div class="col-md-6">{{ $permission }}</div>
                        </div>


                       <div class="form-group row">
                            <div class="col-md-4 text-md-right">Код:</div>
                            <div class="col-md-6">{{ $kod }}</div>
                        </div>

                		
                        <div class="form-group row">
                       <div class="col-md-3 offset-3">
                                                      
                                     <button type="button" class="btn btn-primary" onclick="javascript:window.location.href = '{{ route('/auth/print_menu') }}';">
                                    Управление пользователями
                                </button>
                           
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
