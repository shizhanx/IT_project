<?php $this->output->set_content_type('application/json');
	echo json_encode(array('error'=>$error_msg));
