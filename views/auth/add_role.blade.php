@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создана новая роль</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                       <div class="form-group row">
                            <div class="col-md-4 text-md-right">Новая роль:</div>
                            <div class="col-md-6">{{ $role->role }}</div>
                        </div>

					<div class="form-group row">
					<div class="col-md-4 text-md-right">Разрешения:</div>
                        <div class="col-md-6" >				
                         @FOREACH  ($role->permissions as $permission)	  
                           {{ $permission->permission }}<BR>
	                       @endforeach  
                   </div>
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
