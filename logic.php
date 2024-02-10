<?php

//initialize the game board
function initialize_board()
{
    return array_fill(0, 3, array_fill(0, 3, null));
}

//check if the current player wins
function check_winner($board, $player)
{
    // Check rows and columns
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] == $player && $board[$i][1] == $player && $board[$i][2] == $player) {
            return true;
        }
        if ($board[0][$i] == $player && $board[1][$i] == $player && $board[2][$i] == $player) {
            return true;
        }
    }
    // Check diagonals
    if ($board[0][0] == $player && $board[1][1] == $player && $board[2][2] == $player) {
        return true;
    }
    if ($board[0][2] == $player && $board[1][1] == $player && $board[2][0] == $player) {
        return true;
    }
    return false;
}

//check if the game is a draw
function check_draw($board)
{
    foreach ($board as $row) {
        foreach ($row as $cell) {
            if ($cell == null) {
                return false;
            }
        }
    }
    return true;
}

//make a move for the computer
function computer_move($board)
{
    //choose a random empty cell
    do {
        $row = rand(0, 2);
        $col = rand(0, 2);
    } while ($board[$row][$col] !== null);
    return array($row, $col);
}

// Main game logic
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
} else {
    $mode = '';
}

if (isset($_GET['reset'])) {
    unset($_SESSION['board']);
    unset($_SESSION['current_player']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Initialize the current player if not set
if (!isset($_SESSION['current_player'])) {
    $_SESSION['current_player'] = 'X';
}

if (isset($_GET['move']) && isset($_GET['row']) && isset($_GET['col'])) {
    $row = intval($_GET['row']);
    $col = intval($_GET['col']);

    // Ensure the cell is empty and within bounds
    if ($_SESSION['board'][$row][$col] === null && $row >= 0 && $row < 3 && $col >= 0 && $col < 3) {
        $_SESSION['board'][$row][$col] = $_SESSION['current_player'];
        if (check_winner($_SESSION['board'], $_SESSION['current_player'])) {
            echo $_SESSION['current_player'] . ' wins!';
            unset($_SESSION['board']);
            unset($_SESSION['current_player']);
        } elseif (check_draw($_SESSION['board'])) {
            echo 'It\'s a draw!';
            unset($_SESSION['board']);
            unset($_SESSION['current_player']);
        } else {
            $_SESSION['current_player'] = ($_SESSION['current_player'] == 'X') ? 'O' : 'X';
            // If in computer mode and it's computer's turn
            if ($mode == 'computer' && $_SESSION['current_player'] == 'O') {
                $move = computer_move($_SESSION['board']);
                $_SESSION['board'][$move[0]][$move[1]] = 'O';
                if (check_winner($_SESSION['board'], 'O')) {
                    echo 'Computer wins!';
                    unset($_SESSION['board']);
                    unset($_SESSION['current_player']);
                } elseif (check_draw($_SESSION['board'])) {
                    echo 'It\'s a draw!';
                    unset($_SESSION['board']);
                    unset($_SESSION['current_player']);
                } else {
                    $_SESSION['current_player'] = 'X';
                }
            }
        }
    }
}