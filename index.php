<?php 

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$helping = json_decode(file_get_contents("./state.json"), true)["helping"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CoderLab help</title>
    <style>
        body {
            position: fixed;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }
        #enable_btn, #disable_btn {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            display: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 400ms;
            text-align: center;
        }
        #enable_btn:hover, #disable_btn:hover {
            background-color: #e6e6e6;
        }
        #enable_btn {
            border: 2px solid green;
            color: green;
        }
        #disable_btn {
            border: 2px solid red;
            color: red;
        }
        .display {
            display: block !important;
        }
        .flex {
            display: flex;
            position: fixed;
            height: 35%;
            margin: auto;
            top: 7%;
            left: 50%;
            transform: translate(-50%);
            width: 100%;
            justify-content: space-evenly;
        }
        .flex img {
            height: 100%;
            width: auto;
        }
    </style>
</head>
<body>
        <div class="flex">
            <img src="/garage.png" />
            <img src="/coderLab.png" />
        </div>
    <?php if ($helping) { ?>
        <a id="enable_btn">Nous sommes Disponible !</a>
        <a id="disable_btn" class="display">Nous sommes Indisponible.</a>
    <?php } else { ?>
        <a id="enable_btn" class="display">Nous sommes Disponible !</a>
        <a id="disable_btn">Nous sommes Indisponible.</a>
    <?php } ?>
</body>
<script>
        let enable = document.querySelector("#enable_btn");
        let disable = document.querySelector("#disable_btn");
        enable.addEventListener("click", (e) => {
            e.preventDefault();
            fetch("bot.php?start=true").then((response) => {
                if (response.status == 200) {
                    enable.classList.remove("display");
                    disable.classList.add("display");
                } else if (response.status == 455) {
                    window.location.reload();
                }
            }).catch((error) => {
                alert("Erreur lors de la requête : " + error.message);
            });
        });
        disable.addEventListener("click", (e) => {
            e.preventDefault();
            fetch("bot.php?start=false").then((response) => {
                if (response.status == 200) {
                    enable.classList.add("display");
                    disable.classList.remove("display");
                } else if (response.status == 455) {
                    window.location.reload();
                }
            }).catch((error) => {
                alert("Erreur lors de la requête : " + error.message);
            });
        });
    </script>
</html>