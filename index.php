<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>Schoolpéa</title>
	<link rel="stylesheet" type="text/css" href="https://schoolpea.com/accueil.css">
</head>

<body>
	<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	if (isset($_SESSION['mail_valide'])) {
		$path .= '/headerL.php';
	} else {
		$path .= '/headerNL.php';
	}
	include($path);
	?>

	<span class="trait" id="SchoolPea"></span>

	<div id="shadow_search">
		<div id="Search_section">
			<div class="aff">
				<span id="text_search">
					<h1 style="font-weight: bold; font-size: 60px">
						SchoolPéa
					</h1>
					<h6 style="font-weight: 500; font-size: 18px">
						Jouons pour apprendre,<br />
						Gagnons pour réussir !
					</h6>
				</span>
				<img id="logo_aff" src="https://schoolpea.com/Images/SchoolPea.png" alt="Logo" />
			</div>

			<div class="but">
				<a href="https://schoolpea.com/Cours/">
					Trouver un cours
				</a>
				<a href="https://schoolpea.com/Quizzs/">
					Trouver un quizz
				</a>
			</div>

			<div id="barreDeRecherche">
        <input type="text" id="coursenquizz-search" placeholder="Rechercher un cours ou un quizz ..." onkeyup="searchCourses()">
        <div id="dropdown" class="dropdown"></div>
    </div>
		</div>
	</div>

	<span class="trait" id="Explorer_les_cours"></span>

	<div id="Cours_section">
    <span>
        <p id="titre_cours">Nos Cours les plus populaires</p>
    </span>
    <div class="fenetre">
        <?php
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            try {
                $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupération des cours depuis la base de données
                $sql = "SELECT * FROM COURS";
                $stmt = $bdd->query($sql);

                $counter = 0;
                while ($row = $stmt->fetch()) {
                    if ($counter % 4 == 0 && $counter != 0) {
                        echo "</div><div class='fenetre'>";
                    }
                    echo "<span id='fen" . ($counter + 1) . "'>";
                    echo "<h3>" . htmlspecialchars($row['nom']) . "</h3>";
                    if (!empty($row['path_image_pres']) && file_exists($row['path_image_pres'])) {
                        echo "<img src='" . htmlspecialchars($row['path_image_pres']) . "' alt='Image de présentation'>";
                    } else {
                        echo "<img src='default-image.jpg' alt='Image par défaut'>";
                    }
                    echo "<a href='/Cours/voirCours.php?id_cours=" . htmlspecialchars($row['id_COURS']) . "'>Voir le cours</a>";
                    echo "</span>";
                    $counter++;
                }

                if ($counter == 0) {
                    echo "<span>Aucun cours trouvé.</span>";
                }
            } catch (PDOException $e) {
                echo "Erreur Connexion : " . $e->getMessage();
                die;
            }
        ?>
    </div>
</div>


	<span>
		<a class="voir_plus" href="https://schoolpea.com/Connexion/">
			Voir plus >
		</a>
	</span>

	<span class="trait" id="2"></span>

	<div id="Quizz_section">
		<span>
			<p id="titre_quizz">Nos Quizzs les plus sollicités !</p>
		</span>
		<div id="div_quizz">
			<div class="fenetre">
				<?php
				// $options = [
				//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				// ];

				// try {
				//     $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
				//     $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				//     // Récupération des quizz depuis la base de données
				//     $sql = "SELECT * FROM quizz";
				//     $stmt = $bdd->query($sql);

				//     $counter = 0;
				//     while ($row = $stmt->fetch()) {
				//         if ($counter % 4 == 0 && $counter != 0) {
				//             echo "</div><div class='fenetre'>";
				//         }
				//         echo "<span id='quizz_" . ($counter + 1) . "'>" . $row["nom"] . "</span>";
				//         $counter++;
				//     }

				//     if ($counter == 0) {
				//         echo "<span>Aucun quizz trouvé.</span>";
				//     }
				// } catch (PDOException $e) {
				//     echo "Erreur Connexion : " . $e->getMessage();
				//     die;
				// }
				?>
			</div>
		</div>

		<span>
			<a class="voir_plus" href="https://schoolpea.com/Connexion/">Voir plus ></a>
		</span>
	</div>

	<span class="trait" id="3"></span>

	<footer>
		<div class="footer">
			<span class="col1">
				<h3>
					<a href="#SchoolPea" style="color: white; text-decoration: none; font-weight: bolder;">SchoolPéa</a>
				</h3>
			</span>

			<span class="col2">
				<h4>Schoolpéa</h4>
				<a>Accueil</a>
				<a>A propos</a>
			</span>

			<span class="col3">
				<h4>Contact</h4>
				<a>E-mail</a>
				<a>Linkedin</a>
			</span>

			<span class="col4">
				<h4>Newsletter</h4>
				<a>Api fetch à Implémenter<br />Input email</a>
			</span>
		</div>
	</footer>

	<script>
        function searchCourses() {
            let input = document.getElementById('coursenquizz-search').value.toLowerCase();

            if (input.length === 0) {
                document.getElementById('dropdown').style.display = 'none';
                return;
            }

            // Creating a new XMLHttpRequest object
            let xhr = new XMLHttpRequest();

            // Define the type of request: GET and the URL including the input
            xhr.open('GET', 'searchCourses.php?query=' + input, true);

            // Set up a function to handle the response
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the JSON response
                    let courses = JSON.parse(xhr.responseText);

                    // Clear previous results
                    let dropdown = document.getElementById('dropdown');
                    dropdown.innerHTML = '';

                    // Display the dropdown list
                    courses.forEach(course => {
                        let item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.textContent = course.nom;
                        item.onclick = function () {
                            window.location.href = 'voirCours.php?nom=' + encodeURIComponent(course.nom);
                        };
                        dropdown.appendChild(item);
                    });

                    dropdown.style.display = 'block';
                }
            };

            // Send the request
            xhr.send();
        }

        // Hide the dropdown when clicking outside
        document.addEventListener('click', function (event) {
            let dropdown = document.getElementById('dropdown');
            if (!dropdown.contains(event.target) && event.target.id !== 'coursenquizz-search') {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>

</html>