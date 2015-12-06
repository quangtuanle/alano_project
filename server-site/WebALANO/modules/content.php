<div class="content">
	<div class="content-left'>
		<?php
			if (isset($_GET['show'])){
				$temp = $_GET['show'];
			}
			else {
				$temp = '';
			}
			
			if ($temp == 'detail'){
				include('modules/left/detailnews.php');
			} 
			else if ($temp == 'typenews'){
				include('modules/left/detailtypenews.php');
			}
			else {
				include('modules/left/newnews.php');
				$sql = "select * from theloai where TrangThai='Hiển thị'";
				$typenews=mysqli_query($connection, $sql);
				while ($row_typenews=mysqli_fetch_array($typenews)){
					include('modules/left/boxnewsa.php');
				}					
			}
		?>
	</div>
	<!-- End CONTENT-LEFT -->
	
	<div class="content-right'>
	
	</div>
	<!-- End CONTENT-RIGHT -->
</div>
<div class="clear"></div>
<!-- End CONTENT 1 -->
