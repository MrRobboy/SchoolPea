<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>Classement</title>
	<link rel="stylesheet" type="text/css" href="./classement.css" />
</head>

<body>
	<?php
	session_start();
	$path = $_SERVER['DOCUMENT_ROOT'];
	if (isset($_SESSION['id'])) {
		$path .= '/headerL.php';
	} else {
		$path .= '/headerNL.php';
	}
	include_once($path);
	?>

	<span class="trait" id="SchoolPea"></span>

	<div id="classement">
		<h1 style="padding: 2.5rem 0; font-weight: bolder; font-size: 40px">Classement Général !</h1>
		<table>
			<thead>
				<tr>
					<th style="padding: 0 0.5rem; border-right-color: white;">Rang</th>
					<th style="padding: 0 7rem">Nom</th>
					<th style="padding: 0 5rem">Prenom</th>
					<th style="padding: 0 3rem">Elo</th>
					<th style="padding: 0 3rem">Moyenne</th>
					<th style="padding: 0 3rem; border-right: none">MMR</th>
				</tr>
			</thead>
			<tbody>
				<tr style="font-size: 20px;font-weight: 700;text-transform: uppercase;">
					<td style="border-left: none; padding: 1rem">#1</td>
					<td colspan="2">Salut</td>
					<td colspan="2">Coucou</td>
					<td style="border-right: none">2000</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none; padding: 0.6rem">#2</td>
					<td>El Attar</td>
					<td>Ahmed</td>
					<td>2250</td>
					<td>18.5</td>
					<td style="border-right: none">2400</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none; padding: 0.4rem">#3</td>
					<td>Ngo</td>
					<td>Mathis</td>
					<td>2300</td>
					<td>18</td>
					<td style="border-right: none">2250</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#4</td>
					<td>Baoudj</td>
					<td>Ryad</td>
					<td>1200</td>
					<td>12</td>
					<td style="border-right: none">900</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#5</td>
					<td>Czech</td>
					<td>Natalia</td>
					<td>1459</td>
					<td>15</td>
					<td style="border-right: none">1700</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#6</td>
					<td>Majeri</td>
					<td>Ilyes</td>
					<td>2137</td>
					<td>14.8</td>
					<td style="border-right: none">2000</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#7</td>
					<td>Karamoko</td>
					<td>Mariam</td>
					<td>1873</td>
					<td>13.9</td>
					<td style="border-right: none">1839</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#8</td>
					<td>Przybylski</td>
					<td>Theo</td>
					<td>2190</td>
					<td>Trop petit pour ça</td>
					<td style="border-right: none">2191</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#9</td>
					<td>Stevant</td>
					<td>Evan</td>
					<td>1289</td>
					<td>17</td>
					<td style="border-right: none">1309</td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#10</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#11</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#12</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#13</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#14</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#15</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#16</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#17</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#18</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#19</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#20</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#21</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#22</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#23</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#24</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#25</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#26</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#27</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#28</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#29</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="border-right: none"></td>
				</tr>
				<tr style="font-weight: 500">
					<td style="border-left: none">#30</td>
					<td>Bouraima</td>
					<td>Bayané</td>
					<td>300</td>
					<td>10</td>
					<td style="border-right: none">190</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>

</html>