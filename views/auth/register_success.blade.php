@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создан новый пользователь</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4 text-md-right">{{ __('Name') }}:</div>

                            <div class="col-md-6">{{ $name }}</div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 text-md-right">Логин:</div>

                            <div class="col-md-6">{{ $login }}</div>
                        </div>

                        <div class="form-group row" >
                            <span class="col-md-4 text-md-right">{{ __('Password') }}:</span>
                            <span class="col-md-6">{{ $password }}</span>
                        </div>


					<div class="form-group row">
					<div class="col-md-4 text-md-right">Роли:</div>
                        <div class="col-md-6" >				
                         @FOREACH  ($roles as $role)	  
                           {{ $role->role }}<BR>
	                     @endforeach  
                    </div>
	                </div>

                
                        <div class="form-group row" >
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
