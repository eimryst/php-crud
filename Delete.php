<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
    <div class="navBar">
        <a href="Home.php">Home</a>
        <a href="Add.php">Add</a>
    </div>
    <hr>
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
        use Cloudinary\Api\Upload\UploadApi;

        $query = "SELECT * FROM tblcars";
        $post_result = mysqli_query($conCD, $query);
    
        if (!$post_result) {
            return ["message" => "Post does not exist.", "status_code" => 401];
        }
    
        $post = $post_result->fetch_all(MYSQLI_ASSOC);
    
        $response = ["message" => "Posts fetched successfully.", "status_code" => 400, "data" => $post];
    
        if (isset($_GET['id'])) {
            $carID = $_GET['id'];
        }

        $sql = "SELECT * FROM TBLCARS WHERE ID = '$carID'";
        $result = mysqli_query($conCD, $sql);

        if (!$result) {
            echo 'Error';
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $model_name = $row['model_name'];
                $make = $row['make'];
                $transmission = $row['transmission'];
                $fuel_type = $row['fuel_type'];
                $price = $row['price'];
                echo 'Data retrieved.';
            } else {
                echo 'ID does not exist.';
            }
        }

        if (isset($_POST['yes'])) {
            $public_id = $row['image_id'];

            $uploadApi = new UploadApi();
            $delete = $uploadApi->destroy($public_id);

            if($delete){
            $sql = "DELETE FROM TBLCARS
                    WHERE ID = $carID";

            $result = mysqli_query($conCD, $sql);
            if ($result) {
                echo "<script> alert ('Deletion success.') </script>";
                header('Location: Home.php');
            } else {
                echo "Error: " . mysqli_error($conCD);
            }
        }
        elseif (isset($_POST['no'])){  
            echo "<script> alert ('Deletion terminated.') </script>"; 
            header('Location: Home.php');
            exit;
        }
    }
        

    ?>
    <hr>
    <form method = "post" enctype="multipart/form-data">
        <div>
            <label for=""><h1>Are you sure you want to delete ID #<?= $carID ?>?</h1></label>
            <input type="submit" value="Yes" name="yes">
            <input type="submit" value="No" name="no">
        </div>

        <hr>
        <div>
            <label for="">ID:</label>
            <input type="number" name="" id="" value="<?= $row['id'] ?>" disabled>
        </div>
        <div>
            <label for="image">Image:</label>
            <img src="<?= $row['image'] ?>" alt="Car Image" width="200" height="200">
        </div>
        <div>
            <label for="">Make/Brand:</label>
            <select name="make" id="make" disabled>
                <option value="<?= $row['make'] ?>"><?= $row['make'] ?></option>
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
        </div>
        <div>
            <label for="">Model Name:</label>
            <input type="text" name="model" id="model" value="<?= $row['model_name'] ?>"disabled>
        </div>
        <div>
            <label for="">Transmission:</label>
            <select name="transmission" id="transmission" disabled>
                <option value="<?= $row['transmission'] ?>"><?= $row['transmission'] ?></option>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>
        <div>
            <label for="">Fuel Type:</label>
            <select name="fuel_type" id="fuel_type" disabled>
                <option value="<?= $row['fuel_type'] ?>"><?= $row['fuel_type'] ?></option>
                <option value="Regular">Regular</option>
                <option value="Diesel">Diesel</option>
                <option value="Premium">Premium</option>
            </select>
        </div>
        <div>
            <label for="">Price:</label>
            <input type="number" name="price" id="price" value="<?= $row['price'] ?>" disabled>
        </div>
    </form>

</body>
</html>