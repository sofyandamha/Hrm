<table>
    <thead>
    <tr>
        <th><b>Nomor</b></th>
        <th><b>Working Time Name</b></th>
        <th><b>In Time</b></th>
        <th><b>Out Time</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->workingTime_name }}</td>
            <td>{{ $row->in_time }}</td>
            <td>{{ $row->out_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
