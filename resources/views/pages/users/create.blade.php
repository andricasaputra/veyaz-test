@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="create_user_form">

                            	@csrf

                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="Name" name="name">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">email</label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="Email" name="email">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="role_id">User Role</label>
                                            <select name="role_id" class="form-control">

                                            	@foreach($roles as $role)
                                            		<option value="{{ $role->id }}" selected>{{ ucwords($role->name) }}</option>
                                            	@endforeach	                                            
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" class="form-control"
                                                placeholder="Password" name="password">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Password Confirmation</label>
                                            <input type="password" id="password_confirmation" class="form-control"
                                                placeholder="Password Confirmation" name="password_confirmation">
                                        </div>
                                    </div>


                                    
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="{{ route('users.home') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

<script>

	 const form = document.querySelector('#create_user_form');

	 form.addEventListener('submit', async function(e){

	 	e.preventDefault();

	 	try{

	 		const response = await fetch(`{{ route('users.store') }}`, {
		 		method: 'POST',
		 		headers: {
		 			'Authorization' : `Bearer ${localStorage.getItem('token')}`,
		 			'Accept' : 'application/json'
		 		},
		 		body: new FormData(form)
	 		});

	 		const data = await response.json();

	 		if(data.code == 201){

                Swal.fire({
                    title: 'Success !',
                    text: data.message,
                    icon: 'success',
                  }).then(function(){
                    window.location = '{{ route('users.home') }}'
                });
                  
            } else {

            	Swal.fire({
	              title: 'Error !',
	              text: data.message,
	              icon: 'error',
	            });

            }

	 	}catch(err){

	 		console.log(err);

	 		Swal.fire({
              title: 'Error !',
              text: err.message,
              icon: 'error',
            });
	 	}
	 });

</script>

@endpush