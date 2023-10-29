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
        

    ?>
    <hr>
    <form method = "post" enctype="multipart/form-data">
        <div>
            <label for="">ID:</label>
            <input type="number" name="" id="" value="<?= $row['id'] ?>" disabled>
        </div>
        <div>
            <label for="">Image:</label>
            <img src="<?= $row['image'] ?>" alt="Car Image" width="200" height="200">
            <input type="file" name="image" id="image" value="<?= $row['image'] ?>">
        </div>
        <div>
            <label for="">Make/Brand:</label>
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
        <div>
            <label for="">Model Name:</label>
            <input type="text" name="model" id="model" value="<?= $row['model_name'] ?>">
        </div>
        <div>
            <label for="">Transmission:</label>
            <select name="transmission" id="transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>
        <div>
            <label for="">Fuel Type:</label>
            <select name="fuel_type" id="fuel_type">
                <option value="">Choose</option>
                <option value="Regular">Regular</option>
                <option value="Diesel">Diesel</option>
                <option value="Premium">Premium</option>
            </select>
        </div>
        <div>
            <label for="">Price:</label>
            <input type="number" name="price" id="price" value="<?= $row['price'] ?>">
        </div>
        <input type="submit" value="Done" name="done">
    </form>

    <?php
    use Cloudinary\Api\Upload\UploadApi;
    
    $make = '';
    $model_name = '';
    $transmission = '';
    $fuel_type = '';
    $image = '';
    $price = '';

    if (isset($_POST['done'])) {
        $make = $_POST['make'];
        $model_name = $_POST['model'];
        $transmission = $_POST['transmission'];
        $fuel_type = $_POST['fuel_type'];
        $price = $_POST['price'];

            
        $whereClause = '';
        if (!empty($model_name)){
            $whereClause .= "MODEL_NAME = '$model_name'";
        }
        if (!empty($image)){
            $uploadApi = new UploadApi();
            $delete = $uploadApi->destroy($public_id);

            $uploadApi = new UploadApi();
            $response = $uploadApi->upload($_FILES['image']['tmp_name']);

            $image = $response['secure_url'];
            $image_id = $response['public_id'];

            $whereClause .= ", IMAGE = '$image', IMAGE_ID = '$image_id'";
        }
        if (!empty($make)) {
            $whereClause .= ", MAKE = '$make'";
        }
        if (!empty($transmission)) {
            $whereClause .= ", TRANSMISSION = '$transmission'";
        }
        if (!empty($fuel_type)) {
            $whereClause .= ", FUEL_TYPE = '$fuel_type'";
        }
        if (!empty($price)) {
            $whereClause .= ", PRICE = '$price'";
        }

            $sql = "UPDATE TBLCARS
                    SET $whereClause
                    WHERE ID = $carID";
    
            $result = mysqli_query($conCD, $sql);
    
            if ($result) {
                header('Location: Home.php');   
            } else {
                echo "Error: " . mysqli_error($conCD);
            }
        }
    
    ?>
</body>
</html>