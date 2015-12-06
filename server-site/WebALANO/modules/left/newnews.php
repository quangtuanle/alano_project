<?php
	$sql = "select * from baiviet"; // order by MaBaiViet desc limit 9";
	$topic = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($topic);
?>
<div class="box1">
	<img src="" width="350" height="250" />
	<p class="title">
		<a href="index.php?show=detail&id=<?php echo $row['MaBaiViet'] ?>">
			<?php $row['TieuDe'] ?>
		</a>
	</p>
	<p class="brief">
		<?php echo $row['TomTat'] ?>
	</p>
</div>
<div class="box2">
	<ul>
	<?php
		while ($row = mysqli_fetch_array($topic)) {
	?>
		<li>
			<a href="index.php?show=detail&id=<?php echo $row['MaBaiViet'] ?>">
				<?php echo $row['TieuDe'] ?>
			</a>
		</li>
	<?php
		}
	?>
	</ul>
</div>
<div class="clear"></div>
