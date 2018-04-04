<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function __construct()
    {

    }

    public function move(Request $request)
    {   
        $board = $request->session()->get('board');

        $returnArr = ['board' => $board,
                              'winner'=> '',
                              'over'  => ''];

        if (!$board) {
            $board = [
                ['','',''],
                ['','',''],
                ['','','']
            ];
        } 

        $sel = $request->input('select');
        $selArr = explode('-', $sel);
        $board[$selArr[0]][$selArr[1]] = 'X';
        
        $won = $this->checkWin('X', $board);
       
        if ($won) {
            $winner = 'X';
            $request->session()->put('board', $board);
            
            $returnArr['board'] = $board;
            $returnArr['winner'] = $winner;
            return $returnArr;
        }
       
        $over = $this->gameOver($board);
        if ($over) {
            $request->session()->put('board', $board);

            $returnArr['board'] = $board;
            $returnArr['over'] = 1;
            return $returnArr;
        }
        
        $board = $this->cpuPlay(rand(0,2), rand(0,2), $board);
        
        $won = $this->checkWin('O', $board);
        if ($won) {
            $winner = 'O';
            $request->session()->put('board', $board);

            $returnArr['board'] = $board;
            $returnArr['winner'] = $winner;
            return $returnArr;
        }
        
        $over = $this->gameOver($board);
        if ($over) {
            $request->session()->put('board', $board);

            $returnArr['board'] = $board;
            $returnArr['over'] = 1;
            return $returnArr;
        }
       
        $request->session()->put('board', $board);
        $returnArr['board'] = $board;
        return $returnArr;
    }

    private function cpuPlay($num1, $num2, $board) {
        if ($board[$num1][$num2] != '') {
            return $this->cpuPlay(rand(0,2), rand(0,2), $board);
        } else {
            $board[$num1][$num2] = 'O';
            return $board;
        }
    }
    
    private function gameOver($board) {
        $over = true;
        for ($i=0; $i<3;$i++) {
            for ($n=0; $n<3;$n++) {
                if ($board[$i][$n] == '') {
                    $over = false;
                }
            }
        }
    
        return $over;
    }
    
    private function checkWin($player, $board) {
        $win = false;
    
        if ($board[0][0] == $player && $board[0][1] == $player && $board[0][2] == $player) {
            $win = true;
        } else if ($board[1][0] == $player && $board[1][1] == $player && $board[1][2] == $player) {
            $win = true;
        } else if ($board[2][0] == $player && $board[2][1] == $player && $board[2][2] == $player) {
            $win = true;
        } else if ($board[0][0] == $player && $board[1][0] == $player && $board[2][0] == $player) {
            $win = true;
        } else if ($board[0][1] == $player && $board[1][1] == $player && $board[2][1] == $player) {
            $win = true;
        } else if ($board[0][2] == $player && $board[1][2] == $player && $board[2][2] == $player) {
            $win = true;
        } else if ($board[0][0] == $player && $board[1][1] == $player && $board[2][2] == $player) {
            $win = true;
        } else if ($board[0][2] == $player && $board[1][1] == $player && $board[2][0] == $player) {
            $win = true;
        }
    
        return $win;
        
    }

}