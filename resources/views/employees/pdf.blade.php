<!DOCTYPE html>
<html>
<head><title>Employee PDF</title><style>table { width: 100%; border-collapse: collapse; } td, th { border: 1px solid #ccc; padding: 6px; }</style></head>
<body>
    <h2>Employees List</h2>
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Department</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($employees as $emp)
            <tr>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->department->name ?? '' }}</td>
                <td>{{ $emp->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>