$(document).ready(function() {
    $('table').on('change', '.toggle-class', function() {
        var isChecked = $(this).prop('checked');
        var elementType = $(this).data('type');
        var elementId = $(this).data('id');
        var url;

        switch (elementType) {
            case 'proveedor':
                url = '/cambioestadoproveedor';
                break;
            case 'producto':
                url = '/cambioestadoproducto';
                break;
            case 'ordencompra':
                url = '/cambioestadoordencompra';
                break;
            case 'metodopago':
                url = '/cambioestadometodopago';
                break;
            case 'pago':
                url = '/cambioestadopago';
                break;
            default:
                return;
        }

        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            data: {
                'estado': isChecked ? 1 : 0,
                'id': elementId
            },
            success: function(data) {
                console.log('Estado cambiado correctamente');
            },
            error: function(xhr, status, error) {
                console.error('Error al cambiar el estado: ' + error);
            }
        });
    });
});