@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="h4 mb-4">Usuarios</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Editor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Sí' : 'No' }}</td>
                    <td>{{ $user->is_editor ? 'Sí' : 'No' }}</td>
                    <td>
                        @if(auth()->user()->id !== $user->id)
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.users.toggleEditor', $user) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary">{{ $user->is_editor ? 'Revocar editor' : 'Hacer editor' }}</button>
                                </form>

                                <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST" id="admin-form-{{ $user->id }}" style="display:inline-block">
                                    @csrf
                                    <button type="button" class="btn btn-sm {{ $user->is_admin ? 'btn-outline-danger' : 'btn-outline-success' }}" onclick="showAdminConfirmModal({{ $user->id }}, '{{ addslashes($user->name) }}', {{ $user->is_admin ? 'true' : 'false' }})">
                                        {{ $user->is_admin ? 'Revocar admin' : 'Hacer admin' }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-muted">(tu cuenta)</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<!-- Modal for admin confirm -->
<div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="admin-confirm-message"></p>
                <div id="admin-countdown" class="text-muted small">Esperando...</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="admin-cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="admin-confirm-btn" class="btn btn-primary" style="display:none">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
var adminModalEl = document.getElementById('adminConfirmModal');
var adminModal = (typeof bootstrap !== 'undefined' && adminModalEl) ? new bootstrap.Modal(adminModalEl) : null;
var adminCountdownInterval = null;

function showAdminConfirmModal(userId, userName, isCurrentlyAdmin) {
    // If bootstrap modal isn't available, use a fallback overlay
    if (!adminModal) {
        return showAdminConfirmFallback(userId, userName, isCurrentlyAdmin);
    }

    var message = isCurrentlyAdmin
        ? '¿Estás seguro que quieres revocar admin a ' + userName + '?'
        : '¿Estás seguro que quieres darle admin a ' + userName + '?';

    document.getElementById('admin-confirm-message').innerText = message;
    document.getElementById('admin-countdown').innerText = 'Esperando 3s...';
    var confirmBtn = document.getElementById('admin-confirm-btn');
    confirmBtn.style.display = 'none';

    // set confirm action
    confirmBtn.onclick = function() {
        document.getElementById('admin-form-' + userId).submit();
        adminModal.hide();
        clearInterval(adminCountdownInterval);
    };

    adminModal.show();

    // countdown
    var seconds = 3;
    adminCountdownInterval = setInterval(function() {
        seconds -= 1;
        if (seconds > 0) {
            document.getElementById('admin-countdown').innerText = 'Esperando ' + seconds + 's...';
        } else {
            clearInterval(adminCountdownInterval);
            document.getElementById('admin-countdown').innerText = '';
            confirmBtn.style.display = 'inline-block';
        }
    }, 1000);

    // cancel handler
    document.getElementById('admin-cancel-btn').onclick = function() {
        clearInterval(adminCountdownInterval);
        adminModal.hide();
    };
}

function showAdminConfirmFallback(userId, userName, isCurrentlyAdmin) {
    // create overlay
    var overlay = document.createElement('div');
    overlay.id = 'admin-fallback-overlay-' + userId;
    overlay.style.position = 'fixed';
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.background = 'rgba(0,0,0,0.5)';
    overlay.style.display = 'flex';
    overlay.style.alignItems = 'center';
    overlay.style.justifyContent = 'center';
    overlay.style.zIndex = 1050;

    var box = document.createElement('div');
    box.style.background = '#fff';
    box.style.padding = '20px';
    box.style.borderRadius = '8px';
    box.style.maxWidth = '480px';
    box.style.width = '90%';
    box.style.boxShadow = '0 10px 30px rgba(0,0,0,0.2)';

    var message = isCurrentlyAdmin
    ? '¿Estás seguro que quieres revocar admin a ' + userName + '?'
    : '¿Estás seguro que quieres darle admin a ' + userName + '?';

    var p = document.createElement('p');
    p.innerText = message;
    box.appendChild(p);

    var countdown = document.createElement('div');
    countdown.className = 'text-muted small';
    countdown.innerText = 'Esperando 3s...';
    box.appendChild(countdown);

    var btnConfirm = document.createElement('button');
    btnConfirm.className = 'btn btn-primary';
    btnConfirm.style.display = 'none';
    btnConfirm.innerText = 'Confirmar';
    btnConfirm.onclick = function() {
    document.getElementById('admin-form-' + userId).submit();
    document.body.removeChild(overlay);
    };

    var btnCancel = document.createElement('button');
    btnCancel.className = 'btn btn-secondary ms-2';
    btnCancel.innerText = 'Cancelar';
    btnCancel.onclick = function() {
    clearInterval(interval);
    if (document.body.contains(overlay)) document.body.removeChild(overlay);
    };

    var footer = document.createElement('div');
    footer.style.marginTop = '12px';
    footer.appendChild(btnConfirm);
    footer.appendChild(btnCancel);
    box.appendChild(footer);

    overlay.appendChild(box);
    document.body.appendChild(overlay);

    var seconds = 3;
    var interval = setInterval(function() {
    seconds -= 1;
    if (seconds > 0) {
        countdown.innerText = 'Esperando ' + seconds + 's...';
    } else {
        clearInterval(interval);
        countdown.innerText = '';
        btnConfirm.style.display = 'inline-block';
    }
    }, 1000);
}
</script>
@endpush
