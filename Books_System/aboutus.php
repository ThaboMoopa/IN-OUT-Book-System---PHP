<?php
session_start(); 
define('TITLE', 'About Us');
include("templates/inc_header.html"); 

?>
<div class="text--center">
<p class="text--error" style="font-size:3em">Meet the Team</p>
</div>
<table class="flat-table">
<tbody>
<tr>
	<td class="text--center"><img src="images/thabo.jpg">
	</td>
	<td class="text--center"><img src="images/costa.jpg">
	</td>
	<td class="text--center"><img src="images/asanda.jpg">
	</td>
	<td class="text--center"><img src="images/tanya.jpg">
	</td>
</tr>
<tr>
	<td class="text--center"><p class="text--primary">Thabo Moopa | <span class="text--error"> Head Developer | Designer</span></p></td>
	<td class="text--center"><p class="text--primary">Costa Ludmila | <span class="text--error">Business Analyst | Tester | Developer </span></p></td>
	<td class="text--center"><p class="text--primary">Asanda Mahlungulu | <span class="text--error">Project Manager | Project Leader</span></p></td>
	<td class="text--center"><p class="text--primary">Tanya Williams | <span class="text--error">Business Analyst | Tester</span></p></td>
</tr>
</tbody>
</table>


<?php include("templates/inc_footer.html");?> 