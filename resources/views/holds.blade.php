<hr>

<table>
    <tr>
        <th>#</th>
        <th>User Id</th>
        <th>Amount</th>
        <th>State</th>
        <td>Approving</td>
        <td>Declining</td>
    </tr>
    @foreach ($holds as $hold)
        <tr>
            <td>#{{ $hold->id }}</td>
            <td>{{ $hold->users_id }}</td>
            <td>{{ $hold->amount }} EUR</td>
            <td>
                @switch($hold->state)
                @case(0)
                Registered
                @break
                @case(1)
                Approved
                @break
                @case(2)
                Declined
                @break
                @endswitch
            </td>
            <td>
                @if ($hold->state == 0)
                    <form action="/operation/hold" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="operation" id="operation" value="approve" />
                        <input type="hidden" name="hold_id" id="hold_id" value="{{ $hold->id }}" />
                        <input type="hidden" name="u_id" id="u_id" value="{{ $hold->users_id }}" />
                        <input type="submit" value="Approve" />
                    </form>
                @endif
            </td>
            <td>
                @if ($hold->state == 0)
                    <form action="/operation/hold" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="operation" id="operation" value="decline" />
                        <input type="hidden" name="hold_id" id="hold_id" value="{{ $hold->id }}" />
                        <input type="hidden" name="u_id" id="u_id" value="{{ $hold->users_id }}" />
                        <input type="submit" value="Decline" />
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
</table>