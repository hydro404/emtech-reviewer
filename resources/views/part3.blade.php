@extends('layout')

@section('style')
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
@endsection

@section('content')
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
            {{-- This directive checks if '$submittedData' exists. --}}
            {{-- If it does, we show the confirmation. If not, we show the form. --}}
            @if (session('submittedData'))
                @php
                    $data = session('submittedData');
                @endphp

                {{-- CONFIRMATION VIEW --}}
                <div class="text-center">
                    
                    <h1 class="text-3xl font-bold text-green-600 dark:text-green-400">Submission Received!</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Thank you for completing Part III.</p>

                    <div class="mt-8 text-left bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg border dark:border-gray-700 space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-500 dark:text-gray-400">Your Future Career:</h3>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $data['future_career'] }}</p>
                        </div>
                        <hr class="dark:border-gray-700">
                        <div>
                            <h3 class="font-semibold text-gray-500 dark:text-gray-400">Chosen Application/Tool:</h3>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $data['online_tool'] }}</p>
                        </div>
                        <hr class="dark:border-gray-700">
                        <div>
                            <h3 class="font-semibold text-gray-500 dark:text-gray-400">Your Explanation:</h3>
                            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $data['explanation'] }}</p>
                        </div>
                    </div>

                    @if (!empty($data['advice']))
                        <hr class="dark:border-gray-700">
                        <div>
                            <h3 class="font-semibold text-gray-500 dark:text-gray-400">Advice:</h3>
                            <p class="text-gray-800 dark:text-gray-200 italic">
                                {{ str_replace('<｜begin▁of▁sentence｜>', '', $data['advice']) }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('quiz.part3.show') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Submit Another Response
                        </a>
                        <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Return to Home
                        </a>
                    </div>
                </div>

            @else

                {{-- ESSAY FORM VIEW --}}
                
                <h1 class="text-center text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">Part III: Concept Application</h1>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-8">Choose your future career/job. Give one online application, tool, or website that you think might help you in your future career. How would this application, tool, or website help you in your future career? Explain.</p>

                <form action="{{ route('quiz.part3.submit') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="future_career" class="block text-sm font-medium text-gray-700 dark:text-gray-300">1. What is your future career or job?</label>
                            <input type="text" name="future_career" id="future_career"
                                required
                                class="mt-1 block w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g., Graphic Designer, Software Developer, Nurse">
                        </div>

                        <div>
                            <label for="online_tool" class="block text-sm font-medium text-gray-700 dark:text-gray-300">2. Name one online application, tool, or website.</label>
                            <input type="text" name="online_tool" id="online_tool"
                                required
                                class="mt-1 block w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g., Adobe Photoshop, GitHub, WebMD">
                        </div>

                        <div>
                            <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">3. Explain how this tool will help you in your career.</label>
                            <textarea name="explanation" id="explanation" rows="8"
                                    required
                                    class="mt-1 block w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Explain in detail..."></textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Final Answer
                        </button>
                    </div>
                </form>

            @endif

        </div>
    </main>
    @include('partials.footer')
@endsection
