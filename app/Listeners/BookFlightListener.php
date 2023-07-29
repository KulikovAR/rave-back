<?php

namespace App\Listeners;

use App\Events\BookFlightEvent;
use App\Interfaces\FetchFlightInterface;
use App\Interfaces\PdfServiceInterface;
use App\Interfaces\XmlParserInterface;
use App\Notifications\BookingFlightNotification;
use App\Services\PdfService;
use App\Services\TripsFetcherService;
use App\Services\XmlParserService;
use Illuminate\Support\Facades\Notification;

class BookFlightListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public PdfServiceInterface  $pdfService = new PdfService(),
        public XmlParserInterface   $xmlParserService = new XmlParserService(),
        public FetchFlightInterface $fetchFlightService = new TripsFetcherService(),
    ) {}

    /**
     * Handle the event.
     */
    public function handle(BookFlightEvent $event): void
    {
        $this->pdfService->createBooking(
            $event->order,
            'save',
            $this->xmlParserService,
            $this->fetchFlightService
        );

        Notification::route('mail', $event->order->email)
                    ->notify(new BookingFlightNotification($event->order->id));
    }
}
