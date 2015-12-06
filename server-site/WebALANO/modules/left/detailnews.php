<?php
	$sql = "select * 
			from baiviet, theloai, ct_theloaibaiviet
			where baiviet.MaBaiViet = ct_theloaibaiviet.MaBaiViet and
				  theloai.MaTheLoai = ct_theloaibaiviet.MaTheLoai and
				  theloai.MaTheLoai = '$row_typenews[MaTheLoai]'";
			/*order by MaTheLoai desc limit 5*/
				
	$topic = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($topic);	
?>
<div class="content">
	<div class="boxnews">
		<p style="margin-left: 5px;">
			<a href="index.php?show=typenews&id=<?php echo $row['MaTheLoai'] ?>">
				<?php $row['TenTheLoai'] ?>
			</a>
		</p>
	</div>
	<div class="content-left" style="width: 100%; margin-top: 10px;">
		<div class="box1">
			<img src="<?php echo $row['HinhAnhMinhHoa'] ?>" width="auto" height="250" />
			<p class="title">
				<a href="index.php?show=detail&id=<?php $row['MaBaiViet'] ?>">
					<?php echo $row['TenBaiViet'] ?>
				</a>
			</p>
			<p class="brief">
				<?php echo $row['TomTat'] ?>
			</p>
		</div>
		<div class="box2 margin">
			<ul>
				<?php
					while ($row = mysqli_fetch_array($topic)) {
				?>
					<img src="<?php echo $row['HinhAnhMinhHoa'] ?>" width="50" height="50" style="float: left;" />
					<li style="list-style:none;">
						<a href="index.php?show=detail&id=<?php echo $row['MaBaiViet'] ?>">
						<?php $row['TieuDe'] ?>
						</a>
					</li>
					<div class="clear"></div>
				<?php
					}
				?>
			</ul>
		</div>
	</div>
	<!-- End CONTENT LEFT -->
	
	<div class="clear"></div>
</div>
<!-- End CONTENT 2 -->
