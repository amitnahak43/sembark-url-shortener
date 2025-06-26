@extends('layouts.app')

@section('content')
<h2>Invite a User</h2>

<form action="{{ route('invite.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="User Name" required><br><br>
    <input type="email" name="email" placeholder="User Email" required><br><br>
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="Admin">Admin</option>
        <option value="Member">Member</option>
    </select><br><br>
    <button type="submit">Send Invitation</button>
</form>
@endsection
