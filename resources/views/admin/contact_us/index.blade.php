@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Contact us</h6>
        </div>
        @include('admin.contact_us.filter.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td><a href="{{ route('admin.contact_us.show', $message->id) }}">{{ $message->name }}</a></td>
                            <td>{{ $message->title }}</td>
                            <td>{{ $message->status() }}</td>
                            <td>{{ $message->created_at->format('d-m-Y h:i a') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this message?')){document.getElementById('message-delete-{{ $message->id }}').submit();}else{return false;}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('admin.contact_us.destroy', $message->id) }}" method="POST" id="message-delete-{{ $message->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="float-right">
                                {!! $messages->appends(request()->input())->links() !!}
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection