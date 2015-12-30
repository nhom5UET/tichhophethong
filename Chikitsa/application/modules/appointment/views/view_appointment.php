<?php
	if(isset($doctor)){
		$doctor_name = $doctor['name'];
		$doctor_id = $doctor['userid'];
	}
	if(isset($appointment)){
		//Edit Appointment
		$header = $this->lang->line("edit")." ".$this->lang->line("appointment");
		$patient_name = $patient['first_name'] . " " . $patient['middle_name'] . " " . $patient['last_name'];
		$title = $appointment['title'];
		$appointment_id = $appointment['appointment_id'];
		$start_time = $appointment['start_time'];
		$end_time = $appointment['end_time'];
		$appointment_date = $appointment['appointment_date'];
		$status = $appointment['status'];
		$appointment_id = $appointment['appointment_id'];
	}else{
		//Add Appointment
		$header = $this->lang->line("new")." ".$this->lang->line("appointment");
		$patient_name = "";
		$title = "";
		$time_interval =  $time_interval*60;
		$start_time = date($def_timeformate, strtotime($appointment_time));
		$end_time = date($def_timeformate, strtotime("+$time_interval minutes", strtotime($appointment_time))); 
		
		$appointment_date = $appointment_date;
		$status = "Appointments";
	}
	$total = ($particular_total + $fees_total + $treatment_total + $item_total) - ((-1)*($balance));
?>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Appointment Details
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label>Patient Name:</label>
								<span><?=$patient['first_name'].' '.$patient['middle_name'] .' '.$patient['last_name'];?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Doctor Name:</label>
								<span><?=$doctor['name'];?></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label>Visit Date:</label>
								<span><?=date($def_dateformate,strtotime($visit['visit_date']));?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Visit Time:</label>
								<span><?=date($def_timeformate,strtotime($visit['visit_time']));?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Visit Type:</label>
								<span><?=$visit['type'];?></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes:</label>
								<span><?=$visit['notes'];?></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
							<label>Bill Details</label>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Bill ID:</label>
								<span><?=$bill['bill_id'];?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Bill Date:</label>
								<span><?=date($def_dateformate,strtotime($bill['bill_date']));?></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="bill_table">
									<thead>
										<tr>
											<th><span style="color:black;">Particular</span></th>
											<th>Quantity</th>
											<th>M.R.P.</th>
											<th>Amount</th>
										</tr>									
									</thead>
									<tbody>
										<?php if ($bill_details != NULL) {  ?>
											<?php $current_type=''; ?>
											<?php foreach($bill_details as $bill_detail){ ?>
											<?php 	if ($current_type=='') { ?>
											<?php		$current_type=$bill_detail['type']; ?>
											<?php	}elseif($current_type <> $bill_detail['type']){  ?>
											<tr>
												<?php if($current_type == "fees"){ ?>
													<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
													<th style="text-align:right;"><?=currency_format($fees_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												<?php }elseif($current_type == "item"){ ?>
													<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
													<th style="text-align:right;"><?=currency_format($item_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												<?php }elseif($current_type == "particular"){ ?>
													<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
													<th style="text-align:right;"><?=currency_format($particular_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												<?php }elseif($current_type == "treatment"){ ?>
													<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
													<th style="text-align:right;"><?=currency_format($treatment_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												<?php }elseif($current_type == "disount"){ ?>
													<!-- Do Nothing -->
												<?php } ?>
											</tr>
											<?php
												$current_type=$bill_detail['type'];
											}
											?>
											<?php if($current_type != "discount"){ ?>	
												<tr <?php if ($i % 2 == 0) { echo "class='alt'";} ?> >
													<td><?php echo $bill_detail['particular'] ?></td>						
													<td style="text-align:right;"><?php echo $bill_detail['quantity'] ?></td>
													<td style="text-align:right;"><?php echo currency_format($bill_detail['mrp']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
													<td style="text-align:right;"><?php echo currency_format($bill_detail['amount']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
												</tr>
												<?php } ?>
											<?php $i++; ?>
											<?php } ?>
										<?php if($current_type == "fees"){ ?>
												<tr>
												<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
												<th style="text-align:right;"><?=currency_format($fees_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												</tr>
											<?php }elseif($current_type == "item"){ ?>
												<tr>
												<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
												<th style="text-align:right;"><?=currency_format($item_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												</tr>
											<?php }elseif($current_type == "particular"){ ?>
												<tr>
												<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
												<th style="text-align:right;"><?=currency_format($particular_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												</tr>
											<?php }elseif($current_type == "treatment"){ ?>
												<tr>
												<th style="text-align:left;" colspan="3"><?php echo $this->lang->line('sub_total');?> - <?php echo $this->lang->line($current_type);?></th>
												<th style="text-align:right;"><?=currency_format($treatment_total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
												</tr>
											<?php }elseif($current_type == "discount"){ ?>
												<!-- Do Nothing -->
											<?php } ?>
											<tr class='total'>
												<th style="text-align:left;" colspan="3" ><?php echo $this->lang->line("total");?></th>
												<th style="text-align:right;"><?= currency_format($total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
											</tr>
											<tr>
												<th style="text-align: left;" colspan="3" >Discount</th>
												<th style="text-align: right;"><?= currency_format($discount);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
											</tr>
											<tr>
												<th style="text-align: left;" colspan="3" >To Be Paid</th>
												<th style="text-align: right;"><?= currency_format($total - $discount);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
											</tr>
											<tr>
												<th style="text-align: left;" colspan="3" >Amount Paid</th>
												<th style="text-align: right;"><?= currency_format($paid_amount);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>