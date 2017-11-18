<?php

namespace App\Http\Controllers;

use App\Teacher;
use Barryvdh\DomPDF\Facade as PDF;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use willvincent\Rateable\Rating;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('dashboard.student');
    }

    public function grades() {
        $divisor = 0;
        $student = Student::with(['grades', 'grades.subject'])->find(auth()->id());
        // return $student;
        return view('dashboard.student.grades', compact('student', 'divisor'));
    }

    public function permit()
    {
        return view('dashboard.student.permit');
    }

    public function teachers()
    {
        $student = Student::with('section.subjects.teacher')->find(auth()->id());
        $vue_rating = true;
        return view('dashboard.student.rate', compact('student', 'vue_rating'));
    }

    public function rate(Request $request)
    {
        Rating::updateOrCreate(
            [
                'rateable_id' => $request->teacherId,
                'rateable_type' => 'App\Teacher',
                'student_id' => auth()->id(),
                'subject_id' => $request->subjectId
            ],

            ['rating' => $request->rating]
        );

        return $request;
    }

    //@todo remove or modify after pdf test
    public function gradesDownload()
    {
        $data = [
            'title' => 'JILCS Registration Form',
            'num' => ['wasd', 'wasder', 'wasdest']
        ];

        $pdf = PDF::loadView('pdf.test', $data);
        return $pdf->stream('invoice.pdf');
    }

}
