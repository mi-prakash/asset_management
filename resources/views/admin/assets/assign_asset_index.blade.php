@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>Assign Assets to employee</h4>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Assigned Assets</th>
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
                            <td>
                                @if (count($user->assets) > 0)
                                    @foreach ($user->assets as $asset)
                                        <span class="badge bg-primary">{{ $asset->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-danger">None</span>
                                @endif
                            <td>
                                <a href="{{ url('admin/assign_assets/'.$user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Assign</a>
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
                $.ajax({
                    url: base_url+"/admin/assets/destroy/"+id,
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
