<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roadmap;
use App\Models\Category;
use Validator;

class RoadmapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $roadmaps = Roadmap::query();
            
            if ($request->filled('search')) {
                $roadmaps->where('title', 'like', '%' . $request->search . '%');
            }
            $perPage = $request->input('per_page', 10);

            $roadmaps = $roadmaps->orderByDesc('id')
                ->paginate($perPage)
                ->appends($request->query());

            return view('admin.roadmaps.index', compact('roadmaps'));
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
     {
         try {
            $categories = Category::where('status', 1)->get();

            return view('admin.roadmaps.create', compact( 'categories'));
         } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
         }
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required|string|max:255',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        try {
            $roadmap = new Roadmap();
            $roadmap->title = $request->title;
            $roadmap->description = $request->description;
            $roadmap->status = $request->status;
            $roadmap->category = $request->category;
            $roadmap->save();

            return response()->json(['status' => 1, 'success' => 'Roadmap created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 2, 'success' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $roadmap = Roadmap::findOrFail($id);

            $categories = Category::where('status', 1)
                                    ->orWhere('name', $roadmap->category)
                                    ->get();

            return view('admin.roadmaps.edit', compact('roadmap', 'categories'));
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required|string|max:255',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        try {
            $roadmap = Roadmap::findOrFail($id);
            $roadmap->title = $request->title;
            $roadmap->description = $request->description;
            $roadmap->status = $request->status;
            $roadmap->category = $request->category;
            $roadmap->save();

            return response()->json(['status' => 1, 'success' => 'Roadmap updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 2, 'success' => 'Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $roadmap = Roadmap::findOrFail($id);
            $roadmap->delete();

            session()->flash('success', 'Roadmap deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
