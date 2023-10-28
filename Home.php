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
        $min = '';
        $max = '';

        if(isset($_GET['done'])){
            
            $mName = $_GET['model_name'];
            $make = $_GET['make'];
            $transmission = $_GET['transmission'];
            $fuel_type = $_GET['fuel_type'];
            $min = $_GET['min'];
            $max = $_GET['max'];
        }
    ?>
    <div class="navBar">
        <a href="Home.php">Home</a>
        <a href="Add.php">Add</a>
    </div>
    <hr>
    <div class="search">
        <form method ="get">
            <table>
                <tr>
                    <th>Model Name:</th>
                    <td>
                        <input type="text" name="model_name" id="model_name" value="<?= $mName ?>">
                    </td>
                </tr>
                <tr>
                    <th>Sort by:</th>
                    <td>
                        <select name="sortby" id="sortby">
                            <option value="">Choose</option>
                            <option value="asc">A to Z</option>
                            <option value="desc">Z to A</option>
                            <option value="asce">Ascending</option>
                            <option value="desce">Descending</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th rowspan="5">Filter: </th>
                    <tr>
                    <td> Make:
                    <select name="make" id="make">
                        <option value="">Choose</option>
                        <option value="Honda">Honda</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Ford">Ford</option>
                        <option value="Lexus">Lexus</option>
                        <option value="BMW">BMW</option>
                        <option value="Mercedes Benz">Mercedes Benz</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Porsche">Porsche</option>
                        <option value="Tesla">Tesla</option>
                        <option value="Audi">Audi</option>
                        <option value="Jaguar">Jaguar</option>
                        <option value="Subaru">Subaru</option>
                        <option value="Volvo">Volvo</option>
                        <option value="Ferrari">Ferrari</option>
                        <option value="Volkswagen">Volkswagen</option>
                        <option value="Bentley">Bentley</option>
                    </select>
                </td>
                    </tr>
                    <tr>
                    <td> Transmission:
                        <select name="transmission" id="transmission">
                            <option value="">Choose</option>
                            <option value="automatic">Automatic</option>
                            <option value="manual">Manual</option>
                        </select></td>
                        </tr>
                        <tr>
                    <td>Fuel Type:
                        <select name="fuel_type" id="fuel_type">
                            <option value="">Choose</option>
                            <option value="Regular">Regular</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Premium">Premium</option>
                        </select>
                        </tr>
                    </td>
                    <td>
                        Price:
                        <input type="number" name="min" id="min" value="<?= $min ?>">
                        - 
                        <input type="number" name="max" id="max" value="<?= $max ?>">
                    </td>
                </tr>
            </table>
            <input type="submit" value="Search" name="done">
            <hr>
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

        $sql = "SELECT * FROM tblcars ORDER BY ID ASC";
        

    if(isset($_GET['done'])){
        $mName = $_GET['model_name'];
        $sortBy = $_GET['sortby'];

        // Initialize the WHERE clause with the Model Name condition
        $whereClause = "model_name LIKE '%$mName%'";

        // Check and add conditions for other optional fields
        if (!empty($_GET['make'])) {
            $make = $_GET['make'];
            $whereClause .= " AND make = '$make'";
        }
        if (!empty($_GET['transmission'])) {
            $transmission = $_GET['transmission'];
            $whereClause .= " AND transmission = '$transmission'";
        }
        if (!empty($_GET['fuel_type'])) {
            $fuel_type = $_GET['fuel_type'];
            $whereClause .= " AND fuel_type = '$fuel_type'";
        }
        if (!empty($_GET['min']) && !empty($_GET['max'])) {
            $min = $_GET['min'];
            $max = $_GET['max'];
            $whereClause .= " AND price BETWEEN $min AND $max";
        }

        // sorting and displaying
        if (empty($mName) && empty($sortBy)){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY ID ASC";
        }
        elseif (empty($sortBy)){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY id ASC";
        }
        elseif (empty($mName) && $sortBy == 'asc'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY model_name ASC";
        }
        elseif (empty($mName) && $sortBy == 'desc'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY model_name DESC";
        }
        elseif (empty($mName) && $sortBy == 'asce'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY price ASC";
        }
        elseif (empty($mName) && $sortBy == 'desce'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY price DSC";
        }
        elseif ($sortBy == 'asc'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY model_name ASC";
        }
        elseif ($sortBy == 'desc'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY model_name DESC";
        }
        elseif ($sortBy == 'asce'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY price ASC";
        }
        elseif ($sortBy == 'desce'){
            $sql = "SELECT * FROM TBLCARS WHERE $whereClause ORDER BY price DESC";
        }
    }
    $result = mysqli_query($conCD, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Image</th>';
            echo '<th>Make</th>';
            echo '<th>Model Name</th>';
            echo '<th>Transmission</th>';
            echo '<th>Fuel Type</th>';
            echo '<th>Price</th>';
            echo '<th></th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><img src="' . $row['image'] . '" alt="Car Image" width="200" height="200"></td>';
                echo '<td>' . $row['make'] . '</td>';
                echo '<td>' . $row['model_name'] . '</td>';
                echo '<td>' . $row['transmission'] . '</td>';
                echo '<td>' . $row['fuel_type'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '<td> <a href="Update.php?id=' . $row['id'] . '">Edit</a> <br> <hr> <a href="Delete.php?id=' . $row['id'] . '">Delete</a></td>';
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