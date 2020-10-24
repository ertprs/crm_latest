							<form  action="<?php echo base_url('notebooks/updatenote') ?>" method="post" enctype="multipart/form-data">
                        	 <input type="hidden" name="noteid" class="form-control"  value="<?php echo  $editnotebooks->notebook_id;?>">
						 <div class="panel panel-info">
						<div class="panel-body">
							<div class="row mb50" id="example2">
								<div class="col-sm-4">
									<label>Notebooks</label>
                                       <div class="input-group">
		    								<input type="text" name="notebook" class="form-control" placeholder="Notebooks" value="<?php echo  $editnotebooks->notebook_list;?>">
		    								<div class="input-group-btn btn btn-warning input_Data">
			      								<i class="fa fa-edit "></i>
			    							</div>
			  							</div>
									
								</div>
							</div>
							<input type="hidden" class="tab_lenght" value="2">
							<ul class="nav nav-tabs " id="myTab" role="tablist">
					            <li class="nav-item active" id="mytab1">
					                <a class="nav-link row" id="tab-1" data-toggle="tab" href="#notestab-1" role="tab" aria-controls="One" aria-selected="true">
					                    <span class=col-md-10><input type="text" name="notes_title[]" class="page_input" value="<?php echo  $editnotebooks->notes_title;?>"></span> 
					                    <span class="col-md-2 close_icons" style="display: none;"><i class="fa fa-close"></i></span></a>
					            </li>
					           
					            <li class="btn-li">
					                <a class="btn btn-success btn-xs tab_btn"  href="javascript:void(0)"><i class="fa fa-plus"></i></a>
					            </li>
					            
					          </ul>

					          <div class="tab-content" id="myTabContent">
						        <div class="tab-pane active p-3" id="notestab-1" role="tabpanel" aria-labelledby="tab-1">

						               <div class="row" >
							            <div class="col-lg-8 mb10">
										<label>Notes</label>
										<textarea type="text" class="form-control notes_description" placeholder="Notes" name="notes_description[]" id="notes_description_1" row="5"><?php echo $editnotebooks->notes_description;?></textarea>
										</div>							
										</div>
										<div class="row" >
										<div class="col-lg-4 mb10">
										<label>Upload Files</label>
										<input type="file" class="form-control upload_file" id="upload_file" name="upload_file[0][]" multiple="" >
										<input type="hidden" name="fileid" class="form-control"  value="<?php echo  $editnotebooks->notebook_files_id;?>">
									
											</div>
										</div>		        
						          </div>
							  </div>
					    </div>
					</div>
                    <div class="col-md-4">
                      <input type="submit" name="submit" id="submit" value="Update" class="btn btn-primary col-md-4" >
                     </div>
                      </form>