@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>My Assigned Assets</h4>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Asset ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Assigned at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr>
                            <th scope="row">{{ $asset->id }}</th>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->category }}</td>
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
    });
</script>
@endsection
