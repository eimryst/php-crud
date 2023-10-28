<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealer</title>
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
    require 'vendor/autoload.php';
    use Cloudinary\Configuration\Configuration;
    use Cloudinary\Api\Upload\UploadApi;

    Configuration::instance([
        'cloud' => [
            'cloud_name' => 'dstsbhlj2', 
            'api_key' => '522834947654228', 
            'api_secret' => '21_30PBkNrmWjR7XHGEEsHKMcz8'],
            'url' => [
            'secure' => true
        ]
    ]);

    $make = '';
    $model_name = '';
    $transmission = '';
    $fuel_type = '';
    $image = '';
    $price = '';

    if (isset($_POST['done'])) {
        $make = $_POST['brand'];
        $model_name = $_POST['model'];
        $transmission = $_POST['transmission'];
        $fuel_type = $_POST['fuel_type'];
        $price = $_POST['price'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadApi = new UploadApi();
            $response = $uploadApi->upload($_FILES['image']['tmp_name']);

            $image = $response['secure_url'];

            $sqlquery = "INSERT INTO TBLCARS(IMAGE, MODEL_NAME, MAKE, TRANSMISSION, FUEL_TYPE, PRICE)
                            VALUES('".$image."', '".$model_name."', '".$make."', '".$transmission."', '".$fuel_type."', '".$price."')";      

            mysqli_query($conCD, $sqlquery);

            echo "<script> alert('Added Successfully.') </script>";
            header('Location: Home.php');
        }
}

?>
    <form method = "post" enctype="multipart/form-data">
        <div>
            <label for="">Image:</label>
            <input type="file" name="image" id="image">
        </div>
        <div>
            <label for="">Make/Brand:</label>
            <select name="brand" id="brand">
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
            <input type="text" name="model" id="model" placeholder="eg. micro, sedan...">
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
            <input type="number" name="price" id="price">
        </div>
        <input type="submit" value="Done" name="done">
    </form>
</body>
</html>