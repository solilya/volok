@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создать новую роль</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('/auth/add_role') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="permission" class="col-md-4 col-form-label text-md-right">Новая роль</label>

                            <div class="col-md-6">
                                <input id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required autocomplete="role" autofocus>    
                                  @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                      
                            
	                        </div>
	                   </div>
						
						<div class="form-group row">
                         @FOREACH  ($permissions as $permission)	  
                           <div class="col-md-5 text-md-right" >
                           {{ $permission->permission }}
                            </div>
                            
	                        <div class="col-md-6 "><input type="checkbox" value="{{ $permission->id }}" name="permission[]" >
	                        </div>
	                       @endforeach
						 </div>
						 
	                       @error('permission')
	                       <div class="form-group row">
                           <div class="col-md-8 offset-1" >
                                            <strong>Выберите хотя бы одно разрешение для роли</strong>
    
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
