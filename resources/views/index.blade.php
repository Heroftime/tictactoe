<?php 
if (isset($data['board'])) {
    $board = $data['board'];
    $winner = $data['winner'];
    $over = $data['over'];
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Tic Toe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>

<h4>TicToe Game</h4>

@if ($winner)
    <h3>Player {{ $winner }} has won! <a href='{{ url("reset") }}'>Play Again?</a></h3><br>
@elseif ($over)
    Game Over! No body won! <a href='{{ url("reset") }}'>Play Again?</a></h3><br>
@endif

<br>
Player = X <br>
CPU = O

<table border="1" width="600px;" height="400px;">
@for ($i=0; $i<3;$i++)
    <tr>
    @for ($n=0; $n<3;$n++)
            @if (count($board) > 0 && $board[$i][$n] != '')
                <td>{{ $board[$i][$n] }}</td>
            @else
                <?php  $num = "$i-$n"; ?>
               <td>
                @if (!$winner)
                    <a href="{{ url('?select='.$num) }}">Select</a>
                @endif
                </td>
            @endif           
        @endfor
    </tr>
@endfor
</table>

</body>
</html>