<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/laby.css">
</head>
<body>
    <header class="game-header">
        <!-- Contenu de l'en-tête ici -->
    </header>
    
    <main class="game-main">
        <div id="game-board" class="game-board">
            <?php 
            session_start();
            $table = [
                [
                    [1,3,3,0,0,0],
                    [0,0,0,3,3,3],
                    [0,3,3,3,0,3],
                    [0,0,0,3,3,0],
                    [0,3,0,0,0,2],
                ],
                [
                    [1,3,3,0,0,0],
                    [3,0,0,3,3,3],
                    [3,3,3,3,0,3],
                    [3,0,0,3,3,0],
                    [3,3,0,3,3,2],
                ],
            ];
            if (!isset ($_SESSION['map'])) {
                $_SESSION['map'] = $table[rand(0, count($table) - 1)];
            }
            $map = $_SESSION['map'];
            if (!isset ($_SESSION['pos'])) {
                $_SESSION['pos'] = [0,0];
            }

            foreach ($map as $i => $line) {
                $catPos = $_SESSION['pos'];
                foreach ($line as $j => $cell) {
                    if (!(($i === $catPos[0] && $j === $catPos[1])
                    ||($i === $catPos[0] + 1 && $j == $catPos[1])
                    ||($i === $catPos[0] - 1 && $j == $catPos[1])
                    ||($i === $catPos[0] && $j == $catPos[1] + 1)
                    ||($i === $catPos[0] && $j == $catPos[1] - 1)
                    )) {
                        $map[$i][$j] = 7;
                    }
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['reset'])) {
                    session_destroy();
                }
                if (isset($_POST['move'])) {
                    $map[0][0] = 0;
                    switch ($_POST['move']) {
                        case 'up': 
                            if ($_SESSION['pos'][0] - 1 >= 0 && $map[$_SESSION['pos'][0] - 1][$_SESSION['pos'][1]] !=  3) {
                                $_SESSION['pos'] = [$_SESSION['pos'][0] - 1, $_SESSION['pos'][1]];
                                if ($map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 2) {
                                    echo "gagné";
                                }
                            }
                            $map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                            break;
                        case 'down':
                            if ($_SESSION['pos'][0] + 1 < count($map) && $map[$_SESSION['pos'][0] + 1][$_SESSION['pos'][1]] !=  3) {
                                $_SESSION['pos'] = [$_SESSION['pos'][0] + 1, $_SESSION['pos'][1]];
                                if ($map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 2) {
                                    echo "gagné";
                                }
                            }
                            $map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                            break;
                        case 'right':
                            if ($_SESSION['pos'][0] + 1 < count($map[$_SESSION['pos'][0]]) && $_SESSION['pos'][1] + 1 <= count($map[$_SESSION['pos'][0]]) - 1 && $map[$_SESSION['pos'][0]][$_SESSION['pos'][1] + 1] !=  3) {
                                $_SESSION['pos'] = [$_SESSION['pos'][0], $_SESSION['pos'][1] + 1];
                                if ($map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 2) {
                                    echo "gagné";
                                }
                            }
                            $map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                            break;
                        case 'left':
                            if ($_SESSION['pos'][1] - 1 >= 0 && $map[$_SESSION['pos'][0]][$_SESSION['pos'][1] - 1] !=  3) {
                                $_SESSION['pos'] = [$_SESSION['pos'][0], $_SESSION['pos'][1] - 1];
                                if ($map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 2) {
                                    echo "gagné";
                                }
                            }
                            $map[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                            break;    
                        default:
                            break;
                    }
                }
            }
            ?>

            <form method="POST" id ="button-container" class="button-container">
                <div class="butt-Cont">
                    <input type="submit" name="move" value="up" class="move-button">
                </div>
                <div class="butt-Cont">
                    <input type="submit" name="move" value="down" class="move-button">
                </div>
                <div class="butt-Cont">
                    <input type="submit" name="move" value="left" class="move-button">
                </div>
                <div class="butt-Cont">
                    <input type="submit" name="move" value="right" class="move-button">
                </div>
                <div class="butt-Cont">
                    <input type="submit" name="reset" value="reset" class="reset-button">
                </div>
            </form>

            <table class="game-table">
                <?php
                foreach ($map as $row) {
                    echo '<tr>';
                    foreach ($row as $value) {
                        echo '<td class="game-cell">';
                        if ($value == 3) {
                            echo "<img src='./assets/image/mansor.png' alt='mansor' class='game-image'>";
                        } else if ($value == 2) {
                            echo "<img src='./assets/image/mouse.png' alt='mouse' class='game-image'>";
                        } else if ($value == 1) {
                            echo "<img src='./assets/image/blackcat.png' alt='blackcat' class='game-image'>";
                        } else if ($value == 7 || $value == 0) {
                            echo "<img src='./assets/image/brl.png' alt='brl' class='game-image'>";
                        } else {
                            echo $value;
                        }
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </main>
</body>
</html>