@extends('participant.layout')

@section('title', 'Events - EventRize')

@section('content')
<div class="events-page">

    <!-- HEADER -->
    <header class="participant-header">
        <div class="search-bar">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>

            <form action="{{ route('participant.events') }}" method="GET">
                <input
                    type="search"
                    name="search"
                    placeholder="Cari event, pembicara, atau lokasi"
                    aria-label="Cari event"
                    value="{{ $search ?? '' }}"
                >
            </form>
        </div>
    </header>

    <!-- FILTERS -->
    <section class="events-filters">
        <div class="category-pills">
            @foreach($categories as $cat)
                <a
                    href="{{ route('participant.events', [
                        'category' => $cat,
                        'sort' => $sort,
                        'search' => $search
                    ]) }}"
                    class="category-pill {{ ($category ?? '') === $cat ? 'active' : '' }}"
                >
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <div class="sort-dropdown">
            <form action="{{ route('participant.events') }}" method="GET" id="sort-form">
                <input type="hidden" name="category" value="{{ $category }}">
                <input type="hidden" name="search" value="{{ $search }}">

                <select name="sort" onchange="document.getElementById('sort-form').submit()">
                    @foreach(['Terbaru', 'Terlama', 'Harga Terendah', 'Harga Tertinggi'] as $option)
                        <option value="{{ $option }}" {{ $sort === $option ? 'selected' : '' }}>
                            Urutkan: {{ $option }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </section>

    <!-- EVENTS GRID -->
    <section class="events-list">
        <div class="event-grid">
            @forelse($events as $event)
                <article class="event-card">
                    <a
                        href="{{ route('participant.events.detail', $event->id) }}"
                        class="event-card-link"
                    >
                        <div class="event-image">
                            @if($event->flyer_path)
                                <img
                                    src="{{ $event->flyer_url }}"
                                    alt="{{ $event->title }}"
                                >
                            @elseif($event->image)
                                <div class="event-image-bg img-{{ $event->image }}"></div>
                            @else
                                <div class="event-image-bg placeholder-gradient"></div>
                            @endif
                        </div>

                        <div class="event-body">
                            <h3>{{ $event->title }}</h3>

                            <p class="event-description">
                                {{ Str::limit($event->description, 100) }}
                            </p>

                            <div class="event-meta">
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>

                                    {{ $event->display_date }}
                                </span>

                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>

                                    {{ $event->location }}
                                </span>
                            </div>

                            <div class="event-price {{ $event->price > 0 ? 'paid' : 'free' }}">
                                {{ $event->formatted_price }}
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <p class="empty-message">Tidak ada event yang sesuai.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection
