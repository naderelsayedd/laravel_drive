<?php

namespace App\Http\Controllers\API;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use function PHPUnit\Framework\isEmpty;

class DriveController extends Controller
{
    public function listUserFiles($id){
        $userid = $id ;
        $drives =Drive::where("userid" , $userid);
        if($drives == null){
            $response = [
                "message" =>"no dada found" ,
                "status" =>404
            ];
        }else{
            $response = [
                "message" =>"all use drives ",
                "status" =>200,
                "allData" =>$drives
            ];
        }

        return response($response , 200);
    }
    public function index(){
        $drives = DB::table('userdrives')->where("stat" , "public")->get();
        if($drives->isEmpty()){
            $response = [
                "message" =>"no dada found" ,
                "status" =>404
            ];
        }else{
            $response = [
                "message" =>"all public drives ",
                "status" =>200,
                "allData" =>$drives
            ];
        }
        return response($response , 200);
    }

    public function changeStatus($id){
        $drive = Drive::find($id) ;
        if($drive->status == 'private'){
            $drive->status = 'public';
            $drive->save();
            return ["message" =>"status changed to public"];
        }else{
            $drive->status = 'private';
            $drive->save();
            return ["message" =>"status changed to public"];
        }
    }

    public function store(Request $request , $userid)
    {
        $size = 2 * 1024 ;
        $request->validate([
            "title" =>"required|string|min:3",
            "desc"=>"required|string",
            "category" =>"required",
            "file" =>"required|file|max:$size|mimes:png,jpg,pdf"
        ]);
        $drive = new Drive();
        $drive->title = $request->title ;
        $drive->description= $request->desc ;
        $drive->userid =  $userid ;
        // file data
        $drive_data = $request->file("file");

        $drive_name =time() . $drive_data->getClientOriginalName();
        $extensionData = $drive_data->getClientOriginalExtension();
        $location  = public_path('./upload/drive');
        $drive_data->move($location , $drive_name);

        // upload
        $drive->file = $drive_name ;
        $drive->categoryID	 = $request->category ;
        $drive->extension = $extensionData;
        $drive->save();

        $response = [
            "message" => "file uploded ",
            "status" =>201
        ];

        return response($response , 201);
    }

    public function show($id)
    {
        $drive =Drive::find($id);

        if($drive== null){
            $response = [
                "message" => "drive not found" ,
                "status" => 404
            ];
        }else{
            $response = [
                "message" =>"All this drive data",
                "status" =>200 ,
                "allData" =>$drive
            ];
        }
        return response($response , 200);
    }

    public function allFiles(){
        $drive = Drive::all();
        if($drive->isEmpty()){
            $response = [
                "message" =>"no dada found" ,
                "status" =>404
            ];
        }else{
            $response = [
                "message" =>"all public drives ",
                "status" =>200,
                "allData" =>$drive
            ];
        }
        return response($response , 200);
    }

    public function update(Request $request,  $id , $userid)
    {
        $drive = Drive::find($id);
        $drive->title = $request->title ;
        $drive->description= $request->desc ;
        $drive->userid =$userid ;
        // file data
        $drive_data = $request->file("file");
        $oldFile = public_path('upload/drive/' .$drive->file);
        if($drive_data == null){
            $drive_name=$drive->file ;
            $extensionData  =$drive->extension;
        }else{
            $drive_name =time() . $drive_data->getClientOriginalName();
            $extensionData = $drive_data->getClientOriginalExtension();
            $location  = public_path('./upload/drive');
            $drive_data->move($location , $drive_name);
            unlink($oldFile);
        }
        // upload
        $drive->file = $drive_name ;
        $drive->categoryID	 = $request->category ;
        $drive->extension = $extensionData;
        $drive->save();

        $response = [
            "message" =>"drive updated",
            "status" =>201,
            "data" =>$drive
        ];

        return response($response , 201);
    }

    public function destroy($id)
    {

        $delete = Drive::find($id);
        $delete->delete();

        $response = [
            "message" =>"drive deleted" ,
            "status" =>201
        ];
    }

    public function download($id){
        $allData = Drive::where("id" , $id)->first();
        $driveName = $allData->file;
        $filePath = public_path("upload/drive/".$driveName);


        $reposnse = [
            "message" =>"drive dpwnloaded",
            "status" =>201 ,
            "data" =>$driveName
        ];
        return response($reposnse , 201)->download($filePath);
    }

}
