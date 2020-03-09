<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Scan Id</b></th>
        <th><b>Full Name</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->scan_id }}</td>
            <td>{{ $row->full_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
