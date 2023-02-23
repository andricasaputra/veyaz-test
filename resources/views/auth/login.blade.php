<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <meta  name="csrf-token" content="{{ csrf_token() }}" >
    
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">

    <script>
        const token = localStorage.getItem('token');

        if(token){
            window.location = '{{ route('users.home') }}'
        }
    </script>

    @stack('link')


</head>
<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            {{-- <div class="auth-logo">
                <a href="index.html"><img src="assets/images/logo/logo.svg" alt="Logo"></a>
            </div> --}}
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

            <div id="error_container"></div>

            <form method="POST" id="loginForm">
                {{ csrf_field() }}
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="email" type="text" name="email" value="" class="form-control form-control-xl" placeholder="email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @if($errors->has('email'))
                        <div style="color: red;" class="error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="password" type="password" name="password" value="" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @if($errors->has('password'))
                    <div style="color: red;" class="error">{{ $errors->first('password') }}</div>
                @endif
                </div>
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Keep me logged in
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>

    <div class="container">

       
    </div>

<script src="{{ asset('assets/js/bootstrap.js') }}"></script>

<script>
	const loginForm = document.querySelector('#loginForm');

	loginForm.addEventListener('submit', function(e){
		e.preventDefault();

		login();
	});


	async function login(){

		const email = document.querySelector('#email').value;
		const password = document.querySelector('#password').value;

		try{

			const response =  await fetch('{{ route('api.login') }}', {
			  method: 'POST',
			  headers:{
				'Accept' : 'application/json',
				'Content-Type' : 'application/json'
			  },
			  body: JSON.stringify({ email, password })
			});

			const data = await response.json();

			if(data.code == 200){

				localStorage.setItem('token', data.token);

				window.location = '{{ route('users.home') }}'
			} else {
                document.getElementById('error_container').innerHTML = `
                    <div class="alert alert-danger">${data.message}</div>
                `;
            }

		}catch(err){
			console.log(err);

            document.getElementById('error_container').innerHTML = `
                <div class="alert alert-danger">${err.message}</div>
            `;
		}

	}
</script>

@if(session()->has('error'))
    <script>
        Swal.fire({
            title: "{{ session()->get('error') }}",
            text: "Wrong Email or password!",
            icon: "error",
        })
    </script>
@endif

@stack('script')

</body>
</html>
