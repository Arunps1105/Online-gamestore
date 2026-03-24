<option>...Select...</option>
<?php
include("../Connection/Connection.php");
		$sel="select * from tbl_subcategory  where category_id=".$_GET["sid"];
		$result=$Con->query($sel);
		while($row=$result->fetch_assoc())
		{
		?>
        <option value="<?php echo $row["subcategory_id"]?>">
		<?php echo $row["subcategory_name"]?></option>
		<?php
		}
		?>   