<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<br/>
				<?php
					$tmpid = $this->session->userdata('userid');
					$queryparent = $this->db->query("SELECT * FROM f_menuauth
									INNER JOIN f_sidemenu ON f_menuauth.idmenu = f_sidemenu.idmenu
									INNER JOIN f_lvlauth ON f_menuauth.lvlauth = f_lvlauth.id_lvlauth
									INNER JOIN user ON f_lvlauth.id_lvlauth = user.lvl_auth
									WHERE f_sidemenu.isParent = 'Y' AND f_sidemenu.active ='Y' AND user.userid = '$tmpid'
									ORDER BY f_sidemenu.order");
					
					$querychild = $this->db->query("SELECT * FROM f_menuauth
									INNER JOIN f_sidemenu ON f_menuauth.idmenu = f_sidemenu.idmenu
									INNER JOIN f_lvlauth ON f_menuauth.lvlauth = f_lvlauth.id_lvlauth
									INNER JOIN user ON f_lvlauth.id_lvlauth = user.lvl_auth
									WHERE f_sidemenu.isParent = 'N' AND f_sidemenu.active ='Y' AND user.userid = '$tmpid'
									ORDER BY f_sidemenu.order");
					$i = 1;
					foreach ($queryparent->result_array() as $row)
					{
						if($this->session->userdata('selectedmenu') == $row['idmenu'])
						{
							if($i == 1){
								echo '<li class="start active">';	
							}
							else{
								echo '<li class="active has-sub">';
							}
							
						}
						else{
							if($i == 1){
								echo '<li class="start">';
							}
							else{
								echo '<li class="has-sub">';
							}
							
						}
						
						if($i == 1){
							echo "<a href=\"".base_url()."\">";
						}
						else{
							echo "<a href=\"".$row['link']."\">";
						}
						
						echo "<i class=\"".$row['icon']."\"></i>";
						echo "<span class=\"title\">".$row['name']."</span>";
						
						if($this->session->userdata('selectedmenu') == $row['idmenu'])
						{
							echo '<span class="selected"></span>';
						}
						
						echo "</a>";
						echo '<ul class="sub">';
						foreach ($querychild->result_array() as $rowchild)
						{
							if($rowchild['parent'] == $row['idmenu']){
							echo "<li><a href=\"".base_url().$rowchild['link']."\">".$rowchild['name']."</a></li>";
							}
						}
						echo '</ul></li>';
						$i++;
					}
					
				?>
					
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->