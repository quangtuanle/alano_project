<?php
	$query = "select * from theloai";
	$typenews = mysqli_query($connection, $query);
?>

<div class="menu">
	<ul>
		<li><a href="index.php">Trang chủ</a></li>
		<?php
			while ($row = mysqli_fetch_array($typenews)) {	
		?>	
		<li><a href="index.php?show=typenews & id=<?php echo $row['MaTheLoai'] ?>">
			<?php echo $row['TenTheLoai'] ?>
			</a>
		</li>
		<?php
			}
		?>
	</ul>
</div>
<!-- End MENU -->
