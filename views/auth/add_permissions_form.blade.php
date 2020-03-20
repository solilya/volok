@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создать новое разрешение</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('/auth/add_permissions') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="permission" class="col-md-4 col-form-label text-md-right">Новое разрешение</label>

                            <div class="col-md-6">
                                <input id="permission" type="text" class="form-control @error('permission') is-invalid @enderror" name="permission" value="{{ old('permission') }}" required autocomplete="permission" autofocus>    
                                  @error('permission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                      
	                        </div>
	                   </div>
						
                  	
						<div class="form-group row">
                            <label for="kod" class="col-md-4 col-form-label text-md-right">Код разрешения</label>

                            <div class="col-md-6">
                                <input id="kod" type="text" class="form-control @error('kod') is-invalid @enderror" name="kod" value="{{ old('kod') }}" required autocomplete="kod" autofocus>    
                                  @error('kod')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                      
	                        </div>
	                   </div>
	
	
                
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
