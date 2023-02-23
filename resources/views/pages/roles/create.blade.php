@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Role</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="create_role_form">

                            	@csrf

                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="Name" name="name">
                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="{{ route('roles.home') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
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

	 const form = document.querySelector('#create_role_form');

	 form.addEventListener('submit', async function(e){

	 	e.preventDefault();

	 	try{

	 		const response = await fetch(`{{ route('roles.store') }}`, {
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
                    window.location = '{{ route('roles.home') }}'
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