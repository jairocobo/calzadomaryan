<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_outlets; ?></h1>
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
					
					<div class="row">
						<div class="col-md-12">
							<?php
                                if ($user_role == 1) {
                                    ?>
							<a href="<?=base_url()?>setting/addoutlet" style="text-decoration: none">
								<button class="btn btn-default" style="padding: 0px 12px;"><i class="icono-plus"></i><?php echo $lang_add_new_outlet; ?></button>
							</a>
							<?php

                                }
                            ?>	
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table">
							    <thead>
							    	<tr>
								    	<th width="28%"><?php echo $lang_outlet_name; ?></th>
									    <th width="24%"><?php echo $lang_address; ?></th>
									    <th width="24%"><?php echo $lang_contact_number; ?></th>
									    <th width="12%"><?php echo $lang_status; ?></th>
									    <th width="12%"><?php echo $lang_action; ?></th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                        foreach ($results as $data) {
                                            $id = $data->id;
                                            $name = $data->name;
                                            $address = $data->address;
                                            $contact = $data->contact_number;
                                            $status = $data->status; ?>
											<tr>
												<td>
													<?php echo $name; ?>
												</td>
												<td>
													<?php echo $address; ?>
												</td>
												<td>
													<?php echo $contact; ?>
												</td>
												<td style="font-weight: bold;">
													<?php
                                                        if ($status == '1') {
                                                            echo '<span style="color: #090;">'.$lang_active.'</span>';
                                                        }
                                            if ($status == '0') {
                                                echo '<span style="color: #f9243f;">'.$lang_inactive.'</span>';
                                            } ?>
												</td>
												<td>
													<a href="<?=base_url()?>setting/editoutlet?id=<?php echo $id; ?>" style="text-decoration: none;">
														<button class="btn btn-dark">&nbsp;&nbsp;<?php echo $lang_edit; ?>&nbsp;&nbsp;</button>
													</a>
												</td>
											</tr>
								<?php
                                            unset($id);
                                            unset($name);
                                            unset($address);
                                            unset($contact);
                                            unset($status);
                                        }
                                    } else {
                                        ?>
										<tr class="no-records-found">
											<td colspan="5"><?php echo $lang_no_match_found; ?></td>
										</tr>
								<?php

                                    }
                                ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>