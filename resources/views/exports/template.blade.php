<html>
<style>
    td {
        background-color: #000000;
    }
</style>
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
        @foreach ($data_export as $key => $data)
            <tr>
                <td>{{ $key += 1 }}</td>
                @foreach ($columns as $column)
                    <td>{{ $data[$column['col_name']] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</html>
