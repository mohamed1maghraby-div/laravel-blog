@extends('layouts.admin')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">User ({{ $user->name }})</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Users</span>
            </a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <tbody>
            <tr>
                <td colspan="4">
                    @if ($user->user_image != '')
                        <img src="{{ asset('assets/users/' . $user->user_image) }}" class="img-fluid">
                    @endif
                </td>
            </tr>
            <tr>
                <th>Name</th>
                <th>{{ $user->name }} ({{ $user->username }})</th>
                <th>Email</th>
                <th>{{ $user->email }}</th>
            </tr>
            <tr>
                <th>Mobile</th>
                <th>{{ $user->mobile }}</th>
                <th>Status</th>
                <th>{{ $user->status() }}</th>
            </tr>
            <tr>
                <th>Created date</th>
                <th>{{ $user->created_at->format('d-m-Y h:i') }}</th>
                <th>Posts Count</th>
                <th>{{ $user->posts_count }}</th>
            </tr>
        </tbody>
    </table>
</div>
@endsection