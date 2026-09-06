</div>
<!-- End container -->
</div>
<!-- End Wrap -->

<div id="footer" style="clear:both">
<?php 
		$uc_url = "";
		if(isset($defaultsConfigs)){
			foreach($defaultsConfigs as $default){
				if ($default->default_id == "uc_url")
					$uc_url = $default->value;
					break;
			}
		}
        ?>                        
      <div class="container">
        <p class="text-muted">
		Health4All - a Free and Open Source application supported by <a href=<?php echo $uc_url ?> target="_blank">YouSee</a>
		</p>
      </div>
</div>
</body>
</html>