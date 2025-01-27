<?php
// Include database connection
include 'connect_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $director_name = mysqli_real_escape_string($conn, $_POST['director']);
    $producer_name = mysqli_real_escape_string($conn, $_POST['producer']);
    $writer_name = mysqli_real_escape_string($conn, $_POST['writer']);

    // Check if director exists, if not, insert into directors table
    $sql = "SELECT id FROM directors WHERE name = '$director_name'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0) {
        mysqli_query($conn, "INSERT INTO directors (name) VALUES ('$director_name')");
    }
    // Retrieve director id
    $director_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM directors WHERE name = '$director_name'"))['id'];

    // Check if producer exists, if not, insert into producers table
    $sql = "SELECT id FROM producers WHERE name = '$producer_name'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0) {
        mysqli_query($conn, "INSERT INTO producers (name) VALUES ('$producer_name')");
    }
    // Retrieve producer id
    $producer_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM producers WHERE name = '$producer_name'"))['id'];

    // Check if writer exists, if not, insert into writers table
    $sql = "SELECT id FROM writers WHERE name = '$writer_name'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0) {
        mysqli_query($conn, "INSERT INTO writers (name) VALUES ('$writer_name')");
    }
    // Retrieve writer id
    $writer_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM writers WHERE name = '$writer_name'"))['id'];

    // Insert movie record into film table with foreign key associations
    $sql = "INSERT INTO film (title, release_year, genre, director_id, producer_id, writer_id) VALUES ('$title', '$release_year', '$genre', '$director_id', '$producer_id', '$writer_id')";
    if (mysqli_query($conn, $sql)) {
        echo "Movie added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
