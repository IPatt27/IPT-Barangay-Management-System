<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Committee;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    // Hardcoded 8 committees
    private $committees = [
        'peace-and-order'  => ['name' => 'Committee on Peace and Order',   'chair' => 'Kap Mikha Lim', 'icon' => 'fa-shield-halved'],
        'health'           => ['name' => 'Committee on Health',             'chair' => 'Kgd Doc Twinkle', 'icon' => 'fa-heart-pulse'],
        'education'        => ['name' => 'Committee on Education',          'chair' => 'Kgd Fred Sicat', 'icon' => 'fa-graduation-cap'],
        'infrastructure'   => ['name' => 'Committee on Infrastructure',     'chair' => 'Kgd Euler', 'icon' => 'fa-hard-hat'],
        'environment'      => ['name' => 'Committee on Environment',        'chair' => 'Kgd Medel', 'icon' => 'fa-tree'],
        'livelihood'       => ['name' => 'Committee on Livelihood',         'chair' => 'Kgd Fred', 'icon' => 'fa-briefcase'],
        'transport'        => ['name' => 'Committee on Transport and Communication', 'chair' => 'Kgd Bem', 'icon' => 'fa-truck'],
        'bdrrm'            => ['name' => 'Committee on BDRRM',              'chair' => 'Kgd Joel', 'icon' => 'fa-triangle-exclamation'],
    ];

    public function index()
    {
        return view('committee.index', ['committees' => $this->committees]);
    }

    public function show($slug)
    {
        if (!array_key_exists($slug, $this->committees)) {
            abort(404);
        }

        $committee = $this->committees[$slug];
        $records = Committee::where('committee_slug', $slug)->get()->groupBy('type');

        return view('committee.view', compact('slug', 'committee', 'records'));
    }

    public function upload(Request $request, $slug)
    {
        $path = $request->file('file')->store('committee/' . $slug, 'public');

        Committee::create([
            'committee_slug' => $slug,
            'type'           => $request->type,
            'title'          => $request->title,
            'file_path'      => $path,
            'description'    => $request->description,
        ]);

        return redirect()->back()->with('success', 'Uploaded successfully!');
    }
        public function deleteRecord($slug, $id)
    {
        $record = Committee::findOrFail($id);
        Storage::disk('public')->delete($record->file_path);
        $record->delete();
        return redirect()->back()->with('success', 'Deleted successfully!');
    }

    public function updateRecord(Request $request, $slug, $id)
    {
        $record = Committee::findOrFail($id);
        $record->title       = $request->title;
        $record->description = $request->description;

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($record->file_path);
            $record->file_path = $request->file('file')->store('committee/' . $slug, 'public');
        }

        $record->save();
        return redirect()->back()->with('success', 'Updated successfully!');
    }
}