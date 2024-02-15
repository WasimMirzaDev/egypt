<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{

    public function managePages()
    {
        $pdata = Page::where('template_name', $this->activeTemplate)->get();
        $pageTitle = 'Manage Pages';
        return view('admin.frontend.builder.pages', compact('pageTitle', 'pdata'));
    }

    public function managePagesSave(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => ['required', 'min:3', 'string', 'max:500', 'unique:pages'],
        ]);

        $page = new Page();
        $page->template_name = $this->activeTemplate;
        $page->name = $request->name;
        $page->slug = $request->slug;
        $page->save();
        $notify[] = ['success', 'New page added successfully'];
        return back()->withNotify($notify);
    }

    public function managePagesUpdate(Request $request)
    {
        $page = Page::where('id', $request->id)->firstOrFail();
        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => ['required', 'min:3', 'string', 'max:500', 'unique:pages,slug,' . $page->id],
        ]);

        $page->name = $request->name;
        $page->slug = $request->slug;
        $page->save();

        $notify[] = ['success', 'Page updated successfully'];
        return back()->withNotify($notify);
    }

    public function managePagesDelete($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        $page->delete();
        $notify[] = ['success', 'Page deleted successfully'];
        return back()->withNotify($notify);
    }

    public function manageSection($id)
    {
        $pdata = Page::findOrFail($id);
        $pageTitle = 'Manage Section of ' . $pdata->name;
        $sections = getPageSections(true);
        return view('admin.frontend.builder.index', compact('pageTitle', 'pdata', 'sections'));
    }

    public function manageSectionUpdate($id, Request $request)
    {
        $request->validate([
            'secs' => 'nullable|array',
        ]);

        $page = Page::findOrFail($id);
        if (!$request->secs) {
            $page->secs = null;
        } else {
            $page->secs = json_encode($request->secs);
        }

        // Encode the slug using base64
        $page->slug = base64_encode($request->slug);

        $page->save();
        $notify[] = ['success', 'Page sections updated successfully'];
        return back()->withNotify($notify);
    }
}
