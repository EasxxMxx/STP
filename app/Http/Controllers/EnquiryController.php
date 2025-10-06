<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stp_core_meta;
use App\Models\stp_enquiry;
use App\Http\Controllers\serviceFunctionController;


class EnquiryController extends Controller
{
    protected $serviceFunctionController;

    public function __construct(ServiceFunctionController $serviceFunctionController)
    {
        $this->serviceFunctionController = $serviceFunctionController;
    }

    public function subjectList()
    {
        try {
            $subjectList = stp_core_meta::where('core_metaType', 'enquiry_subject_type')
                ->where('core_metaStatus', 1)
                ->get();



            return response()->json([
                'success' => true,
                'data' => $subjectList
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function createEnquiry(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'contact' => 'required|string|max:255',
                'subject' => 'required|integer',
                'message' => 'required|string|max:1000'

            ]);

            $findSubject = stp_core_meta::find($request->subject);
            $createEnquiry = stp_enquiry::create([
                'enquiry_name' => $request->full_name,
                'enquiry_email' => $request->email,
                'enquiry_phone' => $request->contact,
                'enquiry_subject' => $request->subject,
                'enquiry_message' => $request->message,
                'enquiry_status' => 2
            ]);

            $this->serviceFunctionController->sendEnquiryEmail($request->full_name, $request->email, $request->contact, $findSubject->core_metaName, $request->message);
            return response()->json([
                'success' => true,
                'message' => 'Enquiry created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function enquiryList(Request $request)
    {
        try {
            $request->validate([
                'subject' => 'integer'
            ]);

            $enquiryList = stp_enquiry::when($request->subject, function ($query, $subject) {
                return $query->where('enquiry_subject', $subject);
            })
                ->where('enquiry_status', 1)
                ->get()
                ->map(function ($enquiry) {
                    return [
                        'id' => $enquiry->id,
                        'enquiry_name' => $enquiry->enquiry_name,
                        'enquiry_email' => $enquiry->enquiry_email,
                        'enquiry_phone' => $enquiry->enquiry_phone,
                        'enquiry_subject' => $enquiry->subject->core_metaName,
                        'enquiry_message' => $enquiry->enquiry_message,
                        'enquiry_status' => $enquiry->enquiry_status
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $enquiryList
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function enquiryListAdmin(Request $request)
    {
        try {
            $request->validate([
                'subject' => 'nullable|integer',
                'stat' => 'nullable|integer',
                'search' => 'nullable|string',
                'offset' => 'nullable|integer|min:0',
                'sort_column' => 'nullable|string|in:enquiry_name,enquiry_email,enquiry_phone,enquiry_subject,created_at,enquiry_message,enquiry_status',
                'sort_direction' => 'nullable|string|in:asc,desc'
            ]);

            $offset = $request->offset ?? 0;
            $limit = 10; // Fixed limit of 10 items per request
			$sortColumn = $request->sort_column;
			$sortDirection = $request->sort_direction;

			// Base query with relation and filters
			$query = stp_enquiry::with(['subject'])
				->when($request->filled('subject'), function ($q) use ($request) {
					$q->where('enquiry_subject', $request->subject);
				})
				->when($request->filled('stat'), function ($q) use ($request) {
					$q->where('enquiry_status', $request->stat);
				}, function ($q) {
					// Only apply the whereIn constraint if no specific stat is provided
					$q->whereIn('enquiry_status', [1, 2]);
				})
				->when($request->filled('search'), function ($q) use ($request) {
					$q->where(function ($sq) use ($request) {
						$sq->where('enquiry_name', 'like', '%' . $request->search . '%')
						  ->orWhere('enquiry_email', 'like', '%' . $request->search . '%')
						  ->orWhere('enquiry_phone', 'like', '%' . $request->search . '%');
					});
				});

			// DB-level sorting where possible
			if ($sortColumn && $sortDirection) {
				if (in_array($sortColumn, ['enquiry_name', 'enquiry_email', 'enquiry_phone'], true)) {
					$query->orderBy($sortColumn, $sortDirection);
				} elseif ($sortColumn === 'created_at') {
					$query->orderBy('created_at', $sortDirection);
				} elseif ($sortColumn === 'enquiry_status') {
					$query->orderBy('enquiry_status', $sortDirection);
				} else {
					$query->orderBy('created_at', 'desc');
				}
			} else {
				$query->orderBy('created_at', 'desc');
			}

			// Total count
			$totalCount = (clone $query)->toBase()->count();

			// Fetch current page
			$rows = $query->skip($offset)->take($limit)->get();

			// Map to response shape
			$processedData = $rows->map(function ($enquiry) {
				return [
					'id' => $enquiry->id,
					'enquiry_name' => $enquiry->enquiry_name,
					'enquiry_email' => $enquiry->enquiry_email,
					'enquiry_phone' => $enquiry->enquiry_phone,
					'enquiry_subject' => $enquiry->subject->core_metaName ?? null,
					'enquiry_message' => $enquiry->enquiry_message,
					'enquiry_status' => $enquiry->enquiry_status,
					'created_at'=> $enquiry->created_at->format("d/M/y")
				];
			})->values();

			// If sorting by subject, sort within current page
			if ($sortColumn === 'enquiry_subject' && $sortDirection) {
				$processedData = $processedData->sort(function ($a, $b) use ($sortDirection) {
					$aValue = strtolower($a['enquiry_subject'] ?? '');
					$bValue = strtolower($b['enquiry_subject'] ?? '');
					$cmp = strcmp($aValue, $bValue);
					return $sortDirection === 'asc' ? $cmp : -$cmp;
				})->values();
			}

			return response()->json([
				'success' => true,
				'data' => $processedData,
				'total' => $totalCount,
				'has_more' => ($offset + $limit) < $totalCount
			]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function enquiryDetail(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $enquiry = stp_enquiry::find($request->id);

            if (!$enquiry) {
                return response()->json([
                    'success' => false,
                    'message' => "Enquiry not found"
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $enquiry->id,
                    'name' => $enquiry->enquiry_name,
                    'email' => $enquiry->enquiry_email,
                    'phone' => $enquiry->enquiry_phone,
                    'subject' => $enquiry->subject->core_metaName ?? null,
                    'message' => $enquiry->enquiry_message,
                    'status' => $enquiry->enquiry_status,
                    'messageContent' => $enquiry->enquiry_reply_message ?? ''
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function replyEnquiry(Request $request)
    {
        $request->validate([
            'enquiryId' => 'required|integer',
            'subject' => 'required|string|max:255',
            'email' => 'required|email',
            'messageContent' => 'required|string|max:1000',

        ]);
        $findEnquiry = stp_enquiry::find($request->enquiryId);

        $this->serviceFunctionController->replyEnquiryEmail($request->subject, $request->email, $request->messageContent);
        $findEnquiry->update(
            [
                'enquiry_status' => 1,
                'enquiry_reply_message' => $request->messageContent,
            ]
        );

        return 'reply successfully';
    }
}
