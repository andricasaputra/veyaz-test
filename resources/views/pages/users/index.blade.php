@extends('layouts.app')

@section('title', 'Users')

@section('content')

<section class="section">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User List</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {{-- <p class="card-text">Using the most basic table up, here’s how
                                <code>.table</code>-based tables look in Bootstrap. You can use any example
                                of below table for your table and it can be use with any type of bootstrap tables.
                            </p> --}}
                            <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-lg text-center" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>PASSWORD</th>
                                            <th>ROLE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyData"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')

<script>

    getUsers();

    async function getUsers(){

        try{

            const response = await fetch('{{ route('users.index') }}', {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token'),
                    'Accept' : 'application/json'
                }
            });

            const {data} = await response.json();

           for (var i = 0; i < data.length; i++) {

                let row = "";

                row += `
                    <tr>
                        <td>${data[i].name}</td>
                        <td>${data[i].email}</td>
                        <td>${data[i].password_encrypted || '-'}</td>
                        <td>${data[i].role.name || '-'}</td>
                        <td>
                            <a class="btn btn-danger mb-2 remove-btn" id="remove-btn-id-${data[i].id}" href="#" data-id="${data[i].id}">Delete</a>

                            <a class="btn btn-primary" href="{{ route('users.edit') }}/${data[i].id}">Edit</a>
                        </td>
                    </tr>
                `;

                 let html = document.getElementById("tbodyData").innerHTML + row;

                document.getElementById("tbodyData").innerHTML = html;
                
                let removeBtn = document.querySelectorAll(`.remove-btn`);

                removeBtn.forEach(link => link.addEventListener('click', (e) => {

                    e.preventDefault();

                    const id = e.target.dataset.id;

                    confirmDelete(id);
                }))

                
            }

        }catch(err){

        }
    }

    function confirmDelete(id){

        Swal.fire({

           title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {

          if (result.isConfirmed) {
             deleteRecord(id);
          }
        });
    }

    async function deleteRecord(id){

        try{

            const response =  await fetch('{{ route('users.destroy') }}/' + id, {
              method: 'POST',
              headers:{
                'Authorization' : `Bearer ${localStorage.getItem('token')}`,
                'Accept' : 'application/json',
                'Content-Type' : 'application/json',
                '_method' : 'DELETE'
              },
              body: JSON.stringify({ 
                id, 
                _method : 'DELETE' 
            })
            });

            const data = await response.json();

            if(data.code == 200){

                Swal.fire({
                    title: 'Success !',
                    text: data.message,
                    icon: 'success',
                  }).then(function(){
                    location.reload();
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

    }

</script>

@endpush