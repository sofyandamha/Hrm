<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Allowance Name</b></th>
        <th><b>Allowance Amount</b></th>
        <th><b>Symbol</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->allowance_name }}</td>
            <td>{{ $row->allowance_amount }}</td>
            <td>{{ $row->id_symbol }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
