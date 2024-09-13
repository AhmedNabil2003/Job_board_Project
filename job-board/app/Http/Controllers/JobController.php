<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Category;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // عرض قائمة الوظائف
    public function index()
    {
        ini_set('max_execution_time', 3600);
        $jobs = JobListing::with('category')->get(); // استخدام with لتحميل العلاقات
        return view('jobs.index', compact('jobs'));
    }

    // عرض تفاصيل وظيفة معينة
    public function details($id)
    {
        $job = JobListing::findOrFail($id);
        return view('jobs.details', compact('job'));
    }

    // عرض نموذج لإنشاء وظيفة جديدة
    public function create()
    {
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }

    // تخزين وظيفة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'application_deadline' => 'nullable|date',
            'status' => 'required|string|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        JobListing::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    // عرض نموذج لتعديل وظيفة معينة
    public function edit($id)
    {
        $job = JobListing::findOrFail($id);
        $categories = Category::all();
        return view('jobs.edit', compact('job', 'categories'));
    }

    // تحديث وظيفة معينة
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'application_deadline' => 'nullable|date',
            'status' => 'required|string|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $job = JobListing::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    // حذف وظيفة معينة
    public function destroy($id)
    {
        $job = JobListing::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }
}
