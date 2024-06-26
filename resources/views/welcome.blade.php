@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($films as $film)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="film-poster overflow-hidden">
                    @if (filter_var($film->poster, FILTER_VALIDATE_URL))
                            <img src="{{ $film->poster }}" alt="{{ $film->title }}" class="img-thumbnail"
                                style="max-width: 150px;">
                            @elseif($film->poster === null)
                            <img src="https://cdn.pixabay.com/photo/2023/08/11/16/50/water-8183918_1280.jpg" class="img-thumbnail"
                            style="max-width: 150px;">
                            @else
                            <img src="{{ asset('storage/posters/' . $film->poster) }}" alt="{{ $film->title }}"
                                class="img-thumbnail" style="max-width: 150px;">
                            @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $film->title }}</h5>
                    <p class="card-text"><strong>Regista:</strong> {{ $film->director->name }}</p>
                    <p class="card-text"><strong>Attori:</strong></p>
                    <ul class="list-unstyled">
                        @foreach ($film->actors as $actor)
                        <li>{{ $actor->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Paginazione -->
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{-- Link alla pagina precedente --}}
                @if ($films->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $films->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                @endif
                
                {{-- Link alle pagine --}}
                @foreach ($films->getUrlRange(1, $films->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $films->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                
                {{-- Link alla pagina successiva --}}
                @if ($films->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $films->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    
    {{-- Mostra i risultati --}}
    <div class="text-center">
        <p>
            {{ __('pagination.showing_results', [
                'first' => $films->firstItem(),
                'last' => $films->lastItem(),
                'total' => $films->total(),
            ]) }}
        </p>
    </div>
    
    
</div>
@endsection
