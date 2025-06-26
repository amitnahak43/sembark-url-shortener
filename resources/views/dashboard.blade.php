@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Welcome, <strong>{{ $user->name }}</strong> ({{ $user->role }})</h2>

    {{-- SuperAdmin Clients Table --}}
    @if ($user->role === 'SuperAdmin')
        <h4 class="mb-3">Clients</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Total Users</th>
                        <th>Total Generated URLs</th>
                        <th>Total URL Hits</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        @php
                            $users = $company->users;
                            $totalUsers = $users->count();
                            $ClientUrls = $users->flatMap->shortUrls;
                            $totalUrls = $ClientUrls->count();
                            $totalHits = $ClientUrls->sum('hits');
                            $adminEmail = $users->firstWhere(fn($u) => in_array($u->role, ['Admin', 'Member']))->email ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $company->name }}</td>
                            <td>{{ $adminEmail }}</td>
                            <td>{{ $totalUsers }}</td>
                            <td>{{ $totalUrls }}</td>
                            <td>{{ $totalHits }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- URL Generator --}}
    @if (in_array($user->role, ['Admin', 'Member']))
        <h4 class="mt-5">Generate Short URL</h4>
        <form action="{{ route('short.store') }}" method="POST" class="row g-2 mb-4">
            @csrf
            <div class="col-md-8">
                <input type="url" name="original_url" class="form-control" placeholder="Enter URL" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">Generate</button>
            </div>
        </form>
    @endif

    {{-- URL List --}}
    <h4 class="mb-3">Generated Short URLs</h4>
    <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-center mb-3">
        <div class="col-auto">
            <label for="filter" class="col-form-label">Filter:</label>
        </div>
        <div class="col-auto">
            <select name="filter" id="filter" class="form-select">
                <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>View All</option>
                <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>Last Week</option>
                <option value="month" {{ request('filter') === 'month' ? 'selected' : '' }}>This Month</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Apply</button>
            <button type="button" onclick="window.print()" class="btn btn-outline-secondary">Download</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Original URL</th>
                    <th>Short URL</th>
                    <th>Created By</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($urls as $url)
                    <tr>
                        <td>{{ $url->original_url }}</td>
                        <td><a href="{{ url($url->short_code) }}" target="_blank">{{ url($url->short_code) }}</a></td>
                        <td>{{ $url->user->name }}</td>
                        <td>{{ $url->created_at->format('d M ’y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No URLs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Team Members --}}
    @if (in_array($user->role, ['SuperAdmin', 'Admin']))
        <h4 class="mt-5">Your Team Members</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Models\User::where('role', '!=', 'SuperAdmin')->get() as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
