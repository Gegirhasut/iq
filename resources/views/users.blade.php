<hr>

<form action="/operation" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="operation" id="operation" value="transfer" />
    From: <input type="text" name="u_id" id="u_id" value="" placeholder="user_id" />
    To: <input type="text" name="to_user" id="to_user" value="" placeholder="user_id" />
    How much? <input type="text" name="amount" id="amount" size="5" />
    <input type="submit" value="Transfer" />
</form>

<hr>

<table>
    <tr>
        <th>#</th>
        <th>User</th>
        <th>Balans</th>
        <th>Add</th>
        <th>Minus</th>
        <th>Hold</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>
                #{{ $user->id }}
            </td>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->amount }} EUR
            </td>
            <td>
                <form action="/operation" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="operation" id="operation" value="add" />
                    <input type="hidden" name="u_id" id="u_id" value="{{ $user->id }}" />
                    <input type="text" name="amount" id="amount" size="5" />
                    <input type="submit" value="Add" />
                </form>
            </td>
            <td>
                <form action="/operation" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="operation" id="operation" value="minus" />
                    <input type="hidden" name="u_id" id="u_id" value="{{ $user->id }}" />
                    <input type="text" name="amount" id="amount" size="5" />
                    <input type="submit" value="Minus" />
                </form>
            </td>
            <td>
                <form action="/operation" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="operation" id="operation" value="hold" />
                    <input type="hidden" name="u_id" id="u_id" value="{{ $user->id }}" />
                    <input type="text" name="amount" id="amount" size="5" />
                    <input type="submit" value="Hold" />
                </form>
            </td>
        </tr>
    @endforeach
</table>