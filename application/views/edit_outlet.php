<?php
    require_once 'includes/header.php';

    $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$id");

    if (count($outletData) == 0) {
        redirect(base_url());
    }

    $outlet_name = $outletData[0]->name;
    $outlet_address = $outletData[0]->address;
    $outlet_contact = $outletData[0]->contact_number;
    $outlet_header = $outletData[0]->receipt_header;
    $outlet_footer = $outletData[0]->receipt_footer;
?>
<script type="text/javascript" src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<!-- <script type="text/javascript" src="<?=base_url()?>assets/ckfinder/ckfinder.js"></script> -->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_edit_outlet; ?> : <?php echo $outlet_name; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
                    
                    <?php
                        if ($user_role == 1) {
                            ?>
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<form action="<?=base_url()?>setting/deleteOutlet" method="post" onsubmit="return confirm('Esta seguro de eliminar?')">
								<input type="hidden" name="outlet_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="outlet_name" value="<?php echo $outlet_name; ?>" />
								<button type="submit" class="btn btn-dark" style="border: 0px; background-color: #c72a25;">
									<?php echo $lang_delete_outlet; ?>
								</button>
							</form>
						</div>
					</div>
					<?php

                        }
                    ?>
                    
					
	<form action="<?=base_url()?>setting/updateOutlet" method="post">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo $lang_outlet_name; ?> <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_name" class="form-control" maxlength="499" autofocus required autocomplete="off" value="<?php echo $outlet_name; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo $lang_contact_number; ?> <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_contact" class="form-control" maxlength="30" required autocomplete="off" value="<?php echo $outlet_contact; ?>" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><?php echo $lang_address; ?> <span style="color: #F00">*</span></label>
								<textarea class="form-control" name="outlet_address" rows="5" required><?php echo $outlet_address; ?></textarea>
							</div>
						</div>
					</div>
										
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo $lang_receipt_footer; ?> <span style="color: #F00">*</span></label>
								<?php
                                    echo $this->ckeditor->editor('receipt_footer', "$outlet_footer");
                                ?>
							</div>
						</div>
						<div class="col-md-6">
							
						</div>
					</div>
										
					<?php
                        if ($user_role == 1) {
                            ?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button class="btn btn-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang_update; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					<?php

                        }
                    ?>
	</form>				
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>setting/outlets" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i><?php echo $lang_back; ?>
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>