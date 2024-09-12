<?php
include('db.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        * {
            padding: 0%;
            margin: 0%;
            font-family: 'poppins', sans-serif;
            box-sizing: border-box;

        }

       
        input {
            flex: 1;
            border: none;
            outline: none;

            background: transparent;
            padding: 10px;
            font-weight: 14px;
        }

        button {
            border: none;
            outline: none;
            padding: 16px 50px;
            background: #ff5945;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 40px;


        }

        #show-form-box {
            max-width: 640px;
            background: #d4d2d2;

            padding: 40px 30px 70px;
            border-radius: 10px;
        }

        /* 
   #list-container,#show-form-box{
    max-width: 340px;
    background: #d4d2d2;
    margin: 100px auto 20px;
    padding: 40px 30px 70px ;
    border-radius: 10px;
   } */
        ul {
            height: 550px;
            max-height: 550px;
            overflow-y: scroll;
            overflow-x: hidden;
            margin: 50px auto 20px;
            background-color: #D4D2D2;
            max-width: 680px;
            padding: 15px;
            border-radius: 15px;

            &::-webkit-scrollbar {
                width: 8px;

            }

            &::-webkit-scrollbar-track {
                background-image: #ffff;

            }

            &::-webkit-scrollbar-thumb {
                background: l #ff5945;
                background: linear-gradient(#1F2E73, #421365);
                border-radius: 15px;
            }
        }

        /* ul::-webkit-scrollbar{
       width: 8px;
   
   } */

        ul>li {
            list-style: none;
            font-size: 17px;
            padding: 12px 8px 12px 50px;
            user-select: none;
            cursor: pointer;
            margin-top: 15px;
            position: relative;

        }

        ul li::before {
            content: '';
            position: absolute;
            height: 28px;
            width: 28px;
            border-radius: 50%;
            background-image: url(images/unchecked.png);
            background-size: cover;
            background-position: center;
            top: 12px;
            left: 8px;

        }

        .checked {
            color: #343333;
            text-decoration: line-through;
        }

        .checked::before {
            background-image: url(images/checked.png);
        }

        ul li span {
            position: absolute;
            right: 0;
            top: 5px;
            width: 40px;
            height: 40px;
            font-size: 22px;
            color: #555;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
        }

        ul li span:hover {
            background-color: #EEEEEE;
        }

        ::-webkit-scrollbar {
            width: 15px;

        }

        ::-webkit-scrollbar-track {
            background-image: #ffff;

        }

        ::-webkit-scrollbar-thumb {
            background-color: #ff5945;
        }

        #loader {

            position: fixed;
            height: 100vh;
            width: 100%;
            background: #191919 url(images/0b9309cf2dd079c998a5414e32a04618.gif) no-repeat center center;
            background-size: 20%;
        }


        @media screen and (max-width:450px) {

            button {
                border: none;
                outline: none;
                padding: 11px 25px;
                background: #ff5945;
                color: #fff;
                font-size: 16px;
                cursor: pointer;
                border-radius: 40px;
            }

            .row {

                padding-left: 10px;
                margin-bottom: 15px;
            }

            .to-do-box {

                padding: 40px 14px 70px;

            }
        }
    </style>
</head>

<body>
<?php if (isset($_GET['showList'])): ?>
    <ul id="list-container">
        <?php
       $sql = "SELECT * FROM tasks WHERE user_id = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("i", $user_id);
       $stmt->execute();
       $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<li class='" . ($row['is_checked'] ? 'checked' : '') . "'>" . htmlspecialchars($row['task_name']) . "<span data-id='" . $row['id'] . "'>X</span></li>";
        }
        ?>
    </ul>
<?php endif; ?>

<script>
    const list = document.getElementById('list-container'); // Select the list container

    // Event listener to toggle the 'checked' class or delete an item
    list.addEventListener("click", function(e) {
        if (e.target.tagName === "LI") {
            e.target.classList.toggle("checked");  // Toggle 'checked' class
            saveData();  // Save updated list to localStorage
        } else if (e.target.tagName === "SPAN") {
            e.target.parentElement.remove();  // Remove the list item
            saveData();  // Save updated list to localStorage
        }
    }, false);

 
    showList();


</script>

</body>

</html>




</body>

</html>