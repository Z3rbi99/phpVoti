<html>
<?php
$conn = @pg_connect('dbname=postgres user=postgres password=iacopo');

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
    echo 'Connessione riuscita !<br />';
}
if (isset($_GET['Note']))
	$Note_input = $_GET['Note'];
else
	$Note_input = "Ciao";

	if(!$querymaterie = @pg_query("select distinct materia from voti"))
	die("Errore nella query: " . pg_last_error($conn));
	
?>
<form name="form1" method="get" action="VotiInput.php">
	<select name="materia">
	<?php 
if(!isset($_GET['materia']))
	echo "<option selected>-Seleziona la materia-</option>";

if (!isset($_GET['materia']))
	$scelta="";
else
	$scelta=$_GET['materia'];
	

while($mat = pg_fetch_assoc($querymaterie)){
		if ($scelta==$mat['materia'])
			echo"<option value='".$mat['materia']."' selected>".$mat['materia']."</option>";
		else
			echo"<option value='".$mat['materia']."'>".$mat['materia']."</option>";
		}


	?>
	</select>
	
	<input type="submit" value="Dimmi i voti"/>
	
	
	
	<!-- <input type="text" name="Note" value="<?php echo $Note_input; ?>"/> -->
	
	

<?php

if (isset($_GET['materia'])){
	$input=$_GET['materia'];

if(!$queryinput = @pg_query("select voto,materia from voti where materia='".$input."'"))
	die("Errore nella query: " . pg_last_error($conn));

function tabella(){
	global $queryinput;
	echo	"<table border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
		<tr>
			<td><b>VOTO</b></td>
			<td><b>MATERIA</b></td>
		</tr>";

	while($row = pg_fetch_assoc($queryinput)) {
		echo "\n\t<tr>\n\t\t<td>".$row['voto']."</td>\n\t\t";
		echo "<td>".$row['materia']."</td>\n\t\t</tr>";
	}
	echo "</table>";
};

tabella();


?>
<form name="form2" method="get" action="VotiInput.php">
      <input type="text" name="voto">
      <input type="submit" value="Aggiungi voto">

<?php
	if (isset($_GET['voto'])){
		$voto=$_GET['voto'];
		if(!$queryaggiungi = @pg_query("insert into VOTI (Nome,Materia,Voto,Professore) values ('Iacopo','".$_GET['materia']."','".$_GET['voto']."',Null);"))
		die("Errore nella query: " . pg_last_error($conn));
	}
}
?>
</form>





</html>