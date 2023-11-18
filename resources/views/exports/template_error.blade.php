<html>
<table>
    <thead>
        <tr>
            <th>STT</th>
            @foreach ($columns as $key => $column)
                <th>{{ $column['name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key += 1 }}</td>
                @foreach ($columns as $column)
                    <td>{{ $value[$column['col_name']] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</html>
