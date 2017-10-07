    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
          
	<?php
	//print_r($_POST);
	function generateRandomString($length = 4) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$inssql='';
	 $actualfile='';
    $a=1;$b="";
	//print_r($_POST);
//print_r($_FILES);
	if(isset($_POST['urlinput']))
	{ if(!array_map('str_getcsv', file($_POST['urlinput'])))
		die("Enter proper url");
	else
		
		{$csv = array_map('str_getcsv', file($_POST['urlinput']));
		$actualfile=$_POST['urlinput'];
		$a=0; }
	}
	else if(isset($_FILES) && !empty($_FILES))
	{
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileinput"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["12formsubmit"])) {
    

// Check if file already exists
if (file_exists($target_file)) {
	//while (file_exists($target_file))
    //$target_file=$target_dir.basename($_FILES["fileinput"]["name"]).'.'.$imageFileType;
}
// Check file size
if ($_FILES["fileinput"]["size"] > 10*1024*1024) {
    echo "Sorry, your file is too large. Size should be less than or equal to 2MB.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "csv" && $imageFileType != "CSV"  ) {
    echo "Sorry, only CSV files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileinput"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileinput"]["name"]). " has been uploaded.";
		
		if(!array_map('str_getcsv', file($target_file)))
		die("Enter proper url");
	else
	{$actualfile=$target_file;
		$csv = array_map('str_getcsv', file($target_file));
	$a=0;
	}		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} }
	}
	else
	{
		$csv = array_map('str_getcsv', file("uploads/100.csv"));
		$actualfile="uploads/csv.csv";
		$a=0;
		
	}
	
	if($a==0)
	{
		$get=array();
		$ansdata=array();
		foreach($_REQUEST as $k=>$v)
		{
			$k=str_replace("_"," ",$k);
		array_push($get,$k,$v);
		}
		
		
		$data=array();
		$col=$csv[0];
		for($i=1;$i<sizeof($csv);$i++)
		{
			$arr=array();
			$arr=array_combine($col,$csv[$i]);
			array_push($data,$arr);
				
		}

		
		$ans=$data; $f=0;
		if(isset($_REQUEST))
		{for($i=0;$i<sizeof($get);$i+=2)
			{
				
				
		if(array_key_exists($get[$i],$ans[0]))
		{
			if(!empty($get[$i+1]))
			{
			if($i!=0)
				{
				$ansdata[sizeof($ansdata)]=array();
				}
				else
				{
				$ansdata[$i]=array();	
				}
			
			if($f==0)
			{
			
			for($j=0;$j<sizeof($ans);$j++)
			{
				
				if($ans[$j][$get[$i]]==$get[$i+1])
				{
					array_push($ansdata[sizeof($ansdata)-1],$ans[$j]);
					
					$f=1;
				
				}
			}
			}
			else
			{
			
			$ansdata2=($ansdata[sizeof($ansdata)-2]);
			
				for($j=0;$j<sizeof($ansdata2);$j++)
			{
				
			
				if($ansdata2[$j][$get[$i]]==$get[$i+1])
				{
					
					array_push($ansdata[sizeof($ansdata)-1],$ansdata2[$j]);
					
					$f=1;
					
				}
			}
				
			}
			
		}
		}		
			}
		}
		$txt="";
		
		if(empty($_POST['tableinputname']))
		{
		$target_file=generateRandomString();
		while (file_exists($target_file))
    $target_file=generateRandomString();
$txt="Insert into ".$target_file." (";
$inssql="Create table ".$target_file." (";
	}
	else
	{$target_file=$_POST['tableinputname'];
	$txt="Insert into ".$_POST['tableinputname']." (";
	
	} 
	
	

		
		echo "<div class='container'><table id='table2' style=' display: block;
  height: 80%;
  overflow-y: scroll;' class='striped'><thead><tr>";
		$hflag=0;
		
		foreach($col as $r)
		{
			if($hflag!=0)
			{
				$txt.=",";
				$inssql.=",";
			}
			else
				$hflag=1;
		echo "<th>".$r."</th>";
		$txt.="`".$r."`"; $inssql.="`".$r."` VARCHAR(1000)";
		}
		$txt.=") values ";
		$inssql.=");";
		echo "</tr></thead><tbody>";
		$hflag=0;$cflag=0;
		if(empty($ansdata))
		{	$ansdata=$ans;
		
		
		foreach ($ansdata as $r)
		{
			if($cflag!=0)
			$txt.=" ,(";
		else
		{	$txt.=" (";
		$cflag=1;
		}
			
			echo "<tr>";$hflag=0;
			foreach($r as $d=>$v)
			{
				if($hflag!=0)
					$txt.=",";
				else
					$hflag=1;
				$txt.="'".$v."'";
				
		echo "<td>".$v."</td>";
		
			}echo "</tr>";
			$txt.=")";
		}
		}
		else
		{
			foreach ($ansdata[sizeof($ansdata)-1] as $r)
		{
			if($cflag!=0)
			$txt.=" ,(";
		else
		{	$txt.=" (";
		$cflag=1;
		}
			echo "<tr>";$hflag=0;
			foreach($r as $d=>$v)
			{if($hflag!=0)
					$txt.=",";
				else
					$hflag=1;
				$txt.="'".$v."'";
		echo "<td>".$v."</td>";
			}
		echo "</tr>"; $txt.=")";
		}
		}
		echo "</tbody></table></div>";
		//echo "<br/>".$txt;
		$target_file="";
		$target_file2="downloads/Create".$target_file.".sql";
		$target_file="downloads/".$target_file.".sql";
		
		$myfile=fopen($target_file,"w") or die ("Some error");
		fwrite($myfile,$txt);
		fclose($myfile);
		$myfile2=fopen($target_file2,"w") or die ("Some error");
		
		fwrite($myfile2,$inssql);
		fclose($myfile2);
		
		echo "<br/><a  class='waves-effect waves-light btn' href='".$target_file."' download>Download Insert SQL</a><a  class='waves-effect waves-light btn' href='".$target_file2."' download>Download Create table SQL</a><h2 align='center'>Filter By Columns</h2><br/><div class='container'><form method='POST'  action=''><input type='password' name='urlinput' value='".$actualfile."' style='display:none'><input type='password' name='tableinputname' value='".$target_file."' style='display:none'>";
		$row=0;
 foreach($col as $r)
 {
	 if($row%2==0)
	 { 
 if($row!=0)
 {echo "</div>";
 }
 echo "<div class='row'>"; }
 
 
	echo "<div class='input-field col s6'><input id='".$r."' placeholder='".$r."' type='text' class='validate' name='".$r."'></div>"; 
	 $row++;
 }
 
 echo "</div><div class='row'><div class='input-field col s6'><input class='waves-effect waves-light btn' name='12submit' type='submit' value='Submit'></div></div></form></div>";
	}
	//insert into tablename () values ();
		
		//print_r($ansdata);
		//print_r($_POST);
		?>
		<script src="table.js"></script>
		
		
		<script>paginate(10,document.getElementById("table2"))</script>
	