<?php

namespace App\Providers;

use App\Events\RegisteredUserEvent;
use App\Listeners\RegisteredUserListener;
use App\Models\Announce;
use App\Models\Lesson;
use App\Models\Proposal;
use App\Models\Short;
use App\Models\Slide;
use App\Models\Tag;
use App\Observers\AnnounceObserver;
use App\Observers\LessonObserver;
use App\Observers\ProposalObserver;
use App\Observers\ShortObserver;
use App\Observers\SlideObserver;
use App\Observers\TagObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        RegisteredUserEvent::class => [RegisteredUserListener::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Lesson::observe(LessonObserver::class);
        Proposal::observe(ProposalObserver::class);
        Tag::observe(TagObserver::class);
        Slide::observe(SlideObserver::class);
        Announce::observe(AnnounceObserver::class);
        Short::observe(ShortObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
