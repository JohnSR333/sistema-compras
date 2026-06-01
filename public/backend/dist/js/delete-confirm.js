$(document).ready(function() {
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: '¿Está seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.get(0).submit();
            }
        });
    });
});