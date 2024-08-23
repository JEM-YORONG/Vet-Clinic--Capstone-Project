<?php
require 'database-conn.php';

$reschedule = 'Rescheduled';

$query = "SELECT * FROM schedule WHERE status = 'Missed' OR reschedule = '$reschedule'";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) :
?>
    <tr>
        <td><?php echo $row['reschedule']; ?></td>
        <td><?php echo $row["date"]; ?></td>
        <td data-label="Owner Name"><?php echo $row["ownername"]; ?></td>
        <td data-label="Pet Name">
            <?php echo $row["petname"]; ?>&nbsp
            <?php echo $row["petname2"]; ?>&nbsp
            <?php echo $row["petname3"]; ?>&nbsp
            <?php echo $row["petname4"]; ?>&nbsp
            <?php echo $row["petname5"]; ?>
        </td>
        <td data-label="Service">
            <?php echo $row["service"]; ?>&nbsp
            <?php echo $row["service2"]; ?>&nbsp
            <?php echo $row["service3"]; ?>
        </td>
        <td>
            <button type="button" class="edit-button" onclick="openForm(
                '',
                '<?php echo $row['ownername']; ?>',
                '<?php echo $row['petname']; ?>',
                '<?php echo $row['service']; ?>',
                '<?php echo $row['number']; ?>',
                '<?php echo $row['id']; ?>');">
                <span class="material-symbols-outlined">edit</span>
            </button>
        </td>
        <td>
            <button type="button" class="delete-button" onclick="openFormDelete(); deleteRow('<?php echo $row['id']; ?>', '<?php echo $row['ownername']; ?>');">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </td>
    </tr>
<?php endwhile; ?>