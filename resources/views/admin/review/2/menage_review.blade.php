@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Id')</th>
                                <th>@lang('fullname')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Rating')</th>
                                <th>@lang('Status')</th>
                                <th class="d-flex justify-content-center">@lang('Action')</th>


                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        {{ $review->id }}
                                    </td>
                                    <td>
                                        {{ $review->user->fullname }}
                                    </td>
                                    <td>
                                        {{ ($review->description) }}
                                    </td>
                                    <td>
                                        {{ ($review->rating) }}
                                    </td>
                                    <td>
                                        {{ $review->approved == 1  ? 'approved' : 'pending' }}

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end ">
                                            <form action="{{ route('approve.review', ['id' => $review->id]) }}" method="POST" class=" me-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn--primary">Approve</button>
                                            </form>
                                            <form action="{{ route('destroy.review', ['id' => $review->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn--danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>




                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if ($currencies->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($currencies) }}
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

