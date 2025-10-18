@extends('layout')

@section('content')
    @php
        $guessed = session()->get('correctly_guessed', []);
        $total = 7; // Total principles
        $score = count($guessed);
        $isComplete = $score === $total;
    @endphp
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
            
            <h1 class="text-center text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">Part II: Enumeration</h1>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">Enumerate the {{ $total }} Core Principles of Graphics and Layout.</p>

            <!-- Progress Bar and Score -->
            <div class="flex justify-between items-center mb-2 font-semibold text-gray-700 dark:text-gray-300">
                <span>Progress</span>
                <span id="score-text">{{ $score }} / {{ $total }} Found</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-8">
                <div id="progress-bar-fill" class="progress-bar-fill bg-indigo-600 h-4 rounded-full" style="width: {{ $total > 0 ? ($score / $total) * 100 : 0 }}%"></div>
            </div>

            <!-- This container holds the form, which will be hidden on completion -->
            <div id="quiz-form-container" class="{{ $isComplete ? 'hidden' : '' }}">
                <form id="quiz-form" class="mb-8">
                    @csrf
                    <div>
                        <label for="answer-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enter a Principle:</label>
                        <div class="mt-1 flex gap-3">
                            <input type="text" name="answer" id="answer-input" oninput="this.value = this.value.toUpperCase()"
                                class="block w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                autocomplete="off" autofocus>
                            <button type="button" id="btn-submit" class="cursor-pointer inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Feedback message area (initially hidden) -->
            <div id="feedback-container" class="hidden mb-6 p-4 rounded-md text-sm font-medium"></div>

            <!-- Correct Answers Section -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Correct Answers Found:</h3>
                <!-- This container will be populated by JavaScript -->
                <div id="correct-answers-container" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    {{-- Initial state rendered by PHP --}}
                    @forelse ($guessed as $item)
                        <div class="p-3 bg-green-100 dark:bg-green-800 rounded-lg flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-medium text-green-800 dark:text-green-200">{{ $item }}</span>
                        </div>
                    @empty
                        <p id="empty-message" class="text-gray-500 italic p-3 col-span-full">No principles found yet. Start guessing!</p>
                    @endforelse
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <button id="reset-button" type="button" class="cursor-pointer w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ $isComplete ? 'Play Again' : 'Reset Quiz' }}
                </button>
                <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Return to Home
                </a>
            </div>

            @include('partials.footer')
        </div>
    </main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quiz-form');
    const answerInput = document.getElementById('answer-input');
    const feedbackContainer = document.getElementById('feedback-container');
    const correctAnswersContainer = document.getElementById('correct-answers-container');
    const progressBarFill = document.getElementById('progress-bar-fill');
    const scoreText = document.getElementById('score-text');
    const resetButton = document.getElementById('reset-button');
    const total = {{ $total }};

    const showFeedback = (type, message) => {
        feedbackContainer.className = `mb-6 p-4 rounded-md text-sm font-medium ${
            type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
            type === 'error' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' :
            type === 'info' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' :
            'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
        }`;
        feedbackContainer.textContent = message;
        feedbackContainer.classList.remove('hidden');
    };

    document.getElementById('btn-submit').addEventListener('click', async () => {
        const answer = answerInput.value.trim();
        if (!answer) return showFeedback('warning', 'Please enter an answer.');
        setTimeout(() => {
        }, 1000);
        feedbackContainer.classList.add('hidden');

        try {
            const response = await fetch("{{ route('quiz.part2.check') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ answer })
            });

            const data = await response.json();
            console.log(data);
            console.log(data.message.type, data.message.text);
            showFeedback(data.message.type, data.message.text);

            if (data.status === 'success') {
                // Update correct answers list
                correctAnswersContainer.innerHTML = '';
                data.guessedAnswers.forEach(item => {
                    correctAnswersContainer.innerHTML += `
                        <div class="p-3 bg-green-100 dark:bg-green-800 rounded-lg flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-medium text-green-800 dark:text-green-200">${item}</span>
                        </div>`;
                });

                // Update progress bar + score
                const score = data.guessedAnswers.length;
                progressBarFill.style.width = `${(score / total) * 100}%`;
                scoreText.textContent = `${score} / ${total} Found`;

                // Clear input
                answerInput.value = '';

                // Hide form if complete
                if (data.complete) {
                    document.getElementById('quiz-form-container').classList.add('hidden');
                    resetButton.textContent = 'Play Again';
                }
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showFeedback('error', 'Something went wrong. Check console.');
        }
    });

    resetButton.addEventListener('click', async () => {
        await fetch("{{ route('quiz.part2.reset') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        window.location.reload();
    });
});
</script>
@endsection


