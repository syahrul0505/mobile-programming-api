
    <hr class="custom-hr">
    <table class="table table-striped table-hover mb-0" id="departementTable">
        <thead>
            <tr>
                <th class="th-sm">No</th>
                <th class="th-sm">Permission</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($departement->permissions as $permission)
            <tr class="custom-tr">
                <td class="">{{ $loop->iteration }}</td>
                <td class="">{{ $permission->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
