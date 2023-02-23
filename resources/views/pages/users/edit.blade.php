@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="edit_user_form">

                            	@csrf
                            	@method('PUT')

                                <div class="row">

                                	<input type="hidden" id="user_id" name="id" value="{{ $user->id }}">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="Name" name="name" value="{{ $user->name }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">email</label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="Email" name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="role_id">User Role</label>
                                            <select name="role_id" class="form-control">

                                            	@foreach($roles as $role)
                                            		@if($role->id == $user->role?->id)
                                            			<option value="{{ $role->id }}" selected>{{ ucwords($role->name) }}</option>
                                            		@else
                                            			<option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                            		@endif
                                            	@endforeach	                                            
                                            </select>

                                        </div>
                                    </div>

                                    <div id="password_container"></div>

				                    <div class="form-group">
				                         <label><input type="checkbox" name="with_password" class="change_password"> Ubah User Password </label>
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

		const someCheckbox = document.querySelector('.change_password');

		someCheckbox.addEventListener('change', e => {
		  if(e.target.checked === true) {
		    console.log("Checkbox is checked - boolean value: ", e.target.checked)

		    showPasswordInput();
		  }
		if(e.target.checked === false) {
		    console.log("Checkbox is not checked - boolean value: ", e.target.checked)

		    removePasswordInput()
		  }
		});
			 

	 function showPasswordInput(){
	 	document.querySelector('#password_container').innerHTML = `
	 		<div class="col-12">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" class="form-control"
                        placeholder="Password" name="password">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="password_confirmation">New Password Confirmation</label>
                    <input type="password" id="password_confirmation" class="form-control"
                        placeholder="Password Confirmation" name="password_confirmation">
                </div>
            </div>
	 	`;
	 }

	 function removePasswordInput(){
	 	document.querySelector('#password_container').innerHTML = '';
	 }

	 const form = document.querySelector('#edit_user_form');

	 form.addEventListener('submit', async function(e){

	 	e.preventDefault();

	 	const id = document.querySelector('#user_id').value;

	 	try{

	 		const response = await fetch(`{{ route('users.update') }}/${id}`, {
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
                  
            } else if(data.code == 500){

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