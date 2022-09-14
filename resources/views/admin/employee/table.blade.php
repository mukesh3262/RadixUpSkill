<table class="table table-striped" id="myTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($employee as $row)
            <tr>
                <td>{{ $row->first_name." ".$row->last_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->company->website }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <form class="dropdown-item" action="{{ route('emp.edit', $row->id) }}" method="post">
                                @csrf
                                @method('GET')

                                <button class="btn btn-primary btn-sm" data-name="{{ $row->id }}"
                                    type="submit">Edit</button>
                            </form>
                            <form class="dropdown-item" action="{{ route('emp.destroy',$row->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm delete-confirm" data-name="{{ $row->id }}"
                                    type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
