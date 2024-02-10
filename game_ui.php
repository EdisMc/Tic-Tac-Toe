<?php if (!$mode): ?>
    <p>Select game mode:</p>
    <ul>
        <li><a href="?mode=person">Person vs. Person</a></li>
        <li><a href="?mode=computer">Human vs. Computer</a></li>
    </ul>
<?php else: ?>
    <table>
        <?php if (!isset($_SESSION['board'])): ?>
            <?php $_SESSION['board'] = initialize_board(); ?>
        <?php endif; ?>
        <?php foreach ($_SESSION['board'] as $row_index => $row): ?>
            <tr>
                <?php foreach ($row as $col_index => $cell): ?>
                    <td>
                        <?php if ($cell === null): ?>
                            <a href="?move&row=<?php echo $row_index ?>&col=<?php echo $col_index ?>&mode=<?php echo $mode ?>">
                                &nbsp;
                            </a>
                        <?php else: ?>
                            <?php echo $cell ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>Current player: <?php echo isset($_SESSION['current_player']) ? $_SESSION['current_player'] : '' ?></p>
    <p><a href="?reset">Reset game</a></p>
<?php endif; ?>
