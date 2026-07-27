<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotGuide\MascotGuideIdRequest;
use App\Http\Requests\MascotGuide\StoreMascotGuideRequest;
use App\Http\Requests\MascotGuide\UpdateMascotGuideRequest;
use App\Models\stp_mascot_guide;
use App\Services\MascotGuideService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MascotGuideController extends Controller
{
    public function __construct(private readonly MascotGuideService $service) {}

    public function publicList(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->publicGuides(),
        ]);
    }

    public function adminList(): JsonResponse
    {
        $guides = stp_mascot_guide::query()
            ->orderByDesc('data_status')
            ->orderByDesc('priority')
            ->orderByDesc('id')
            ->get()
            ->map(fn (stp_mascot_guide $guide) => $this->service->toAdminPayload($guide))
            ->values();

        return $this->success($guides);
    }

    public function detail(MascotGuideIdRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->toAdminPayload($this->findGuide($request))
        );
    }

    public function store(StoreMascotGuideRequest $request): JsonResponse
    {
        $guide = $this->service->create(
            $request->safe()->except('image'),
            $request->file('image'),
            (int) $request->user()->id
        );

        return $this->success($this->service->toAdminPayload($guide), 201);
    }

    public function update(UpdateMascotGuideRequest $request): JsonResponse
    {
        $guide = $this->service->update(
            $this->findGuide($request),
            $request->safe()->except(['id', 'image']),
            $request->file('image'),
            (int) $request->user()->id
        );

        return $this->success($this->service->toAdminPayload($guide));
    }

    public function publish(MascotGuideIdRequest $request): JsonResponse
    {
        $guide = $this->service->publish(
            $this->findGuide($request),
            (int) $request->user()->id
        );

        return $this->success($this->service->toAdminPayload($guide));
    }

    public function unpublish(MascotGuideIdRequest $request): JsonResponse
    {
        $guide = $this->service->unpublish(
            $this->findGuide($request),
            (int) $request->user()->id
        );

        return $this->success($this->service->toAdminPayload($guide));
    }

    public function archive(MascotGuideIdRequest $request): JsonResponse
    {
        $guide = $this->service->archive(
            $this->findGuide($request),
            (int) $request->user()->id
        );

        return $this->success($this->service->toAdminPayload($guide));
    }

    private function findGuide(Request $request): stp_mascot_guide
    {
        return stp_mascot_guide::findOrFail((int) $request->input('id'));
    }

    private function success(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }
}
