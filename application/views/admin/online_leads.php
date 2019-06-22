	<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		$this->load->view('inc/admin_header');
	?>

	<style>
		@media screen and (min-width: 768px) {
			modal_
			.modal-dialog  {
				width:900px;
			}
		}
		.form-group input[type="checkbox"] {
			display: none;
		}
		.form-group input[type="checkbox"] + .btn-group > label span {
			width: 20px;
		}
		.form-group input[type="checkbox"] + .btn-group > label span:first-child {
			display: none;
		}
		.form-group input[type="checkbox"] + .btn-group > label span:last-child {
			display: inline-block;
		}
		.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
			display: inline-block;
		}
		.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
			display: none;
		}
		tr.highlight_past td.due_date{
			background-color: #cc6666 !important;
		}
		tr.highlight_now td.due_date{
			background-color: #e4b13e !important;
		}
		tr.highlight_future td.due_date{
			background-color: #65dc68 !important;
		}
		#history_table td {
			border: 1px solid #aaa;
			padding: 5px
		}
	</style>
	<div class="container">
		<div class="page-header">
			<h1><?= $heading; ?></h1>
		</div>
		<br>
			<table id="example" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Select</th>
						<th>Source</th>
						<th>Contact Name</th>
						<th>Contact No</th>
						<th>Email</th>
						<th>Project</th>
						<th>Lead Id</th>
						<th>Notes</th>
						<th>Date</th>
					</tr>
				</thead>
		<?php //echo $leads->leads->lead[0]->mobile
			$this->load->model('common_model');
			$online_lead_data = $this->common_model->fetch_online_leads();
			$row_count = $this->common_model->count_online_leads();
			$count = $row_count['count(*)'];
			$projects = $this->common_model->all_active_projects();
			//print_r($online_lead_data);
			//echo $online_lead_data[0]->source." online leads";
		
			//$count= $leads->count; 
		
			 if($count>0){
						foreach ($online_lead_data as $data) {
								//echo $data->source."    source";
						if($data->saved!=1){
							
							?>
						
		<form method="post"  action="<?php echo base_url()?>admin/save_online_leads">
		
				<tbody id="table_body">

			
							<tr id="row_count<?= $data->project_id ?>">
								<td><input type='checkbox' name='check[]' class='check' value="<?=$data->id ?>"></td>
								<td><?= $data->source?></td>
								<td><?=$data->name ?></td>
								<td><?= $data->phone ?></td>
								<td><?= $data->email ?></td>
								<td>
									<select name="project_name[]>" required>
										<?php  
									foreach ($projects as $projectdata) {
												?>
											<option value="<?= $projectdata->id ?>"><?=$projectdata->name ?></option>
										<?php } ?>
									</select> 
									<?= $data->project?>
								</td>
								<td><?= $data->leadid ?></td>
								<td><?= $data->notes?></td>
								<td><?= $data->lead_date?></td>
							</tr>
						<?php }
						  }
					}
					
					else{ ?>
							<tr>
								<td colspan='8'>No Leads for Now</td>
							</tr>
					<?php } ?>
			</tbody>
			</table>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="page-header text-center">
						<h1>Default Callback Assignment</h1>
					</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Dept*</label>
							<div class="col-sm-9">
								<select type="email" class="form-control" name="dept" required>
									<?php $all_department=$this->common_model->all_active_departments();
									foreach($all_department as $department){ ?>
										<option value="<?php echo $department->id; ?>"><?php echo $department->name; ?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Callback type*</label>
							<div class="col-sm-9">
								<select type="email" class="form-control" name="callback_type" required>
									<?php $all_callback_types=$this->common_model->all_active_callback_types();
									foreach($all_callback_types as $callback_type){ ?>
										<option value="<?php echo $callback_type->id; ?>"><?php echo $callback_type->name; ?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Assigned to*</label>
							<div class="col-sm-9">
								<select type="email" class="form-control" name="user" required>
									<?php $all_user= $this->user_model->all_users("type in (1,2,3,4)");
									foreach( $all_user as $user){
										switch ($user->type) {
											case '1':
												$role = "User";
												break;

											case '2':
												$role = "Manager";
												break;

											case '3':
												$role = "VP";
												break;

											case '4':
												$role = "Director";
												break;
										} ?>
										<option value="<?php echo $user->id ?>"><?php echo $user->first_name." ".$user->last_name." ($role)"; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Broker*</label>
							<div class="col-sm-9">
								<select type="email" class="form-control" name="broker" required>
									<?php $brokers= $this->common_model->all_active_brokers();
									foreach( $brokers as $broker){ ?>
										<option value="<?php echo $broker->id; ?>"><?php echo $broker->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Status*</label>
							<div class="col-sm-9">
								<select type="email" class="form-control" name="status" required>
									<?php $statuses= $this->common_model->all_active_statuses();
									foreach( $statuses as $status){ ?>
										<option value="<?php echo $status->id; ?>"><?php echo $status->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Due Date*</label>
							<div class="col-sm-9">
								<input type="date" id="dt" class="form-control" name="due_date" required />
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Due Time*</label>
							<div class="col-sm-9">
								<input type="time" id="dt" class="form-control" name="due_time" value="00:00"/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9 col-sm-offset-3">
								<button type="submit" class="btn btn-success btn-block">Save Data</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>


	<script type="text/javascript">

		$(".main-from").submit(function(e){
			e.preventDefault();
			$(".se-pre-con").show();
			var url = $(".main-from").attr('action');
			var formdata = $(".main-from").serialize();
			if($('.check:checked').length == 0){
				alert("You need to select atleast one entry");
				$(".se-pre-con").hide();
				return false;
			}
			/*$.post(url, formdata, function(resp){
				data = JSON.parse(resp);
				$.each(data, function( index, value ){
					$("#row_"+value).remove();
				});
				if($('#table_body tr').length == 0)
					window.location.replace("<?= base_url('admin/callbacks') ?>");
				$(".se-pre-con").hide();
			});*/
		})

		$(document).ready(function() {
			// $('#example').DataTable();
			if (!Modernizr.inputtypes.date) {
				// If not native HTML5 support, fallback to jQuery datePicker
				$('input[type=date]').datepicker({
					// Consistent format with the HTML5 picker
						dateFormat : 'dd/mm/yy'
					}
				);
			}
			if (!Modernizr.inputtypes.time) {
				// If not native HTML5 support, fallback to jQuery timepicker
				$('input[type=time]').timepicker({ 'timeFormat': 'H:i' });
			}

		});
	</script>


	</body>

	</html>