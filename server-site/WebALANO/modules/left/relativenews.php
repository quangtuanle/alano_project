<?php
	$sql=  "select * 
			from baiviet, ct_theloaibaiviet, theloai 
			where ct_theloaibaiviet.MaTheLoai = theloai.MaTheLoai and
				  ct_theloaibaiviet.MaBaiViet = baiviet.MaBaiViet and
				  ct_theloaibaiviet.MaTheLoai = '$row[MaTheLoai]' and
				  baiviet.MaBaiViet not in('$_GET[id]')";
	$topic = mysqli_query($connection, $sql);
?>
<p style="color: #960; font-size: 16px; ">Tin liên quan</p>
<ul style="list-style: none; margin-left: 20px;">
	<?php
		while($row=mysqli_fetch_array($topic)){
	?>
	<li style="margin-top: 10px;">
		<a href="index.php?show=detail&id="<?php $row['MaBaiViet'] ?>">
		<?php
			echo $row['TieuDe']
		?>
		</a>
	</li>
	<?php
		}
	?>
</ul>
