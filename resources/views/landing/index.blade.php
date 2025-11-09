@extends('landing.layout')

@section('title', 'Inicio')

@section('content')

    {{-- Hero Section --}}
    @if($settings->hero_enabled)
        @include('landing.sections.hero')
    @endif

    {{-- Stats Section --}}
    @if($settings->stats_enabled ?? true)
        @include('landing.sections.stats')
    @endif

    {{-- About Section --}}
    @if($settings->about_enabled)
        @include('landing.sections.about')
    @endif

    {{-- Features Section --}}
    @if($settings->features_enabled ?? true)
        @include('landing.sections.features')
    @endif

    {{-- Services Section --}}
    @if($settings->services_enabled)
        @include('landing.sections.services')
    @endif

    {{-- Shop Section --}}
    @include('landing.sections.shop')

    {{-- Projects Section --}}
    @if($settings->products_enabled)
        @include('landing.sections.projects')
    @endif

    {{-- Testimonials Section --}}
    @if($settings->testimonials_enabled)
        @include('landing.sections.testimonials')
    @endif

    {{-- Gallery Section --}}
    @if($settings->gallery_enabled)
        @include('landing.sections.gallery')
    @endif

    {{-- CTA Section --}}
    @if($settings->cta_enabled ?? true)
        @include('landing.sections.cta')
    @endif

    {{-- Contact Section --}}
    @if($settings->contact_enabled)
        @include('landing.sections.contact')
    @endif

@endsection
