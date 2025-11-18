<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Services\CourseServices;
use App\Services\GameServices;
use App\Services\MissionServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private CourseServices $course_services;

    private MissionServices $mission_services;

    private GameServices $game_services;

    public function __construct(CourseServices $coursesvc, MissionServices $missionsvc, GameServices $gamesvc)
    {
        $this->course_services = $coursesvc;
        $this->mission_services = $missionsvc;
        $this->game_services = $gamesvc;
    }

    public function showMission()
    {
        [$mission, $error] = $this->mission_services->GetAllMission();
        [$game, $error] = $this->game_services->GetAllGame();
        $roles = Role::where('title', 'student')->first();
        $data = $this->course_services->GetUserByRole($roles->id);
        $user = $data['data']['users'];

        return view('admin.manage_mission', compact(['mission', 'game', 'user']));
    }
    //

    public function showLevel()
    {
        [$level, $error] = $this->course_services->GetAllLevel();
        $roles = Role::where('title', 'student')->first();
        $data = $this->course_services->GetUserByRole($roles->id);
        $user = $data['data']['users'];

        return view('admin.manage_level', compact(['level', 'user']));
    }

    public function showDashboard()
    {
        $course = $this->course_services->GetAllCourse(10);
        $roles = Role::where('title', 'student')->first();

        $user = $this->course_services->GetUserByRole($roles->id);
        $user = $user['data']['users'];

        return view('admin.dashboard', compact(['course', 'user']));
    }

    public function showSoal()
    {
        $soal = $this->course_services->GetAllSoal(10);
        $roles = Role::where('title', 'student')->first();

        $user = $this->course_services->GetUserByRole($roles->id);
        $user = $user['data']['users'];
        [$level,$error] = $this->course_services->GetAllLevel();

        return view('admin.manage_soal', compact(['soal', 'user', 'level']));
    }

    public function showCourseCategory()
    {
        $roles = Role::where('title', 'student')->first();
        $data = $this->course_services->GetUserByRole($roles->id);
        $user = $data['data']['users'];
        $course_categories = $this->course_services->GetAllCourseCategory(5);

        return view('admin.manage_course_category', compact(['course_categories', 'user']));
    }

    public function deleteCourseCategory($id)
    {
        [$data, $err] = $this->course_services->DeleteCourseCategory($id);
        if ($err['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $err['error']]);
        }

        return redirect()->back()->with(['message' => 'success delete course category']);
    }

    public function showCourse()
    {
        $course = $this->course_services->GetAllCourse(5);
        $categories = $this->course_services->GetAllCourseCategory(1000);
        $roles = Role::where('title', 'student')->first();
        $data = $this->course_services->GetUserByRole($roles->id);
        $user = $data['data']['users'];

        return view('admin.manage_course', compact(['course', 'categories', 'user']));
    }

    public function deleteCourse($id)
    {
        [$data, $err] = $this->course_services->DeleteCourse($id);
        if ($err['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $err['error']]);
        }

        return redirect()->back()->with(['message' => 'success delete course']);
    }

    public function showCourseDetail($id)
    {
        $data = $this->course_services->GetCourseByID($id);
        $data = $data->toArray();
        for ($i = 0; $i < count($data['contents']); $i++) {
            if (! isset($data['contents'][$i]['berkas_pendukung'])) {
                continue;
            }
            for ($o = 0; $o < count($data['contents'][$i]['berkas_pendukung']); $o++) {
                $data['contents'][$i]['berkas_pendukung'][$o]['file_endpoint'] = route('rmc.berkas_pendukung.download', ['berkas_id' => $data['contents'][$i]['berkas_pendukung'][$o]['id']]);
                $data['contents'][$i]['berkas_pendukung'][$o]['delete_endpoint'] = route('rmc.berkas_pendukung.delete', ['berkas_id' => $data['contents'][$i]['berkas_pendukung'][$o]['id']]);
            }
        }
        $data = json_decode(json_encode($data));
        $roles = Role::where('title', 'student')->get();
        $user = $this->course_services->GetUserByRole($roles[0]->id);
        $users = $user['data']['users'];

        return view('admin.course.course_detail', compact(['data', 'users']));
    }

    public function createContent(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'chapter' => 'required|integer',
            'description' => 'required|string',
        ]);

        $data = $this->course_services->CreateContents($request, $id);
        if ($data['is_error']) {
            // dd($data);
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data['data']);
        }
    }

    public function updateContent(Request $request, $id, $content_id)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'chapter' => 'required|integer',
            'description' => 'required|string',
        ]);

        $data = $this->course_services->UpdateContents($request, $content_id);
        if ($data['is_error']) {
            // dd($data);
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data['data']);
        }
    }

    public function deleteContent(Request $request, $id)
    {
        $data = $this->course_services->DeleteContents($id);
        if (isset($data['error'])) {
            return redirect()->back()->withErrors($data);
        }

        return redirect()->back();
    }

    public function createCourse(Request $request)
    {
        // validasi
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'course_categories_id' => 'required|string',
        ]);

        // hit service
        $data = $this->course_services->CreateCourse($request);
        if ($data['is_error']) {
            // dd($data);
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data['data']);
        }
    }

    public function updateCourse($id, Request $request)
    {
        // validasi
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'course_categories_id' => 'required|string',
        ]);

        // hit service
        $data = $this->course_services->UpdateCourse($id,$request);
        if ($data['is_error']) {
            // dd($data);
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data['data']);
        }
    }


    public function createCourseCategory(Request $request)
    {
        // validasi
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        // hit service
        $data = $this->course_services->CreateCourseCategory($validate['title'], $validate['description']);
        if ($data['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data['data']);
        }
    }

    public function updateCourseCategory($id, Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        [$data, $error] = $this->course_services->updateCourseCategory($id, $request);
        if ($error['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back()->with('response', $data);
        }

    }

    public function enrollmentConfirm($course_id, $id)
    {
        $data = $this->course_services->ConfirmEnrollment($id);
        if ($data['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back();
        }
    }

    public function enrollmentDecline($course_id, $id)
    {
        $data = $this->course_services->DeclineEnrollment($id);
        if ($data['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back();
        }
    }

    public function createBerkas($course_id, Request $request)
    {
        $validate = $request->validate([
            'berkas' => 'required',
            'content_id' => 'required',
        ]);

        $data = $this->course_services->CreateBerkas($course_id, $request);
        if ($data['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        } else {
            return redirect()->back();
        }

    }

    public function PointAdjustment(Request $request)
    {
        $validate = $request->validate([
            'tipe' => 'required|string',
            'amount' => 'required|integer',
            'user_id' => 'required|string',
        ]);

        $data = $this->course_services->PointAdjustment($request->user_id, $request->tipe, $request->amount, '');
        if ($data['is_error']) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menambahkan Point',
            ], 500);

        }

        return response()->json([
            'success' => true,
            'message' => $request->tipe == 'debit' ? 'Berhasil Menambah Point' : 'Berhasil Mengurangi Point',
            'data' => $data,
        ], 201);
    }

    public function showProfile()
    {
        $u = Auth::user();
        $profile = User::with(['image', 'role'])->find($u->id);
        $roles = Role::where('title', 'student')->get();
        $user = $this->course_services->GetUserByRole($roles[0]->id);
        $user = $user['data']['users'];

        return view('admin.manage_profile', compact(['profile', 'user']));
    }

    public function updateProfile(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
        ]);

        $u = Auth::user();
        try {
            $user = User::find($u->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if($request->hasFile('foto_profile')){
                $path = $request->file('foto_profile')->store('images', 'public');
                $image = Image::create(['path' => $path]);
                $user->image_id = $image->id;
            }
            $user->save();
        }catch(\Throwable $th){
            $data = [];
            $data['error']['code'] = $th->getCode();
            $data['error']['message'] = "gagal menyimpan perubahan";
            return redirect()->back()->withErrors(['error_details' => $data['error']]);
        }

        return redirect()->back();

    }
}
