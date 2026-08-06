<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\Events\{StoreEventRequest, UpdateEventRequest};
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};
use Illuminate\Http\Request;
class EventController extends Controller implements HasMiddleware
{
    public function __construct(public ImageServiceV2 $imageServiceV2, public string $templateSertifikatPath = 'template-sertifikats', public string $posterPath = 'posters', public string $disk = 'public')
    {
        //
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:event view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:event create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:event edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:event delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $events = Event::query();

            return Datatables::of(source: $events)

                ->addColumn(name: 'action', content: 'events.include.action')
                ->toJson();
        }

        return view(view: 'events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(view: 'events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['template_sertifikat'] = $this->imageServiceV2->upload(name: 'template_sertifikat', path: $this->templateSertifikatPath, disk: $this->disk);
        $validated['poster'] = $this->imageServiceV2->upload(name: 'poster', path: $this->posterPath, disk: $this->disk);

        Event::create(attributes: $validated);

        return to_route(route: 'events.index')->with(key: 'success', value: __(key: 'The event was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): View
    {
        return view(view: 'events.show', data: compact(var_name: 'event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        return view(view: 'events.edit', data: compact(var_name: 'event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();

        $validated['template_sertifikat'] = $this->imageServiceV2->upload(name: 'template_sertifikat', path: $this->templateSertifikatPath, defaultImage: $event?->template_sertifikat, disk: $this->disk);
        $validated['poster'] = $this->imageServiceV2->upload(name: 'poster', path: $this->posterPath, defaultImage: $event?->poster, disk: $this->disk);

        $event->update(attributes: $validated);

        return to_route(route: 'events.index')->with(key: 'success', value: __(key: 'The event was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        try {
            $templateSertifikat = $event->template_sertifikat;
            $poster = $event->poster;

            $event->delete();

            $this->imageServiceV2->delete(path: $this->templateSertifikatPath, image: $templateSertifikat, disk: $this->disk);

            $this->imageServiceV2->delete(path: $this->posterPath, image: $poster, disk: $this->disk);


            return to_route(route: 'events.index')->with(key: 'success', value: __(key: 'The event was deleted successfully.'));
        } catch (\Exception $e) {
            return to_route(route: 'events.index')->with(key: 'error', value: __(key: "The event can't be deleted because it's related to another table."));
        }
    }
}
