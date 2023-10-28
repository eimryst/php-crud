<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php
        $mName = '';
        $sortBy = '';
        $make = '';
        $transmission = '';
        $fuel_type = '';
        $price = '';

        if(isset($_GET['done'])){
            
            $mName = $_GET['model_name'];
            $make = $_GET['make'];
            $transmission = $_GET['transmission'];
            $fuel_type = $_GET['fuel_type'];
            $price = $_GET['price'];
        }
    ?>
    <div class="navBar">
        <a href="Home.php">Home</a>
        <a href="Search.php">Search</a>
        <a href="Add.php">Add</a>
        <a href="Delete.php">Delete</a>
    </div>
    <div>
        <form action="">
            <input type="submit" value="Search" name="search">
        </form>
    </div>
    <script>
        const searchForm = document.getElementById('searchForm');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const model_name = document.getElementById('model_name').value;
            const sort = document.getElementById('sort').value;
            const make = document.getElementById('make').value;
            const transmission = document.getElementById('transmission').value;
            const fuel_type = document.getElementById('fuel_type').value;

            const queryParams = new URLSearchParams();
            queryParams.append('model_name', model_name);
            queryParams.append('sort', sort);
            queryParams.append('make', make);
            queryParams.append('transmission', transmission);
            queryParams.append('fuel_type', fuel_type);

            const actionURL = 'Home.php' + '?' + queryParams.toString();

            searchForm.action = actionURL;

            searchForm.submit();
        });
    </script>
    <?php
        include ('connect_to_database.php');

        $query = "SELECT * FROM tblcars";
        $result = mysqli_query($conCD, $query);
        
        if (isset($_GET['search'])){
            header('Location: Search.php');
            exit;
        }

        if ($result) {
            // Check if there are any records
            if (mysqli_num_rows($result) > 0) {
                // Start creating the HTML table
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>Image</th>';
                echo '<th>Make</th>';
                echo '<th>Model Name</th>';
                echo '<th>Transmission</th>';
                echo '<th>Fuel Type</th>';
                echo '<th>Price</th>';
                echo '</tr>';
    
                // Loop through the records and display them in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td><img src="' . $row['image'] . '" alt="Car Image" width="200" height="200"></td>';
                    echo '<td>' . $row['make'] . '</td>';
                    echo '<td>' . $row['model_name'] . '</td>';
                    echo '<td>' . $row['transmission'] . '</td>';
                    echo '<td>' . $row['fuel_type'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "No records found.";
            }
        } else {
            echo "Error: " . mysqli_error($conCD);
        }
    ?>
</body>
</html>