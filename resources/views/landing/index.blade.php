@extends('landing.layout')

@section('title', 'Inicio')

@section('content')

    {{-- Hero Section --}}
    @if($settings->hero_enabled)
        @include('landing.sections.hero')
    @endif

    {{-- Features/Stats combinados --}}
    @if($settings->services_enabled || $settings->about_enabled)
        @include('landing.sections.features')
    @endif

    {{-- Services Section --}}
    @if($settings->services_enabled)
        @include('landing.sections.services')
    @endif

    {{-- About Section --}}
    @if($settings->about_enabled)
        @include('landing.sections.about')
    @endif

    {{-- Projects Section --}}
    @if($settings->products_enabled)
        @include('landing.sections.projects')
    @endif

    {{-- Testimonials Section --}}
    @if($settings->testimonials_enabled)
        @include('landing.sections.testimonials')
    @endif

    {{-- Stats Section --}}
    @include('landing.sections.stats')

    {{-- Gallery Section --}}
    @if($settings->gallery_enabled)
        @include('landing.sections.gallery')
    @endif

    {{-- CTA Section --}}
    @include('landing.sections.cta')

    {{-- Contact Section --}}
    @if($settings->contact_enabled)
        @include('landing.sections.contact')
    @endif

@endsection
