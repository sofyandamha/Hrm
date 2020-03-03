<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Department Name</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
