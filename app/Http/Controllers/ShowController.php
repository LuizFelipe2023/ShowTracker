<?php

namespace App\Http\Controllers;

use App\Actions\Shows\DeleteShow;
use App\Actions\Shows\GetShows;
use App\Actions\Shows\StoreShow;
use App\Actions\Shows\UpdateShow;
use App\Http\Requests\InsertShowRequest;
use App\Models\Genre;
use App\Models\Show;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowController extends Controller
{
    public function index(GetShows $action, Request $request)
    {
        $shows = $action->execute($request->all());

        return Inertia::render('Shows/Index', [
            'shows' => $shows,
            'filters' => $request->only(['status', 'order_by']),
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return Inertia::render('Shows/Create', [
            'genres' => $genres,
        ]);
    }

    public function store(InsertShowRequest $request, StoreShow $action)
    {
        $data = $request->validated();
        $action->execute($data);

        return redirect()
            ->route('shows.index')
            ->with('success', 'Show created successfully!');
    }

    public function show(Show $show)
    {
        return Inertia::render('Shows/Show', [
            'show' => $show->load('genres'),
        ]);
    }

    public function edit(Show $show)
    {
        return Inertia::render('Shows/Edit', [
            'show' => $show->load('genres'),
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function update(InsertShowRequest $request, Show $show, UpdateShow $action)
    {
        $data = $request->validated();
        $action->execute($show, $data);

        return redirect()
            ->route('shows.index')
            ->with('success', 'Show updated!');
    }

    public function destroy(Show $show, DeleteShow $action)
    {
        $action->execute($show);

        return redirect()
            ->route('shows.index')
            ->with('success', 'Show deleted!');
    }
}
