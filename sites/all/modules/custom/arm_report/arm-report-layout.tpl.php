<?php
/**
 * @file arm-report.tpl.php
 * Default simple template for displaying an ARM report
 *
 * - $selections contains a nested array of data from selections on vbo form
 */
?>
<?php 
	define('IMG_PATH', '/sites/default/files/'); 
	define('NUM_COLS', 2);
	global $base_url;
	
?>
<?php 
	//$options = array('media'=>'all');
	drupal_add_css(drupal_get_path('module', 'arm_report') . '/arm_report.css', array('media'=>'all'));
	drupal_add_css(drupal_get_path('module', 'arm_report') . '/arm_print.css', array('media'=>'print'));
?>
<div class="arm_report">
	<div class="pdfexport webonly">
		To create a PDF, use Google Chrome and select File -> Print. Under the "Destination" heading, click the "Change..." button and select "Save as PDF" under the "Local Destinations" heading. Then click "Save" and your PDF will download. 
	</div>
	<h1 class="printonly">ARM Observation Report</h1>
	<div id="comment_area" class="comment_area">
		<h2 class="webonly">Additional comments</h2>
		<label id="comment_label" for="additional_comments">Additional comments</label>
		<textarea id="comment_box" class="comment_box" name="additional_comments" cols="30" rows="8"></textarea>
		<br />
		<!--<input class="form-submit arm_button" id="submit_comment" type="submit" value="Add comment" />-->
		<div class="back_pdf_buttons">
			<input class="form-submit arm_button" id="back" type="submit" value="Back" />
			<!--<input class="form-submit arm_button" id="create_report" type="submit" value="Create PDF report" />-->
		</div>
	</div>
		<h2>Selected observations</h2>
		<?php foreach($selections as $selection) : ?>
		<div class="observation">
		<table>
			<tbody>
			<tr>
			<td class="arm_img">
			<img alt="" src="<?php echo IMG_PATH . $selection['photo']; ?>" />
			</td>
			<td>
			<table class="arm_data">
				<tbody>
			<?php
				$count = 0;
				foreach($selection as $key => $value) {
					switch($key) {
						case 'task_performed':
						case 'observation':
						case 'recommendation':
			 ?>
				<tr>
				<?php if(!empty($value)) : ?>
				<td colspan="2"><strong><?php echo $labels[$key]; ?></strong><br />
					<?php echo $value; ?>
				</td>
				</tr>
				<?php endif; ?>
			<?php
						break;
					case 'photo':
						break;
					default:
							echo "<tr>";
							echo "<td><strong>" . $labels[$key] . ":</strong> " . $value . "</td>";
							echo "</tr>";
						/*
						if($count == 0) {
							echo "<tr>";
							echo "<td><strong>" . $count .  " " . $labels[$key] . "</strong><br />" . $value . "</td>";
							$count++;
						}
						else if($count == NUM_COLS) {
							echo "</tr>";
							$count = 0;
						}
						else {
							echo "<td><strong>" . $count .  " "  . $labels[$key] . "</strong><br />" . $value . "</td>";
							$count++;
						}
						 */
					}// switch
				}// foreach selection hash table
			?>
			</tbody>
		</table>
		</td>
</tr>
</tbody>
</table>
		</div>
		<?php endforeach; // foreach selections array?>
</div>
<script>
  (function($){
		var back = $('#back');
		back.click(function(){ 
			window.history.go(-1);
		});
	})(jQuery);

/*
  (function(){
		var page = jQuery('.arm_report')[0];
		var doc = new jsPDF('p', 'in', 'letter');
		var handlers = {'#editor':function(element, renderer){return true;}};
		doc.fromHTML(page, 0.5, 0.5, {'width':7.5, 'elementHandlers':handlers});
		doc.save('doc.pdf');
	})();
 */
</script>
