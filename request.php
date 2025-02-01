<?php include('./header.php'); ?>


<div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header">						
							<h5>Blank Page</h5>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">




                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <div class="col-md-6">
                                        <select id="status" class="form-control" name="status">
                                            <option value="1" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '1') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Material Requirement</option>
                                            <option value="5" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '5') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Confirm Processed</option>
                                            <option value="2" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '2') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Available</option>

                                            <option value="0" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '0') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Cancelled</option>
                                            <option value="3" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '3') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Not Available</option>
                                            <option value="4" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '4') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Dispatched</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" value="Search">
                                    </div>
                                </form>

                                
						</div>			
					</div>
					
				</div>
<?php include('./footer.php'); ?>