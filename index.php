<?php

$alert = false;
$update = false;
$delete = false;

//Connecting to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//Creating a connection

$conn = mysqli_connect($servername, $username, $password, $database);

//Die if connection was not successful
if(!$conn){
  die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno = $_GET['delete']; //Will return the value of delete from URL that we've programmed using JavaScript.

    // * Deleting previous records.

    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
        // echo "The note has been deleted successfully.";
        $delete = true; // Use this for alert messages.
    }
    else{
        echo "The note couldn't be deleted.";
        echo mysqli_error($conn);
        echo "<br>";
    }
}
if ($_SERVER['REQUEST_METHOD'] == $_POST){
    if (isset($_POST['snoEdit'])){// This condition will update database if serial number is set already or else it'll just add a note.
        // * Updating previous records.
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descEdit'];
        
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if($result){
            // echo "The note has been updated successfully.";
            $update = true; // Use this for alert messages.
        }
        else{
            echo "The note couldn't be updated.";
            echo mysqli_error($conn);
            echo "<br>";
        }
    }
    else{// If serial number is not set we'll perform addition.
        // * Adding new records.
        $title = $_POST['title'];
        $description = $_POST['desc'];
        
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if($result){
            // echo "The note has been saved successfully.";
            $alert = true; // Use this for alert messages.
        }
        else{
            echo "The record was not inserted successfully.";
            echo mysqli_error($conn);
            echo "<br>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <!-- CSS & JavaScript Links included from source data tables search result from google -->

    <title>iNotes - Notes Taking Made Easy</title>
</head>

<body>
    <!-- Edit Trigger Modal
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit
    </button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/php/iNotes/index.php/" method="POST">
                <div class="modal-body">
                        <input type = "hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="desc">Description</label>
                            <textarea class="form-control" placeholder="Add description" id="descEdit" name="descEdit" rows="4"></textarea>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"> PHP CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if($alert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!!</strong> Note has been saved successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>'; // * Here goes our alert.
    }

    if($update){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!!</strong> Note has been updated successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>'; // * Here goes our alert.
    }

    if($delete){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> Note has been deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'; // * Here goes our alert.
    }

    ?>

    <div class="container my-4">
        <!-- ! This container will be used to add notes from front end to our database. -->
        <h2> Add a note</h2>
        <form action="/php/iNotes/index.php/" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="desc">Description</label>
                <textarea class="form-control" placeholder="Add description" id="desc" name="desc" rows="4"></textarea>
            </div>
            <!-- <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container">
        <!-- ! This tag will be used to list our notes -->
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);
            $sno = 1;

            while($row = mysqli_fetch_assoc($result)){
              echo "<tr>
              <th scope='row'>" . $sno . "</th>
              <td>" . $row['title'] . "</td>
              <td>" . $row['description'] . "</td>
              <td>
                <button type='button'  id=".$row['sno']." class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal'> 
                    Edit 
                </button> 
                <button type='button'  id=d".$row['sno']." class='delete btn btn-sm btn-primary'> 
                    Delete 
                </button>
              </td>
              </tr>";
              echo "<br>";
              $sno = $sno + 1;
            }
          ?>
            </tbody>
        </table>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        // * We'll need to add id myTable to the table.
    });
    </script>
    <!-- Included from search result data tables. -->


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
    <script>
    //Creating an event listner for when anyone clicks on edit button, targeting the event by using the class name 'edit'
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ", );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            descEdit.value = description; // * This will fill in the respective data in our modal.
            snoEdit.value = e.target.id; // * This will return us the id of the button.
            console.log(e.target.id);
            // * $('#editModal').modal('toggle'); Using this code we can toggle our modal window, ie; open/close.
        })
    });

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete ", );

            sno = e.target.id.substr(1,); // * Substr(1,) will substract first character from our string.
            
            if(confirm("Confirm your deletion?")){
                console.log("Yes");
                window.location = `/php/iNotes/index.php?delete=${sno}`;// * Using backticks, template literals in JavaScript.
                // Use a form to submit sno using Javascript to make it
            }
            else{
                console.log("No.");
            }
        })
    });
    </script>
</body>

</html>