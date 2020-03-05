<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Deduction Name</b></th>
        <th><b>Deduction Amount</b></th>
        <th><b>Symbol</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->deduction_name }}</td>
            <td>{{ $row->deduction_amount }}</td>
            <td>{{ $row->id_symbol }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
