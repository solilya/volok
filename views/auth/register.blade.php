@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создать нового пользователя</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Логин</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login">

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>В поле логин могут быть только латинские буквы и цифры</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


					<div class="form-group row">
                         @FOREACH  ($roles as $role)	  
                           <div class="col-md-4 text-md-right" >
                           {{ $role->role }}
                            </div>
                            
	                        <div class="col-md-6 "><input type="checkbox" value="{{ $role->id }}" name="role[]" >
	                        </div>
	                       @endforeach
						 </div>
						 
	                       @error('role')
	                       <div class="form-group row">
                           <div class="col-md-8 offset-1" >
                                            <strong>Выберите хотя бы одну роль</strong>
    
                             </div>
                          </div>
                          @enderror      

                
                        <div class="form-group row">
                            <div class="col-md-3 offset-2">
                                <button type="submit" class="btn btn-primary" style="max-width: 100%; padding-left:50px; padding-right:100px;">
                                    Cоздать
                                </button>
                               </div>
                               <div class="col-md-3 ">
                                                      
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
