@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des utilisateurs</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="form-select" onchange="this.form.submit()">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Éditeur</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                    </form>
                </td>
                <td>
                    <!-- Actions supplémentaires -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection