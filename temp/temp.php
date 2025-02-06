<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrollable Division Example</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            /* Optional: to better visualize the centered content */
        }

        .scrollable-division {
            width: 300px;
            height: 200px;
            overflow: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
            /* Optional: to better visualize the division */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Optional: to add a subtle shadow */
        }
    </style>
</head>

<body>
    <div class="scrollable-division">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et lorem vel lacus tempor placerat. Cras nec
            ultrices tortor. Suspendisse potenti. Ut vulputate erat nec lacus lacinia, non facilisis purus viverra.
            Vestibulum euismod metus a ex vehicula, et tincidunt arcu cursus. Nam vehicula nisi non mauris pretium, id
            congue turpis elementum. Integer vel nulla vel leo tempus malesuada. Aliquam erat volutpat. Duis interdum
            lorem nec justo commodo, eget consectetur dui volutpat. Nam in malesuada orci, et feugiat turpis. Cras
            cursus dictum metus, nec tincidunt ligula vehicula id. Curabitur non justo sapien.</p>
        <p>Vestibulum sit amet sem dictum, vulputate quam at, cursus erat. Quisque ut nisi leo. Integer vulputate nec
            nisl at malesuada. Nam vulputate ex in ipsum varius, vel convallis purus tristique. Integer vitae dolor nec
            velit pharetra convallis. Duis vehicula vestibulum metus. Aenean in sem ex. Ut ut fringilla ligula. Sed nec
            dapibus felis, non bibendum libero. Sed at sollicitudin sapien. Curabitur sit amet accumsan lectus, non
            ultrices ligula.</p>
        <p>Phasellus eu nisl eget velit ultricies blandit. Integer fringilla turpis in augue sagittis volutpat. Cras ut
            nulla non urna vehicula finibus. Curabitur scelerisque justo nec fermentum suscipit. Duis eget mauris orci.
            Donec pharetra urna quis metus fermentum volutpat. Nam eget mi at purus elementum tempor. Cras malesuada,
            ipsum nec ultricies suscipit, nisl urna pharetra ligula, in vehicula eros dolor nec erat. Fusce ut venenatis
            purus. Etiam tempus lorem a risus pretium, ac scelerisque orci rhoncus. Nunc sollicitudin sapien nec
            tincidunt tincidunt.</p>
    </div>
</body>
<label for="table" class="form-label">Select Category<span class="text-danger">*</span></label> <br>
<select class="form-label" name="table" aria-label=".form-select-lg example" required>
    <option value="">Select Category</option>
    <?php
                            include '../include/config.php';
                            $i = 0;
                            $sql = "SELECT * FROM categories";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($result);
                            if ($count > 0) {


                                while ($row = mysqli_fetch_assoc($result)) {

                                    $i++
                            ?>
    <option value="<?php echo $row['category'] ?>">
        <?php echo $row['category'] ?>
    </option>
    <?php
                                }
                            } ?>
</select>

</html>

<?php
 
  if(isset($_GET['id']))
  {
    echo "Hello this is my first program ";
  }
?>