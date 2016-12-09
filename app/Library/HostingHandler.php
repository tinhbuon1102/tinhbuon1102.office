<?php
namespace App\Library;
use App\User1certificate;
use Auth;

class HostingHandler extends UploadHandler {

	public function __construct($options = null, $initialize = true, $error_messages = null) {
		$folderPath = '/certificate/' . Auth::user()->id . '/';
		$options = array();
		$options['script_url'] =  url('/') . '/ShareUser/Dashboard/HostSetting/hostingImages';
		$options['upload_dir'] =  public_path() . $folderPath;
		$options['upload_url'] =  url('/') . $folderPath;
		$options['upload_dir_relative'] =  $folderPath;
		parent::__construct($options, $initialize, $error_messages);
	}

	protected function handle_form_data($file, $index) {
		$file->title = @$_REQUEST['title'][$index];
		$file->description = @$_REQUEST['description'][$index];
	}

	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
		$file = parent::handle_file_upload( $uploaded_file, $name, $size, $type, $error, $index, $content_range);
		if (empty($file->error)) {
			$cert=new User1certificate();
			$cert->User1ID=Auth::user()->id;
			$cert->HashID=uniqid();
			$cert->Path= $this->options['upload_dir_relative'] . $file->name;
			$cert->save();
		}
		return $file;
	}

	protected function set_additional_file_properties($file) {
		parent::set_additional_file_properties($file);
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$filepath = $this->options['upload_dir_relative'] . $file->name;
			$cert=new User1certificate();
			$result = $cert->where('Path', '=', $filepath)->first();
			
			if ($result) {
				$file->id = $result->id;
				$file->type = pathinfo($filepath, PATHINFO_EXTENSION);
				$file->thumbnailUrl = '';
				$file->title = $result->title;
				$file->description = '';
			}else {
				$file = null;
			}
		}
	}

	public function delete($print_response = true) {
		$response = parent::delete(false);
		foreach ($response as $name => $deleted) {
			if ($deleted) {
				$filepath = $this->options['upload_dir_relative'] . $name;
				$cert=new User1certificate();
				$file = $cert->where('Path', '=', $filepath)->first();
				if ($file)
					$file->delete();
			}
		}
		return $this->generate_response($response, $print_response);
	}

}