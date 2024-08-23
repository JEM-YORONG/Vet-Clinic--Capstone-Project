<?php
require 'database-conn.php';

//$search = $_GET['search'];

$query = "SELECT * FROM logs ORDER BY id DESC";

// // If search input is not empty, add a WHERE clause to filter the data
// if (!empty($search)) {
//     $query .= " WHERE cliniId LIKE '%$search%' OR name LIKE '%$search%' OR role LIKE '%$search%' OR contact LIKE '%$search%' OR email LIKE '%$search%'";
// }

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) :
?>
    <tr id="<?php echo $row["id"]; ?>">
        <td><?php echo $row["date"]; ?></td>
        <td><?php echo $row["time"]; ?></td>
        <td><?php echo $row["role"]; ?></td>
        <td><?php echo $row["user"]; ?></td>
        <td><?php echo $row["action"]; ?></td>
    </tr>
<?php endwhile; ?>