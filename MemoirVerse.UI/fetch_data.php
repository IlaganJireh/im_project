<?php
$sql = "SELECT mood, COUNT(*) as count FROM mood GROUP BY mood";
$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
  $data[] = $row;
}

$conn->close();

echo json_encode($data);
?>
