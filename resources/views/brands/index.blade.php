@extends('layouts.app')

@section('title', 'Marcas de Clientes')

@section('content')
    {{-- Aquí iría la sección de productos destacados --}}
    <div class="my-12"></div>
    <x-brand-section :brands="[
        'MERCURY', 'TITANIUM', 'ZAFIRO', 'ILUMAX', 'ECOLITE', 'EXCELITE', 'INTERLED', 'DEXON', 'BRIOLIGH', 'ROYAL', 'LUMEK',
        'TITANIUM', 'DIXTON', 'BAYTER', 'SPARKLED', 'KARLUX', 'FELGOLUX', 'NEW LIGHT', 'DIGITAL LIGHT', 'SICOLUX', 'ACRILED', 'MARWA'
    ]" />
@endsection
