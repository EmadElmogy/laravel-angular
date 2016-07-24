<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mni\FrontYAML\Parser as MarkdownParser;

class DocsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $content = (new MarkdownParser())->parse(
            file_get_contents(resource_path('views/docs/index.md'))
        )->getContent();

        $content = str_replace('{{url}}', url('/'), $content);


        return view('docs.base')->with('content', $content);
    }
}
