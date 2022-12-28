<div class="table-responsive p-0">
    <table class="table table-hover">
        <tr>
            <td style="width:50%">Subtotal:</td>
            <td>{{ $subPrice }} {{ $Factory->curency }} </td>
        </tr>
        @forelse($vatPrice as $key => $value)
        <tr>
            <td>Tax <?= $vatPrice[$key][0] ?> %</td>
            <td colspan="4"><?= $vatPrice[$key][1] ?> {{ $Factory->curency }}</td>
        </tr>
        @empty
        <tr>
            <td>No Tax</td>
            <td> </td>
        </tr>
        @endforelse
        <tr>
            <td>Total:</td>
            <td>{{ $totalPrices }} {{ $Factory->curency }}</td>
        </tr>
    </table>
</div>