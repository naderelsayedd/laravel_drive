<?php
namespace App\Http\Controllers;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriveController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drive = DB::table('userdrives')->get()->where('stat', 'public');
        return view('drives.index' , compact('drive'));
    }

    public function allFiles(){
        $drive = Drive::all();
        return view('drives.allFiles'  ,compact('drive'));
    }

    public function UserFiles ()
    {
        $id = auth()->user()->id ;
        $drive = Drive::all()->where("userid" , $id);

        return view("drives.yourFiles" , compact('drive'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = DB::table('categories')->get();
        return view('drives.create' , compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $drive->userid = auth()->user()->id ;
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

        return redirect()->route('drive.index')->with("done" , "File Uploaded");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drive =Drive::find($id);
        return view('drives.show' , compact('drive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $drive = DB::table('drivesandcategories')->where("driveId" , $id)->first();
        $category = DB::table('categories')->get();
        return view('drives.edit', compact('drive','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $drive = Drive::find($id);
        $drive->title = $request->title ;
        $drive->description= $request->desc ;
        $drive->userid = auth()->user()->id ;
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
        return redirect()->route('drive.index')->with("done" , "Drive Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $delete = Drive::find($id);
        $delete->delete();
        return redirect()->route('drive.index')->with("done" , "Drive Deleted");
    }

    public function download($id){
        $allData = Drive::where("id" , $id)->first();
        $driveName = $allData->file;
        $filePath = public_path("upload/drive/".$driveName);

        return response()->download($filePath);
    }

    public function changeStatus($id){
        $drive = Drive::find($id) ;
        if($drive->status == 'private'){
            $drive->status = 'public';
            $drive->save();
        }else{
            $drive->status = 'private';
            $drive->save();
        }

    return redirect()->route('drive.userfiles')->with('done' , 'Status Changed') ;
    }
}
