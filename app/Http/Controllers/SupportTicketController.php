<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketResponse;
use App\Models\TicketAttachment;
use App\Models\User;
use App\Mail\TicketCreated;
use App\Mail\TicketResponse as TicketResponseMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SupportTicketController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            \Log::info('Usuario autenticado:', ['user_id' => $user->id, 'email' => $user->email]);
            
            // Si es administrador, obtener todos los tickets
            if ($user->isAdmin()) {
                $tickets = SupportTicket::with(['user', 'latestResponse'])
                    ->latest()
                    ->paginate(15);
                
                \Log::info('Administrador viendo todos los tickets:', ['count' => $tickets->count()]);
            } else {
                // Usuario normal solo ve sus propios tickets
                $tickets = $user->tickets()
                    ->with('latestResponse')
                    ->latest()
                    ->paginate(10);
                
                \Log::info('Usuario viendo sus tickets:', ['count' => $tickets->count()]);
            }
            
            if ($tickets->isEmpty()) {
                \Log::info('No se encontraron tickets');
            }

            return view('support.tickets.index', [
                'tickets' => $tickets,
                'isAdminView' => $user->isAdmin()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en SupportTicketController@index:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('support.tickets.index', [
                'tickets' => collect(), // Retorna una colección vacía en caso de error
                'isAdminView' => Auth::user()->isAdmin()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \Log::info('Acceso a SupportTicketController@create', [
            'user_id' => auth()->id(),
            'auth_check' => auth()->check(),
            'session' => session()->all()
        ]);
        
        try {
            // Verificar si el usuario está autenticado
            if (!auth()->check()) {
                \Log::warning('Intento de acceso no autenticado a create ticket');
                return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un ticket.');
            }
            
            \Log::info('Mostrando formulario de creación de ticket');
            
            // Mostrar el formulario de creación de tickets
            return view('support.tickets.create');
            
        } catch (\Exception $e) {
            \Log::error('Error en SupportTicketController@create:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'auth_check' => auth()->check()
            ]);
            
            return redirect()->back()->with('error', 'Ocurrió un error al cargar el formulario de creación de tickets.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Iniciando store method', [
            'request_data' => $request->except(['_token', 'attachments']),
            'has_files' => $request->hasFile('attachments'),
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? null,
            'all_request_headers' => $request->header(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'accept' => $request->header('Accept'),
            'is_ajax' => $request->ajax(),
            'wants_json' => $request->wantsJson(),
            'expects_json' => $request->expectsJson()
        ]);
        
        // Verificar si la solicitud es JSON
        if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
            \Log::info('Solicitud detectada como JSON/AJAX');
        }
        
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'description' => 'required|string|min:10',
                'priority' => 'required|in:low,medium,high,urgent',
                'attachments' => 'nullable',
                'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
            ]);

            // Iniciar una transacción para asegurar la integridad de los datos
            return \DB::transaction(function () use ($validated, $request) {
                // Generar número de referencia único
                $referenceNumber = 'TKT-' . strtoupper(Str::random(8));
                
                // Crear el ticket
                $ticket = SupportTicket::create([
                    'user_id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'subject' => $validated['subject'],
                    'description' => $validated['description'],
                    'priority' => $validated['priority'],
                    'status' => 'open',
                    'reference_number' => $referenceNumber,
                ]);
                
                if (!$ticket) {
                    throw new \Exception('No se pudo crear el ticket');
                }
                
                // Crear la respuesta inicial del ticket
                $response = new TicketResponse([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'content' => $validated['description'],
                    'is_customer_response' => true
                ]);
                
                if (!$response->save()) {
                    throw new \Exception('No se pudo guardar la respuesta del ticket');
                }

                // Manejar archivos adjuntos si existen
                if ($request->hasFile('attachments')) {
                    try {
                        $this->handleAttachments($request, $response);
                    } catch (\Exception $e) {
                        // Si hay un error con los archivos adjuntos, lo registramos pero continuamos
                        \Log::error('Error al procesar archivos adjuntos: ' . $e->getMessage(), [
                            'ticket_id' => $ticket->id,
                            'error' => $e->getTraceAsString()
                        ]);
                    }
                }

                // Enviar notificación al usuario que creó el ticket
                try {
                    Mail::to($ticket->email)
                        ->queue(new TicketCreated($ticket));
                    \Log::info('Notificación de ticket creado enviada al usuario', [
                        'ticket_id' => $ticket->id,
                        'user_email' => $ticket->email
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error al enviar notificación al usuario: ' . $e->getMessage(), [
                        'ticket_id' => $ticket->id,
                        'error' => $e->getTraceAsString()
                    ]);
                }

                // Enviar notificación al administrador
                try {
                    $adminEmail = config('mail.admin_email', 'admin@example.com');
                    if ($adminEmail) {
                        Mail::to($adminEmail)
                            ->queue(new TicketCreated($ticket, true));
                        \Log::info('Notificación de nuevo ticket enviada al administrador', [
                            'ticket_id' => $ticket->id,
                            'admin_email' => $adminEmail
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error al enviar notificación al administrador: ' . $e->getMessage(), [
                        'ticket_id' => $ticket->id,
                        'error' => $e->getTraceAsString()
                    ]);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => '¡Ticket creado exitosamente!',
                    'redirect' => route('support.tickets.show', $ticket),
                    'ticket_id' => $ticket->id,
                    'reference_number' => $ticket->reference_number
                ]);
            });
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            \Log::error('Error de validación al crear ticket', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token', 'attachments']),
                'user_id' => Auth::id()
            ]);
            
            if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors(),
                ], 422);
            }
            
            return back()
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Error al crear ticket: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token', 'attachments']),
                'exception' => get_class($e),
                'user_id' => Auth::id(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            $errorMessage = 'Ocurrió un error al crear el ticket. Por favor, inténtalo de nuevo.';
            
            if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $ticket)
    {
        $this->authorize('view', $ticket);
        
        try {
            // Marcar como leído si es el usuario asignado o el propietario
            if (Auth::user()->isSupportAgent() || $ticket->user_id === Auth::id()) {
                // Usar el método update para evitar conflictos con el trait Notifiable
                if (is_null($ticket->read_at)) {
                    $ticket->update(['read_at' => now()]);
                }
            }
            
            $ticket->load(['responses.user', 'responses.attachments']);
            
            return view('support.tickets.show', compact('ticket'));
            
        } catch (\Exception $e) {
            \Log::error('Error al marcar el ticket como leído: ' . $e->getMessage(), [
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'error' => $e->getTraceAsString()
            ]);
            
            // Continuar cargando la vista incluso si hay un error al marcar como leído
            $ticket->load(['responses.user', 'responses.attachments']);
            return view('support.tickets.show', compact('ticket'));
        }
    }

    /**
     * Store a new response for the ticket.
     */
    public function storeResponse(Request $request, SupportTicket $ticket)
    {
        $this->authorize('respond', $ticket);

        $validated = $request->validate([
            'content' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ]);

        // Crear la respuesta
        $response = $ticket->responses()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_customer_response' => false // Siempre será false ya que solo los admin pueden responder
        ]);

        // Manejar archivos adjuntos si existen
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request, $response);
        }

        // Actualizar el estado del ticket a 'en espera de respuesta del cliente'
        $ticket->update(['status' => 'awaiting_response']);

        // Notificar al cliente sobre la respuesta
        Mail::to($ticket->email)->queue(new TicketResponseMail($ticket, $response, $ticket->user));

        return redirect()
            ->route('support.tickets.show', $ticket)
            ->with('success', __('support.messages.response_sent'));
    }

    /**
     * Update the status of the specified ticket.
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in([
                'open', 'in_progress', 'awaiting_response', 'resolved', 'closed'
            ])],
            'comment' => 'nullable|string|max:500'
        ]);

        $previousStatus = $ticket->status;
        $ticket->update(['status' => $validated['status']]);

        // Si se agregó un comentario junto con el cambio de estado
        if (!empty($validated['comment'])) {
            $response = $ticket->responses()->create([
                'user_id' => Auth::id(),
                'content' => '**Cambio de estado:** ' . __('support.status.' . $previousStatus) . ' → ' . 
                             __('support.status.' . $validated['status']) . "\n\n" . 
                             $validated['comment'],
                'is_customer_response' => false
            ]);

            // Notificar al usuario sobre el cambio de estado
            if ($ticket->user_id !== Auth::id()) {
                Mail::to($ticket->email)->queue(new TicketResponseMail($ticket, $response, $ticket->user));
            }
        }

        return redirect()
            ->route('support.tickets.show', $ticket)
            ->with('success', __('support.messages.status_updated'));
    }

    /**
     * Handle file uploads for ticket responses.
     */
    protected function handleAttachments(Request $request, $response)
    {
        if (!$request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('ticket_attachments/' . date('Y/m/d'), 'public');
            
            $response->attachments()->create([
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
        }
    }

    /**
     * Upload an attachment to a ticket.
     */
    public function uploadAttachment(Request $request, SupportTicket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
            'response_id' => 'required|exists:ticket_responses,id,ticket_id,' . $ticket->id,
        ]);

        $response = $ticket->responses()->findOrFail($validated['response_id']);
        $file = $request->file('file');
        
        $path = $file->store('ticket_attachments/' . date('Y/m/d'), 'public');
        
        $attachment = $response->attachments()->create([
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
            'attachment' => [
                'id' => $attachment->id,
                'original_name' => $attachment->original_name,
                'url' => $attachment->url,
                'size' => $this->formatBytes($attachment->size),
                'icon' => $attachment->file_icon,
            ]
        ]);
    }

    /**
     * Download an attachment.
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
        $this->authorize('view', $attachment->ticketResponse->ticket);

        if (!Storage::disk('public')->exists($attachment->path)) {
            abort(404);
        }

        $headers = [
            'Content-Type' => $attachment->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $attachment->original_name . '"',
        ];

        return Storage::disk('public')->download($attachment->path, $attachment->original_name, $headers);
    }

    /**
     * Format bytes to a human-readable format.
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
