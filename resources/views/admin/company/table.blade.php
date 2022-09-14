<table class="table table-striped" id="myTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Logo</th>
            <th>Website</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($company as $row)
            <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>
                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                            @if ($row->logo)
                                <img src="{{ asset('uploads/' . $row->logo) }}" alt="Avatar" class="rounded-circle">
                            @else
                                <img src="{{ asset('assets/img/custom/radix-logo.png') }}" alt="Avatar"
                                    class="rounded-circle">
                            @endif
                        </li>
                    </ul>
                </td>
                <td>{{ $row->website }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <form class="dropdown-item" action="{{ route('company.edit', $row->id) }}" method="post">
                                @csrf
                                @method('GET')

                                <button class="btn btn-primary btn-sm" data-name="{{ $row->name }}"
                                    type="submit">Edit</button>
                            </form>
                            <form class="dropdown-item" action="{{ route('company.destroy',$row->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm delete-confirm" data-name="{{ $row->name }}"
                                    type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
