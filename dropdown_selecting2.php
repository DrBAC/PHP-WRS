<select>
   <?php foreach ($row as $key => $value) {?>        
   <option value="">-Select-</option>
   <option value="samsung" <?php if($value == 'samsung') {echo"selected";}>>samsung</option>
   <option value="sony" <?php if($value == 'sony'){echo "selected";}?>>sony</option>
   <option value="lg" <?php if($value == 'lg'){echo "selected";}?>>lg</option>
   <?php } ?>
</select>
	