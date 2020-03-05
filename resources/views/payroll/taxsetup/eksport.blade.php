<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Tax Rule</b></th>
        <th><b>Tax Rate</b></th>
        <th><b>Symbol</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->tax_rule }}</td>
            <td>{{ $row->tax_rate }}</td>
            <td>{{ $row->id_symbol }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
