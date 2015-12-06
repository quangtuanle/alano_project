<?php
	$sql="select * from baiviet where MaTheLoai = '$_GET[id]'";
	$topic = mysqli_query($connection, $sql);
	
?>
<div class="content-left" style="width: auto;">
	<div class = "box2 widthtypenews">
		<ul>
			<?php
				while($row = mysqli_fetch_array($topic)){
			?>
				<img src="<?php echo $row['HinhAnhMinhHoa']?>" 
					 width="80" height="80" style="float: left;"/>
				<li style="list-style: none; font-size: 16px;">
					<a href="index.php?show=detail&id=<?php echo $row['MaBaiViet'] ?>">
					<?php echo $row['TieuDe'] ?>
					</a>
				</li>
				<p class="brieftypenews">
					<?php echo $row['TomTat'] ?>
				</p>
			<?php
				}
			?>
		</ul>
	</div>
</div>
