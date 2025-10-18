<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display the quiz view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $questions = [
            [
                'question' => "The HR representative wants to add a condition which will ensure that only 'male' and 'female' will be the options in entering a person's sex. What feature of MS Excel must be used?",
                'options' => ['Data Validation', 'Graph Feature', 'Conditional Formatting', 'Data Analysis'],
                'answer' => 'Data Validation'
            ],
            [
                'question' => "Why are page numbers required in a Table of Contents?",
                'options' => ['To have more pages to read.', 'To make the work more appealing.', 'To help readers find in which page the topic can be located.', 'None of the above.'],
                'answer' => 'To help readers find in which page the topic can be located.'
            ],
            [
                'question' => "Miss Boñon, a SHS Math Teacher, wants to include in her lesson a chart showing her weekly expenses as compared to the weekly expenses of Grade 12 students in Camalig National High School. What is the suitable type of computer software she must use to present her lesson?",
                'options' => ['Presentation', 'MS PowerPoint', 'MS Excel', 'Spreadsheet or Worksheet'],
                'answer' => 'Presentation'
            ],
            [
                'question' => "Which Microsoft Excel feature allows to sum the numerical data in any number of columns or rows by selecting them or typing them in?",
                'options' => ['SUM () Function', 'Conditional Formatting', 'AVERAGE () Function', 'COUNT () Function'],
                'answer' => 'SUM () Function'
            ],
            [
                'question' => "Which Microsoft Excel feature enables users to emphasize certain cells with the formatting they want?",
                'options' => ['SUM () Function', 'Conditional Formatting', 'AVERAGE () Function', 'COUNT () Function'],
                'answer' => 'Conditional Formatting'
            ],
            [
                'question' => "Which file format is most suitable for sharing a document online while keeping its layout intact. You can't edit files in this format.",
                'options' => ['.docx', '.pdf', '.txt', '.xls'],
                'answer' => '.pdf'
            ],
            [
                'question' => "What does ICT stand for?",
                'options' => ['Information and Communications Technology', 'Internet and Computer Technology', 'Integrated Communication Tools', 'Intelligent Computer Tracking'],
                'answer' => 'Information and Communications Technology'
            ],
            [
                'question' => "If you are tasked to create an infographic about your career goals, which ICT tool would you use?",
                'options' => ['Canva', 'VLC Media Player', 'Microsoft Word', 'Google Sheets'],
                'answer' => 'Canva'
            ],
            [
                'question' => "This makes an image look sketched, grainy, classic black and white, or even have a neon color.",
                'options' => ['Color Balance', 'Cropping', 'Brightness and Contrast', 'Filters'],
                'answer' => 'Filters'
            ],
            [
                'question' => "This type of platform allows you to upload, download, organize, and store files on online storage, which is called the cloud.",
                'options' => ['Cloud computing', 'Social Media', 'Presentations/Visualization', 'Mapping'],
                'answer' => 'Cloud computing'
            ]
        ];

        // The questions are passed to the view, but they will be handled by AlpineJS.
        // We need to encode them as JSON for AlpineJS to read.
        return view('index', ['questionsJson' => json_encode($questions)]);
    }
}