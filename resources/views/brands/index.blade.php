@extends('layouts.app')

@section('title', 'Nuestras Marcas')

@section('content')
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                    Nuestras Marcas
                </h1>
                <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                    Colaboramos con las mejores marcas del mercado para ofrecerte productos de calidad garantizada.
                </p>
            </div>
            
            <x-modern-brands :brands="[
                'MERCURY', 'TITANIUM', 'ZAFIRO', 'ILUMAX', 'ECOLITE', 'EXCELITE', 'INTERLED', 'DEXON', 'BRIOLIGH', 'ROYAL', 'LUMEK',
                'DIXTON', 'BAYTER', 'SPARKLED', 'KARLUX', 'FELGOLUX', 'NEW LIGHT', 'DIGITAL LIGHT', 'SICOLUX', 'ACRILED', 'MARWA'
            ]" />
            
            <div class="mt-16 bg-gray-50 rounded-2xl p-8 md:p-12">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        ¿Eres una marca interesada en asociarte con nosotros?
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Estamos constantemente buscando nuevas asociaciones con marcas innovadoras. Si crees que tu producto encaja con nuestra visión, nos encantaría saber de ti.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Contáctanos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
