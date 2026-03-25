<h2>Pagos Daviplata</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Referencia</th>
        <th>Monto</th>
        <th>Estado</th>
        <th>Comprobante</th>
        <th>Acción</th>
    </tr>

    @foreach($payments as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->reference }}</td>
            <td>${{ number_format($p->amount) }}</td>
            <td>{{ $p->status }}</td>
            <td>
                @if($p->receipt)
                    <a href="{{ asset('storage/'.$p->receipt) }}" target="_blank">Ver</a>
                @else
                    Sin comprobante
                @endif
            </td>
            <td>
                <form method="POST" action="{{ route('admin.pagos.aprobar', $p->id) }}">
                    @csrf
                    <button>Aprobar</button>
                </form>

                <form method="POST" action="{{ route('admin.pagos.rechazar', $p->id) }}">
                    @csrf
                    <button>Rechazar</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

{{ $payments->links() }}
