@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>Assets</h4>
            <form method="GET" action="{{ url('admin/assigned_assets') }}">
                <div class="row">
                    <div class="col-3">
                        <label for="search_by" class="form-label">Search by</label>
                        <select class="form-select" name="search_by" id="search_by">
                            <option value="allocated" @if ($search_by == "allocated") selected @endif>Allocated</option>
                            <option value="allocated_5" @if ($search_by == "allocated_5") selected @endif>Allocated within 5 days</option>
                            <option value="remaining" @if ($search_by == "remaining") selected @endif>Remaining</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" name="department_id" id="department_id">
                            <option value="">Select any</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if ($department_id == $department->id) selected @endif>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2 mb-3">
                    <button class="btn btn-primary "><i class="fa fa-search"></i> Search</button>
                </div>
            </form>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Asset ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col">Department</th>
                        <th scope="col">Assigned at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr>
                            <th scope="row">{{ $asset->id }}</th>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->category }}</td>
                            <td>
                                @if (isset($asset->user))
                                    {{ $asset->user->name }}
                                @else
                                    {{ "None" }}
                                @endif
                            </td>
                            <td>
                                @if (isset($asset->user))
                                    {{ $asset->user->department->name }}
                                @else
                                    {{ "None" }}
                                @endif
                            </td>
                            <td>{{ date("d/m/Y h:i A", strtotime($asset->assigned_time)) }}</td>
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
