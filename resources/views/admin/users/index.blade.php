@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>Employees</h4>
            <a href="{{ url('admin/users/add') }}" class="btn btn-primary my-3"><i class="fa fa-plus"></i> Add New</a>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->department->name }}</td>
                            <td>{{ date("d/m/Y h:i A", strtotime($user->created_at)) }}</td>
                            <td>
                                <a href="{{ url('admin/users/edit/'.$user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $user->id }}"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.table').DataTable();

        $(".delete").click(function(e) {
            var id = $(this).data('id');
            if (confirm('Are you sure?')) {
                console.log('here');
                $.ajax({
                    url: base_url+"/admin/users/destroy/"+id,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                    },
                    success: function(response) {
                        if (response == 'success') {
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
