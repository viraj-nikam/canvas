<?php
namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Show page of files / subfolders
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('backend.upload.index', $data);
    }

    /**
     * Create a new folder
     *
     * @param UploadNewFolderRequest $request
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder') . '/' . $new_folder;
        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            Session::set('_new-folder', 'New folder has been created.');
            return redirect()->back();
        } else {
            $error = $result ?: "An error occurred creating directory.";
            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Delete a folder
     *
     * @param Request $request
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder') . '/' . $del_folder;
        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            Session::set('_delete-folder', 'Folder has been deleted.');
            return redirect()->back();
        } else {
            $error = $result ?: "An error occurred deleting directory.";
            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Upload new file
     *
     * @param UploadFileRequest $request
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);
        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            Session::set('_new-file', 'New file has been uploaded.');
            return redirect()->back();
        } else {
            $error = $result ?: "An error occurred uploading file.";
            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Delete a file
     *
     * @param Request $request
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder') . '/' . $del_file;
        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            Session::set('_delete-file', 'File has been deleted.');
            return redirect()->back();
        } else {
            $error = $result ?: "An error occurred deleting file.";
            return redirect()->back()->withErrors([$error]);
        }
    }
}
