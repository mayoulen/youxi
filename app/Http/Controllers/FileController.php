<?php
namespace App\Http\Controllers;

use Cache;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller{

    protected $model;

    public function __construct(Request $request){
        $this->model          = new File;
    }

    public function upload(Request $request){
        try {
            $file = $request->file('file');
            $this->model->classify = $request->input('classify','file');
            $path = 'uploads/'.$this->model->classify.'/'.date("Ymd");
            $md5 = md5_file($file->getRealPath());
            $this->model->original_name = $file->getClientOriginalName();
            $this->model->mime_type     = $file->getMimeType(); 
            $this->model->extension     = $file->getClientOriginalExtension();
            $this->model->size          = $file->getClientSize(); 
            $this->model->md5           = $md5;
            $this->model->name          = md5(date("YmdHis").$md5).'.'.$this->model->extension;
            $this->model->path = $path.'/'.$this->model->name;
            $file->storeAs(
                'public/'.$path,
                $this->model->name
            ); 
            $this->model->save();
            return $this->success($this->model);

        } catch (\Exception $e) {
            return $this->error(100, $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        try{
            $file = $this->model->findOrFail($request->input('id'));

            return response()->download(
                storage_path('app/public/'.$file['path']), 
                $file['name']
            );

        }catch (\Exception $e) {

            return $this->error(100, '未找到资源');
        }
    }

    public function show(Request $request){
        try {

            return $this->success(
                $this->model->findOrFail($id)
            );

        } catch (\Exception $e) {

            return $this->error(100, $e->getMessage());
        }
    }

    public function destroy(Request $request){
        try{
            if(empty($request->input('id'))){
                return $this->error(101, '缺少参数');
            }

            $deleteRow = $this->model->destroy($request->input('id'));

            return $this->success(['affectRow'=>$deleteRow], '删除成功');

        }catch(\Exception $e){
            
            return $this->error(100);
        }
    }
}
