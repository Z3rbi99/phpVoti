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
	<?php echo $seleziona."ciao".$opzione; ?>
	</select>
	
	<input type="submit" value="Dimmi i voti"/>
	
	
	
	<!-- <input type="text" name="Note" value="<?php echo $Note_input; ?>"/> -->
	
	

<?php
if(!isset($_GET['materia']))
		$seleziona = "<option selected>-Seleziona la materia-</option>";
	
$opzione = '';

while($mat = pg_fetch_assoc($querymaterie)){
		if ($_GET['materia']==$mat['materia'])
			$opzione = $opzione."<option value='".$mat['materia']."' selected>".$mat['materia']."</option>";
		else
			$opzione = $opzione."<option value='".$mat['materia']."'>".$mat['materia']."</option>";
		}
		
if (isset($_GET['materia'])){
$input=$_GET['materia'];

if(!$queryinput = @pg_query("select voto,materia from voti
where materia='".$input."'"))
die("Errore nella query: " . pg_last_error($conn));
tabella();
function tabella(){
echo <<<EOD
<table border="1" cellspacing="2" cellpadding="2">
    <tr>
        <td><b>VOTO</b></td>
		<td><b>MATERIA</b></td>
    </tr>
EOD;
while($row = pg_fetch_assoc($queryinput)) {
    echo "\n\t<tr>\n\t\t<td>".$row['voto']."</td>\n\t\t";
    echo "<td>".$row['materia']."</td>\n\t\t</tr>";
}
echo "</table>";
};
?>

      <input type="text" name="voto">
      <input type="submit" value="Aggiungi voto">
</form>
<?php
	if (isset($_GET['voto'])){
		$voto=$_GET['voto'];
		if(!$queryaggiungi = @pg_query("insert into VOTI (Nome,Materia,Voto,Professore) values ('Iacopo','".$_GET['materia']."','".$_GET['voto']."',Null);"))
		die("Errore nella query: " . pg_last_error($conn));
	}
}
?>






</html>