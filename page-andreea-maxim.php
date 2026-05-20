<?php

if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '') { return '/' . ltrim($path, '/'); }
}

$baseDir = __DIR__;

$configFile = $baseDir . '/config.json';
$googleMapsKey = "";

if (file_exists($configFile)) {
    $configData = json_decode(file_get_contents($configFile), true);
    $googleMapsKey = $configData['googleMapsKey'] ?? "";
}

$jsonFiles = ['courses.json'];
$allCourses = [];

foreach ($jsonFiles as $file) {
    $filePath = $baseDir . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $allCourses = array_merge($allCourses, $data);
        }
    }
}

// Fallback if no courses found
if (empty($allCourses)) {
    $coursesJson = "[]"; 
} else {
    $coursesJson = json_encode($allCourses);
}

$web3FormsKey = "{your api here}"; 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andreea Macxim | Student Advisor</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($googleMapsKey); ?>&libraries=geometry" async defer></script>
    <?php endif; ?>
    
    <style>
      
        :root {
            --primary: #1e3a8a; /* Oxford Blue */
            --accent: #2563eb;  /* Brighter Blue */
            --text-main: #1e293b;
            --border-color: #e2e8f0;
        }
        
        body { font-family: 'Lato', sans-serif; color: var(--text-main); overflow-x: hidden; position: relative; }
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }
        
        #bg-fixed {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2;
            background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        #bg-veil {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(3px); 
        }

        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .content-card { 
            background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color);
        }

        .input-standard { 
            background: #ffffff; 
            border: 1px solid #d1d5db; 
            color: #1f2937; 
            border-radius: 0.5rem; 
            padding: 0.75rem; 
            width: 100%; 
            transition: all 0.2s;
            -webkit-appearance: none;
        }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; }
        
        .btn-blue {
            background-color: var(--primary); color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700;
            transition: transform 0.2s, background-color 0.2s; display: inline-block; cursor: pointer; text-align: center;
        }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }
        
        .btn-outline-blue {
            background: transparent; border: 2px solid var(--primary); color: var(--primary);
            padding: 10px 28px; border-radius: 8px; font-weight: 700; transition: all 0.2s; display: inline-block; text-align: center;
        }
        .btn-outline-blue:hover { background: var(--primary); color: white; }

        .prep-card {
            background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary);
            padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%;
        }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 9999; display: none;
            justify-content: center; align-items: center; padding: 20px;
            backdrop-filter: blur(2px);
        }
        .modal-content {
            background: white; width: 100%; max-width: 600px; border-radius: 1rem;
            padding: 30px; position: relative; max-height: 90vh; overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.3s ease;
        }
        .modal-close-btn {
            position: absolute; top: 15px; right: 15px; 
            background: #f1f5f9; border-radius: 50%; width: 32px; height: 32px; 
            display: flex; align-items: center; justify-content: center; 
            color: #64748b; cursor: pointer; transition: all 0.2s; border: none;
        }
        .modal-close-btn:hover { background: #e2e8f0; color: #ef4444; }
        
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        #mobile-menu { 
            display: none; position: absolute; top: 100%; left: 0; width: 100%; 
            background: white; border-bottom: 4px solid var(--primary); padding: 20px; 
            flex-direction: column; gap: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); z-index: 999; 
        }
        #mobile-menu.active { display: flex; }
    </style>
</head>
<body class="bg-transparent">

    <div id="bg-fixed"></div>
    <div id="bg-veil"></div>

   <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-28 flex justify-between items-center relative">
            
            <a href="index.php" class="flex flex-col items-center justify-center gap-0 group no-underline">
                <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-10 w-auto object-contain mb-1 transition group-hover:scale-105">
                
                <span class="brand-text text-sm font-bold text-blue-900 leading-tight">One Guide</span>
                <span class="text-sm font-medium text-gray-700">We help you find the right direction</span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>

            <div class="hidden md:flex gap-8 items-center font-medium text-gray-600">
                <a href="#course-search" class="hover:text-[#1e3a8a] transition" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="hover:text-[#1e3a8a] transition" data-key="nav_eligibility">Eligibility</a>
                
                <div class="relative inline-block">
                    <select onchange="changeLanguage(this.value)" class="input-standard py-2 pl-3 pr-8 text-sm bg-white border-gray-200 cursor-pointer">
                        <option value="en">🇬🇧 English</option>
                        <option value="ro">🇷🇴 Română</option>
                        <option value="pl">🇵🇱 Polski</option>
                        <option value="hu">🇭🇺 Magyar</option>
                        <option value="es">🇪🇸 Español</option>
                        <option value="it">🇮🇹 Italiano</option>
                        <option value="pt">🇵🇹 Português</option>
                        <option value="el">🇬🇷 Ελληνικά</option>
                        <option value="bg">🇧🇬 Български</option>
                    </select>
                </div>
                
                <a href="#contact" class="btn-blue shadow-md" data-key="nav_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition mobile-toggle" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu">
                <a href="#course-search" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_eligibility">Eligibility</a>
                <div class="border-t border-gray-100 pt-4 mt-2">
                    <select onchange="changeLanguage(this.value); toggleMobileMenu();" class="w-full p-3 border border-gray-300 rounded bg-white text-gray-700">
                        <option value="en">🇬🇧 English</option>
                        <option value="ro">🇷🇴 Română</option>
                        <option value="pl">🇵🇱 Polski</option>
                        <option value="hu">🇭🇺 Magyar</option>
                        <option value="es">🇪🇸 Español</option>
                        <option value="it">🇮🇹 Italiano</option>
                        <option value="pt">🇵🇹 Português</option>
                        <option value="el">🇬🇷 Ελληνικά</option>
                        <option value="bg">🇧🇬 Български</option>
                    </select>
                </div>
                <a href="#contact" class="btn-blue w-full mt-4 block text-center" onclick="toggleMobileMenu()" data-key="nav_contact">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="pt-40 pb-24 px-6 border-b border-gray-100/50">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 fade-in">
                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-[#1e3a8a] blur-xl opacity-20 rounded-full"></div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/AndreeaMacxim.jpg" alt="Andreea Macxim" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Andreea Macxim</h1>
                    <p class="font-bold tracking-widest uppercase mb-6 text-[#1e3a8a]" data-key="role_title">Dedicated Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6">
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 07398 011126
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> andreea.macxim@ask33.co.uk
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-blue shadow-lg transition" data-key="btn_contact">Get in Touch</a>
                        <a href="<?php echo home_url('/#team'); ?>" class="btn-outline-blue" data-key="btn_back">Back to Team</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="course-search" class="px-6 relative z-10 -mt-4">
            <div class="max-w-5xl mx-auto content-card fade-in text-center p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold serif-font text-[#1e3a8a]" data-key="search_title">Search Accredited Courses</h2>
                    <button id="toggle-search-btn" onclick="toggleSearch()" class="text-sm text-blue-600 underline">Hide Search</button>
                </div>
                
                <div id="search-container">
                    <form onsubmit="handleSearch(event)" class="grid md:grid-cols-4 gap-6 text-left">
                        <div class="md:col-span-1">
                    <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_postcode">City</label>
                    <select id="user-postcode" class="input-standard w-full" required>
                        <option value="" disabled selected>Select a city</option>
                       
                        <option value="Online">Online / Self-Learning</option>
                        <option value="London">London</option>
                        <option value="Manchester">Manchester</option>
                        <option value="Birmingham">Birmingham</option>
                        <option value="Leeds">Leeds</option>
                        <option value="Bradford">Bradford</option>
                        <option value="Sheffield">Sheffield</option>
                        <option value="Nottingham">Nottingham</option>                                     <option value="Newcastle">Newcastle</option>
                        <option value="Leicester">Leicester</option>
                       
                    </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_level">Level</label>
                            <select id="user-level" class="input-standard w-full">
                                <option value="All">All Levels</option>
                            <option value="Foundation">Foundation Year</option>
                            <option value="Year 1">Year 1 (Level 4)</option>
                            <option value="Year 2">Year 2 (Level 5)</option>
                            <option value="Top-up">Top-up (Level 6)</option>
                            <option value="Master">Master / Postgraduate</option>
                            <option value="Second Degree">Second Degree</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_subject">Subject</label>
                            <select id="user-subject" class="input-standard w-full">
                                <option value="All">All Subjects</option>
                            <option value="Business">Business</option>
                            <option value="Computing">Computing</option>
                            <option value="Health">Health & Social Care</option>
                            <option value="Law">Law</option>
                            <option value="Art">Art & Design</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Education">Education</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button class="w-full btn-blue" data-key="btn_find">Find</button>
                        </div>
                    </form>
                    
                    <div id="loading-spinner" class="hidden mt-6 text-blue-600 font-bold animate-pulse text-center">
                        <i data-feather="loader" class="animate-spin mr-2"></i> Searching...
                    </div>
                    
                    <div id="results-area" class="mt-8 space-y-4 text-left"></div>
                    
                    <div id="pagination-controls" class="hidden mt-6 flex justify-center gap-4">
                        <button onclick="changePage(-1)" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200 text-gray-700">Previous</button>
                        <span id="page-indicator" class="px-4 py-2 text-gray-600 font-bold">Page 1</span>
                        <button onclick="changePage(1)" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200 text-gray-700">Next</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">Guidance for Your Future</h2>
                    <p class="text-slate-500 mt-2" data-key="bio_intro">Specializing in supporting students through every stage of their academic journey.</p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I am Andreea Macxim, Student Advisor specializing in supporting students through every stage of their academic journey. My goal is to help students make informed decisions and successfully transition into higher education and professional life.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"My role is to guide you responsibly and help you make decisions that truly benefit your future."</p>
                        </div>
                        
                        <p data-key="bio_p2">I provide calm, patient, and personalised support every step of the way - I can help you feel confident and informed throughout the process.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">What I Offer:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_1">Calm, patient, and personalised support</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_2">Informed decisions for higher education</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_3">Responsible guidance for your future</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_4">Support through every stage</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_5">Confidence throughout the process</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="prep" class="py-12 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold serif-font text-[#1e3a8a]" data-key="prep_title">Interview Preparation</h2>
                    <p class="text-slate-500" data-key="prep_sub">Master the skills needed for your university interview.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <a href="<?php echo home_url('/prep-star/'); ?>" class="prep-card group block h-full">
                        <i data-feather="star" class="w-10 h-10 text-amber-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="star_t">STAR Method</h3>
                        <p class="text-sm text-gray-600" data-key="star_d">Master behavioral questions.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-psych/'); ?>" class="prep-card group block h-full">
                        <i data-feather="cpu" class="w-10 h-10 text-blue-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="psych_t">Ability Assessment</h3>
                        <p class="text-sm text-gray-600" data-key="psych_d">Logic & reasoning practice.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-case/'); ?>" class="prep-card group block h-full">
                        <i data-feather="briefcase" class="w-10 h-10 text-purple-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="case_t">Case Studies</h3>
                        <p class="text-sm text-gray-600" data-key="case_d">Real-world scenarios.</p>
                    </a>
                </div>
            </div>
        </section>

        <section id="eligibility" class="py-12 px-6">
            <div class="max-w-4xl mx-auto content-card bg-[#eff6ff] border border-[#1e3a8a] text-center p-10">
                <i data-feather="check-square" class="w-12 h-12 text-[#1e3a8a] mx-auto mb-4"></i>
                <h2 class="text-2xl font-bold text-[#1e3a8a] mb-4" data-key="elig_title">Check Your Eligibility</h2>
                <p class="text-gray-600 mb-6" data-key="elig_desc">Answer a few questions to see if you qualify for Student Finance and admission.</p>
                <button onclick="openEligibilityModal()" class="btn-blue shadow-lg hover:-translate-y-1 transition" data-key="btn_check_elig">Answer Questions</button>
            </div>
        </section>

        <section id="test" class="py-12 px-6">
            <div class="max-w-4xl mx-auto content-card bg-[#f8fafc] border-l-8 border-[#1e3a8a] text-center">
                <h2 class="text-2xl font-bold text-[#1e3a8a] mb-4" data-key="test_title">Validate Your English Proficiency</h2>
                <p class="text-gray-600 mb-6" data-key="test_desc">A certified English level is often required for university admission. Take the official Duolingo English Test online anytime, anywhere.</p>
                <a href="https://englishtest.duolingo.com/applicants" target="_blank" class="inline-flex items-center gap-2 bg-[#1e3a8a] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#1e40af] transition shadow-md transform hover:-translate-y-1">
                    <span data-key="btn_test">Take Duolingo English Test</span> 
                    <i data-feather="external-link" class="w-4 h-4"></i>
                </a>
            </div>
        </section>

        <section id="contact" class="py-20 px-6">
            <div class="max-w-xl mx-auto content-card relative overflow-hidden" style="min-height: 400px;">
                
                <div id="contact-form-wrapper" class="transition-all duration-500 ease-in-out">
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Start Your Journey</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Fill in the form below for guidance on your academic journey.</p>
                    
                    <form id="andreea-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                        <input type="hidden" name="subject" value="New Contact for Andreea Macxim">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="How can I help?" required></textarea>
                        
                        <button type="submit" id="submit-btn" class="w-full btn-blue flex justify-center items-center gap-2">
                            <span id="btn-text" data-key="btn_send">Send Request</span>
                            <i id="btn-icon" data-feather="send" class="w-4 h-4"></i>
                            <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </form>
                </div>

                <div id="success-message" class="absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 pointer-events-none transform translate-y-10 transition-all duration-700 ease-out">
                    <div class="bg-green-100 p-4 rounded-full mb-4 shadow-sm"><i data-feather="check" class="w-12 h-12 text-green-600"></i></div>
                    <h3 class="text-3xl font-bold text-slate-800 mb-2">Thank You!</h3>
                    <p class="text-slate-600 text-lg max-w-xs mx-auto">Your message has been sent successfully. I will get back to you shortly.</p>
                    <button onclick="resetForm()" class="mt-8 text-blue-600 underline text-sm font-bold hover:text-blue-800 transition">Send another message</button>
                </div>

            </div>
        </section>

    </main>

    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="document.getElementById('eligibility-modal').style.display='none'" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <button onclick="closeEligibilityModal()" class="modal-close-btn" style="position: absolute; top: 10px; right: 10px; padding: 10px;">
                <i data-feather="x"></i>
            </button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]" data-key="elig_title">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="New Eligibility Check - Andreea Macxim">
                <input type="hidden" name="from_name" value="Eligibility Form">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Town</label>
                        <input type="text" name="city" class="input-standard" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q2">2. Residency Status</label>
                        <select name="residency" class="input-standard">
                            <option value="Pre-settle (Working)">Pre-settle (Working)</option>
                            <option value="Pre-settle (Not Working)">Pre-settle (Not Working)</option>
                            <option value="Settle Status">Settle Status</option>
                            <option value="British Citizen">British Citizen</option>
                            <option value="Refugee">Refugee</option>
                            <option value="Ukraine Scheme">Ukraine Scheme</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q3">3. English Level</label>
                        <select name="english_level" class="input-standard">
                            <option value="Basic">Basic</option>
                            <option value="Medium">Medium</option>
                            <option value="Conversational">Conversational</option>
                            <option value="Advanced">Advanced</option>
                            <option value="None">None</option>
                        </select>
                        <div class="mt-2 text-center"><a href="https://englishtest.duolingo.com/applicants" target="_blank" class="text-blue-600 underline text-xs font-bold hover:text-blue-800" data-key="link_duolingo_check">Not sure about the level of english take this test</a></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q4">4. Diploma (Bac, Lvl 3, A-Levels, BTEC)</label>
                        <input type="text" name="diploma" class="input-standard" placeholder="Yes (Which?) / No">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q5">5. Course Type</label>
                        <select name="course_type" class="input-standard">
                            <option value="Undergraduate">Undergraduate</option>
                            <option value="Postgraduate (Master)">Postgraduate (Master)</option>
                            <option value="Second Degree">Second Degree</option>
                            <option value="Full Online">Full Online (No Maintenance)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q6">6. Field of Study</label>
                        <input type="text" name="field" class="input-standard" placeholder="e.g. Business, Health..." required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q7">7. Schedule</label>
                        <select name="schedule" class="input-standard">
                            <option value="2 Days x 4h">2 Days x 4h</option>
                            <option value="1 Day Online / 1 Day Campus">One day online and one day on campus</option>
                            <option value="Weekend">Weekend</option>
                            <option value="Daytime">Daytime</option>
                            <option value="Evening">Evening</option>
                            <option value="2 Days Full">2 Days Full (8h)</option>
                            <option value="Mix">2 Evenings Online + 1 Day Campus</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q8">8. London?</label>
                        <select name="london_study" class="input-standard">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full btn-blue" data-key="btn_submit_elig">Submit Answers</button>
                    
                    <button type="button" onclick="closeEligibilityModal()" class="w-full mt-3 text-gray-500 hover:text-gray-700 text-sm font-medium underline">Close</button>
                </div>
            </form>
        </div>
    </div>
    <footer class="bg-white text-gray-700 py-12 text-center mt-12 border-t border-gray-200">
        </div>
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-red-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>


    <script>
        feather.replace();

        <?php echo "const coursesDB = " . ($coursesJson ?: "[]") . ";"; ?>

        let allSortedResults = [];
        let currentPage = 1;
        const resultsPerPage = 5;

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.style.display === 'flex') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'flex';
            }
        }

        function toggleSearch() {
            const container = document.getElementById('search-container');
            const btn = document.getElementById('toggle-search-btn');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                btn.innerText = "Hide Search";
            } else {
                container.classList.add('hidden');
                btn.innerText = "Show Search";
            }
        }

        function openEligibilityModal() {
            document.getElementById('eligibility-modal').style.display = 'flex';
        }
        function closeEligibilityModal() {
            document.getElementById('eligibility-modal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('eligibility-modal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        const form = document.getElementById('andreea-contact-form');
        const formWrapper = document.getElementById('contact-form-wrapper');
        const successMessage = document.getElementById('success-message');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnSpinner = document.getElementById('btn-spinner');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                submitBtn.disabled = true;
                btnText.textContent = "Sending...";
                if(btnIcon) btnIcon.classList.add('hidden');
                if(btnSpinner) btnSpinner.classList.remove('hidden');

                const formData = new FormData(form);

                fetch("https://api.web3forms.com/submit", {
                    method: "POST",
                    body: formData
                })
                .then(async (response) => {
                    const json = await response.json();
                    if (response.status === 200) {
                        formWrapper.style.opacity = '0';
                        formWrapper.style.transform = 'translateY(-20px)';
                        
                        setTimeout(() => {
                            formWrapper.classList.add('hidden');
                            successMessage.classList.remove('pointer-events-none');
                            successMessage.classList.remove('translate-y-10'); 
                            successMessage.style.opacity = '1';
                            if (typeof feather !== 'undefined') feather.replace();
                        }, 500);
                    } else {
                        alert(json.message);
                        resetBtnState();
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Network error. Please check your connection.");
                    resetBtnState();
                });
            });
        }

        function resetBtnState() {
            submitBtn.disabled = false;
            btnText.textContent = "Send Request";
            if(btnIcon) btnIcon.classList.remove('hidden');
            if(btnSpinner) btnSpinner.classList.add('hidden');
        }

        window.resetForm = function() {
            form.reset();
            resetBtnState();
            successMessage.style.opacity = '0';
            successMessage.classList.add('translate-y-10');
            successMessage.classList.add('pointer-events-none');
            setTimeout(() => {
                formWrapper.classList.remove('hidden');
                setTimeout(() => {
                    formWrapper.style.opacity = '1';
                    formWrapper.style.transform = 'translateY(0)';
                }, 50);
            }, 500);
        };

        async function handleSearch(e) {
            e.preventDefault();
            const postcode = document.getElementById('user-postcode').value.trim();
            const userLevel = document.getElementById('user-level').value;
            const userSubject = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            const pagControls = document.getElementById('pagination-controls');

            if(!postcode) return alert("Enter city or postcode.");
            
            div.innerHTML = '';
            if(pagControls) pagControls.classList.add('hidden');
            if(spinner) spinner.classList.remove('hidden');
            allSortedResults = []; 

            if(coursesDB.length === 0) {
                 for(let i=0; i<15; i++) {
                    coursesDB.push({
                        title: "BA (Hons) Business Management",
                        level: userLevel === 'All' ? 'Undergraduate' : userLevel,
                        subject: userSubject === 'All' ? 'Business' : userSubject,
                        city: postcode.charAt(0).toUpperCase() + postcode.slice(1),
                        institution: "Partner University"
                    });
                }
            }

            // IF MAPS API IS LOADED
            if (typeof google === 'object') {
                const service = new google.maps.DistanceMatrixService();
                
                const chunkSize = 25; 
                const batches = [];
                for (let i = 0; i < coursesDB.length; i += chunkSize) {
                    batches.push(coursesDB.slice(i, i + chunkSize));
                }

                for (const batch of batches) {
                    const destinations = batch.map(c => c.address || c.city);
                    
                    await new Promise(resolve => {
                        service.getDistanceMatrix({
                            origins: [postcode],
                            destinations: destinations,
                            travelMode: 'TRANSIT',
                            unitSystem: google.maps.UnitSystem.METRIC
                        }, (response, status) => {
                            if (status === 'OK') {
                                const rows = response.rows[0].elements;
                                batch.forEach((course, i) => {
                                    if (rows[i].status === "OK") {
                                        const dbLevel = (course.level || "").toLowerCase();
                                        const selLevel = userLevel.toLowerCase();
                                        
                                        const matchLevel = (userLevel === 'All') || 
                                                           (dbLevel.includes(selLevel));

                                        const matchSubject = (userSubject === 'All') || (course.subject === userSubject);

                                        if (matchLevel && matchSubject) {
                                            allSortedResults.push({
                                                ...course,
                                                distValue: rows[i].distance.value,
                                                distText: rows[i].distance.text,
                                                durText: rows[i].duration.text
                                            });
                                        }
                                    }
                                });
                            }
                            resolve();
                        });
                    });
                }

                allSortedResults.sort((a, b) => a.distValue - b.distValue);
                if(spinner) spinner.classList.add('hidden');
                
                if (allSortedResults.length > 0) {
                    currentPage = 1;
                    renderPage(1);
                } else {
                    div.innerHTML = '<div class="p-4 bg-gray-50 border border-gray-200 rounded text-gray-600">No courses found matching criteria. Try different filters.</div>';
                }

            } else {
                // FALLBACK IF API FAILS OR NO KEY
                if(spinner) spinner.classList.add('hidden');
                
                // Simple text-based filter for fallback
                const fallbackResults = coursesDB.filter(c => {
                    const matchCity = (c.city || "").toLowerCase().includes(postcode.toLowerCase());
                    const matchLevel = (userLevel === 'All') || (c.level || "").toLowerCase().includes(userLevel.toLowerCase());
                    const matchSubject = (userSubject === 'All') || (c.subject === userSubject);
                    return matchCity && matchLevel && matchSubject;
                });

                if (fallbackResults.length > 0) {
                    allSortedResults = fallbackResults.map(c => ({...c, durText: "N/A", distText: "N/A"}));
                    currentPage = 1;
                    renderPage(1);
                } else {
                     div.innerHTML = '<div class="p-4 bg-gray-50 border border-gray-200 rounded text-gray-600">No exact matches found in database.</div>';
                }
            }
        }

        function renderPage(page) {
            const div = document.getElementById('results-area');
            const pagControls = document.getElementById('pagination-controls');
            const indicator = document.getElementById('page-indicator');
            
            div.innerHTML = '';
            
            const start = (page - 1) * resultsPerPage;
            const end = start + resultsPerPage;
            const pageItems = allSortedResults.slice(start, end);

            pageItems.forEach(c => {
                div.innerHTML += createCourseCard(c, c.durText || "N/A", c.distText || "N/A");
            });

            if (pagControls && indicator && allSortedResults.length > resultsPerPage) {
                pagControls.classList.remove('hidden');
                indicator.innerText = `Page ${page} of ${Math.ceil(allSortedResults.length / resultsPerPage)}`;
            } else if (pagControls) {
                pagControls.classList.add('hidden');
            }
            
            feather.replace();
        }

        function changePage(dir) {
            const totalPages = Math.ceil(allSortedResults.length / resultsPerPage);
            const newPage = currentPage + dir;
            if (newPage > 0 && newPage <= totalPages) {
                currentPage = newPage;
                renderPage(currentPage);
            }
        }

        function createCourseCard(c, duration, distance) {
            return `
            <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">Accredited</span>
                             <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${c.title || c.courses[0] || "Course Title"}</h4>
                        
                        <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                            <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}</span>
                            <span class="flex items-center gap-1.5"><i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}</span>
                        </div>
                    </div>
                    
                    <div class="text-right sm:text-right w-full sm:w-auto flex sm:block justify-between items-center border-t sm:border-0 pt-3 sm:pt-0 border-slate-100">
                        <div>
                            <span class="block text-lg font-bold text-emerald-600">Course Open</span>
                            <span class="text-xs text-slate-400 font-medium block mt-0.5">Enrolling Now</span>
                        </div>
                        <a href="#contact" class="mt-3 bg-[#1e3a8a] text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-blue-800 transition inline-block text-center sm:ml-4">Apply</a>
                    </div>
                </div>
            </div>`;
        }

        const translations = {
            en: {
                nav_courses: "Courses", nav_team: "Advisors", nav_contact: "Contact", nav_prep: "Prep",
                nav_tagline: "We help you find the right direction",
                role_title: "Dedicated Student Advisor",
                btn_contact: "Get in Touch", btn_back: "Back to Team",
                search_title: "Search Accredited Courses", 
                lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel", btn_find: "Find",
                bio_header: "Guidance for Your Future",
                bio_intro: "Specializing in supporting students through every stage of their academic journey.",
                bio_p1: "I am Andreea Macxim, Student Advisor specializing in supporting students through every stage of their academic journey. My goal is to help students make informed decisions and successfully transition into higher education and professional life.",
                bio_quote: "My role is to guide you responsibly and help you make decisions that truly benefit your future.",
                bio_p2: "I provide calm, patient, and personalised support every step of the way - I can help you feel confident and informed throughout the process.",
                offer_title: "What I Offer:",
                list_1: "Calm, patient, and personalised support", list_2: "Informed decisions for higher education", 
                list_3: "Responsible guidance for your future", list_4: "Support through every stage", list_5: "Confidence throughout the process",
                prep_title: "Interview Preparation", prep_sub: "Master your interview skills.",
                star_t: "STAR Method", star_d: "Behavioral answers.", psych_t: "Psychometric", psych_d: "Logic tests.", case_t: "Case Studies", case_d: "Real scenarios.",
                elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance and admission.", btn_check_elig: "Answer Questions",
                lbl_q1: "1. In which city do you live?", lbl_q2: "2. What is your residency status?", lbl_q3: "3. What is your level of English?", link_duolingo_check: "Not sure about the level of english take this test",
                lbl_q4: "4. Do you have a diploma (Bac, Lvl 3, A-Levels)?", lbl_q5: "5. What type of course do you want?", lbl_q6: "6. What field do you want to study?",
                lbl_q7: "7. What is your preferred schedule?", lbl_q8: "8. Would you be willing to study in London?", btn_submit_elig: "Submit Answers",
                test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required for university admission.", btn_test: "Take Duolingo English Test",
                form_header: "Contact Me", form_sub: "Fill in the form below for guidance on your academic journey.",
                lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "How can I help?", btn_send: "Send Request"
            },
            ro: {
                nav_courses: "Cursuri", nav_team: "Consilieri", nav_contact: "Contact", nav_prep: "Pregătire",
                nav_tagline: "Te ajutăm să găsești direcția potrivită",
                role_title: "Consilier Student", btn_contact: "Contactează", btn_back: "Înapoi la Echipă",
                search_title: "Caută Cursuri Acreditate", lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport", btn_find: "Caută",
                bio_header: "Ghidare pentru Viitorul Tău",
                bio_intro: "Specializat în sprijinirea studenților în fiecare etapă a călătoriei lor academice.",
                bio_p1: "Sunt Andreea Macxim, Consilier Student specializat în sprijinirea studenților în fiecare etapă a călătoriei lor academice. Scopul meu este să ajut studenții să ia decizii informate și să facă tranziția cu succes către învățământul superior.",
                bio_quote: "Rolul meu este să te ghidez responsabil și să te ajut să iei decizii care îți vor aduce beneficii reale în viitor.",
                bio_p2: "Ofer sprijin calm, răbdător și personalizat la fiecare pas - te pot ajuta să te simți încrezător și informat pe tot parcursul procesului.",
                offer_title: "Ce Ofer:",
                list_1: "Sprijin calm, răbdător și personalizat", list_2: "Decizii informate pentru învățământul superior", 
                list_3: "Ghidare responsabilă pentru viitorul tău", list_4: "Sprijin în fiecare etapă", list_5: "Încredere pe tot parcursul procesului",
                prep_title: "Pregătire Interviu", prep_sub: "Stăpânește interviul.",
                star_t: "Metoda STAR", star_d: "Răspunsuri comportamentale.", psych_t: "Psihometric", psych_d: "Teste logice.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
                elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la câteva întrebări pentru a vedea dacă te califici.", btn_check_elig: "Răspunde la Întrebări",
                lbl_q1: "1. În ce oraș locuiești?", lbl_q2: "2. Ce status de rezidență ai?", lbl_q3: "3. Care este nivelul tău de engleză?", link_duolingo_check: "Nu ești sigur de nivelul de engleză? Fă acest test",
                lbl_q4: "4. Deții o diplomă (Bac, Level 3, A-Levels)?", lbl_q5: "5. Pentru ce fel de curs vrei să aplici?", lbl_q6: "6. Ce domeniu îți dorești să studiezi?",
                lbl_q7: "7. Ce program de studiu preferi?", lbl_q8: "8. Ai fi dispus să studiezi în Londra?", btn_submit_elig: "Trimite Răspunsurile",
                test_title: "Validează-ți Competențele de Engleză", test_desc: "Un nivel certificat de engleză este adesea necesar pentru admitere.", btn_test: "Fă Testul Duolingo",
                form_header: "Contactează-mă", form_sub: "Completează formularul pentru îndrumare academică.",
                lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Cum te pot ajuta?", btn_send: "Trimite Cerere"
            },
            pl: {
                nav_courses: "Kursy", nav_team: "Doradcy", nav_contact: "Kontakt", role_title: "Doradca Studenta",
                btn_back: "Powrót",
                search_title: "Szukaj Kursów", lbl_postcode: "Kod / Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd", btn_find: "Szukaj",
                bio_header: "Wskazówki dla Twojej Przyszłości",
                bio_intro: "Specjalizacja w wspieraniu studentów na każdym etapie ich podróży akademickiej.",
                bio_p1: "Jestem Andreea Macxim, Doradcą Studenta specjalizującym się w wspieraniu studentów na każdym etapie ich podróży akademickiej. Moim celem jest pomoc studentom w podejmowaniu świadomych decyzji i pomyślnym przejściu do szkolnictwa wyższego.",
                bio_quote: "Moją rolą jest odpowiedzialne prowadzenie Cię i pomaganie w podejmowaniu decyzji, które naprawdę przyniosą korzyści Twojej przyszłości.",
                bio_p2: "Zapewniam spokojne, cierpliwe i spersonalizowane wsparcie na każdym kroku.",
                offer_title: "Co Oferuję:",
                list_1: "Spokojne, cierpliwe wsparcie", list_2: "Świadome decyzje edukacyjne", 
                list_3: "Odpowiedzialne doradztwo", list_4: "Wsparcie na każdym etapie", list_5: "Pewność siebie w procesie",
                prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj swoje umiejętności.",
                star_t: "Metoda STAR", star_d: "Pytania behawioralne.", psych_t: "Psychometryczne", psych_d: "Logika i rozumowanie.", case_t: "Studia Przypadku", case_d: "Scenariusze.",
                elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na kilka pytań, aby sprawdzić, czy się kwalifikujesz.", btn_check_elig: "Odpowiedz na Pytania",
                lbl_q1: "1. W jakim mieście mieszkasz?", lbl_q2: "2. Jaki masz status rezydenta?", lbl_q3: "3. Jaki jest Twój poziom angielskiego?", link_duolingo_check: "Nie jesteś pewien poziomu? Zrób ten test",
                lbl_q4: "4. Czy posiadasz dyplom (Matura, Level 3)?", lbl_q5: "5. Na jaki rodzaj kursu chcesz aplikować?", lbl_q6: "6. Jaki kierunek chcesz studiować?",
                lbl_q7: "7. Preferowany harmonogram?", lbl_q8: "8. Czy chciałbyś studiować w Londynie?", btn_submit_elig: "Wyślij Odpowiedzi",
                test_title: "Potwierdź swój angielski", test_desc: "Certyfikat jest wymagany. Zrób test Duolingo online.", btn_test: "Zrób Test Duolingo",
                form_header: "Kontakt", form_sub: "Wypełnij formularz.", lbl_name: "Imię", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "W czym pomóc?", btn_send: "Wyślij"
            },
            hu: {
                nav_courses: "Tanfolyamok", nav_team: "Tanácsadók", nav_contact: "Kapcsolat", role_title: "Diáktanácsadó", btn_contact: "Lépjen kapcsolatba", btn_back: "Vissza",
                search_title: "Akkreditált Tanfolyamok", lbl_postcode: "Irányítószám / Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás", btn_find: "Keresés",
                bio_header: "Útmutatás a Jövődért", bio_intro: "A hallgatók támogatására szakosodva.",
                bio_p1: "Andreea Macxim vagyok, diáktanácsadó. Célom, hogy segítsem a diákokat a tájékozott döntések meghozatalában.",
                bio_quote: "Szerepem az, hogy felelősségteljesen vezesselek, és segítsek olyan döntéseket hozni, amelyek a jövődet szolgálják.",
                bio_p2: "Nyugodt, türelmes és személyre szabott támogatást nyújtok.",
                offer_title: "Amit Kínálok:",
                list_1: "Nyugodt támogatás", list_2: "Tájékozott döntések", list_3: "Felelősségteljes útmutatás", 
                list_4: "Támogatás minden szakaszban", list_5: "Magabiztosság",
                prep_title: "Interjú Felkészülés", prep_sub: "Sajátítsa el az interjú készségeket.",
                star_t: "STAR Módszer", star_d: "Viselkedési kérdések.", psych_t: "Pszichometriai", psych_d: "Logika.", case_t: "Esettanulmányok", case_d: "Forgatókönyvek.",
                elig_title: "Jogosultság Ellenőrzése", elig_desc: "Válaszoljon néhány kérdésre.", btn_check_elig: "Válaszadás",
                lbl_q1: "1. Melyik városban élsz?", lbl_q2: "2. Milyen a tartózkodási státuszod?", lbl_q3: "3. Milyen szintű az angol tudásod?", link_duolingo_check: "Nem biztos a szintjében? Végezze el ezt a tesztet",
                lbl_q4: "4. Van diplomád (Érettségi, Level 3)?", lbl_q5: "5. Milyen típusú kurzust szeretnél?", lbl_q6: "6. Mit szeretnél tanulni?",
                lbl_q7: "7. Preferált időbeosztás?", lbl_q8: "8. Hajlandó lennél Londonban tanulni?", btn_submit_elig: "Válaszok Küldése",
                test_title: "Igazold Angol Tudásod", test_desc: "Tanúsítvány szükséges.", btn_test: "Duolingo Teszt",
                form_header: "Kapcsolat", form_sub: "Töltse ki az űrlapot.", lbl_name: "Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Üzenet", btn_send: "Küldés"
            },
            es: {
                nav_courses: "Cursos", nav_team: "Asesores", nav_contact: "Contacto", role_title: "Asesor Estudiantil", btn_contact: "Contáctame", btn_back: "Volver",
                search_title: "Buscar Cursos", lbl_postcode: "Código / Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje", btn_find: "Buscar",
                bio_header: "Orientación para tu Futuro", bio_intro: "Especializada en apoyar a los estudiantes.",
                bio_p1: "Soy Andreea Macxim, Asesora Estudiantil. Mi objetivo es ayudar a los estudiantes a tomar decisiones informadas.",
                bio_quote: "Mi papel es guiarte responsablemente y ayudarte a tomar decisiones que beneficien tu futuro.",
                bio_p2: "Ofrezco apoyo tranquilo, paciente y personalizado.",
                offer_title: "Lo que Ofrezco:",
                list_1: "Apoyo tranquilo", list_2: "Decisiones informadas", list_3: "Orientación responsable", 
                list_4: "Apoyo en cada etapa", list_5: "Confianza",
                prep_title: "Preparación Entrevista", prep_sub: "Domina tus habilidades.",
                star_t: "Método STAR", star_d: "Comportamiento.", psych_t: "Psicométrico", psych_d: "Lógica.", case_t: "Casos de Estudio", case_d: "Escenarios.",
                elig_title: "Verificar Elegibilidad", elig_desc: "Responde algunas preguntas.", btn_check_elig: "Responder",
                lbl_q1: "1. ¿En qué ciudad vives?", lbl_q2: "2. ¿Cuál es tu estado de residencia?", lbl_q3: "3. ¿Cuál es tu nivel de inglés?", link_duolingo_check: "¿No estás seguro del nivel? Haz esta prueba",
                lbl_q4: "4. ¿Tienes un diploma?", lbl_q5: "5. ¿Qué tipo de curso deseas?", lbl_q6: "6. ¿Qué campo deseas estudiar?",
                lbl_q7: "7. ¿Horario preferido?", lbl_q8: "8. ¿Estarías dispuesto a estudiar en Londres?", btn_submit_elig: "Enviar",
                test_title: "Valida tu Inglés", test_desc: "Se requiere certificado.", btn_test: "Test Duolingo",
                form_header: "Contacto", form_sub: "Rellena el formulario.", lbl_name: "Nombre", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Mensaje", btn_send: "Enviar"
            },
            it: {
                nav_courses: "Corsi", nav_team: "Advisor", nav_contact: "Contatti", role_title: "Consulente Studente", btn_contact: "Contattami", btn_back: "Indietro",
                search_title: "Cerca Corsi", lbl_postcode: "CAP / Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio", btn_find: "Cerca",
                bio_header: "Guida per il Tuo Futuro", bio_intro: "Specializzata nel supporto agli studenti.",
                bio_p1: "Sono Andreea Macxim, Consulente Studentesco. Il mio obiettivo è aiutare gli studenti a prendere decisioni informate.",
                bio_quote: "Il mio ruolo è guidarti responsabilmente.",
                bio_p2: "Offro supporto calmo, paziente e personalizzato.",
                offer_title: "Cosa Offro:",
                list_1: "Supporto calmo", list_2: "Decisioni informate", list_3: "Guida responsabile", 
                list_4: "Supporto completo", list_5: "Fiducia",
                prep_title: "Preparazione Colloquio", prep_sub: "Migliora le tue abilità.",
                star_t: "Metodo STAR", star_d: "Comportamentale.", psych_t: "Psicometrico", psych_d: "Logica.", case_t: "Casi Studio", case_d: "Scenari.",
                elig_title: "Verifica Idoneità", elig_desc: "Rispondi a poche domande.", btn_check_elig: "Rispondi",
                lbl_q1: "1. In quale città vivi?", lbl_q2: "2. Qual è il tuo stato di residenza?", lbl_q3: "3. Qual è il tuo livello di inglese?", link_duolingo_check: "Non sei sicuro del livello? Fai questo test",
                lbl_q4: "4. Hai un diploma?", lbl_q5: "5. Che tipo di corso desideri?", lbl_q6: "6. Cosa vuoi studiare?",
                lbl_q7: "7. Orario preferito?", lbl_q8: "8. Saresti disposto a studiare a Londra?", btn_submit_elig: "Invia",
                test_title: "Convalida il tuo Inglese", test_desc: "Certificato richiesto.", btn_test: "Test Duolingo",
                form_header: "Contatti", form_sub: "Compila il modulo.", lbl_name: "Nome", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Messaggio", btn_send: "Invia"
            },
            pt: {
                nav_courses: "Cursos", nav_team: "Consultores", nav_contact: "Contato", role_title: "Consultor Estudantil", btn_contact: "Contacte-me", btn_back: "Voltar",
                search_title: "Buscar Cursos", lbl_postcode: "Código / Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem", btn_find: "Buscar",
                bio_header: "Orientação para o Seu Futuro", bio_intro: "Especializada em apoiar alunos.",
                bio_p1: "Sou Andreea Macxim, Consultora Estudantil. Meu objetivo é ajudar os alunos a tomar decisões informadas.",
                bio_quote: "Meu papel é guiá-lo de forma responsável.",
                bio_p2: "Forneço apoio calmo, paciente e personalizado.",
                offer_title: "O que Ofereço:",
                list_1: "Apoio calmo", list_2: "Decisões informadas", list_3: "Orientação responsável", 
                list_4: "Apoio total", list_5: "Confiança",
                prep_title: "Preparação Entrevista", prep_sub: "Domine suas habilidades.",
                star_t: "Método STAR", star_d: "Comportamental.", psych_t: "Psicométrico", psych_d: "Lógica.", case_t: "Estudos de Caso", case_d: "Cenários.",
                elig_title: "Verificar Elegibilidade", elig_desc: "Responda algumas perguntas.", btn_check_elig: "Responder",
                lbl_q1: "1. Em que cidade você mora?", lbl_q2: "2. Qual é o seu status de residência?", lbl_q3: "3. Qual é o seu nível de inglês?", link_duolingo_check: "Não tem certeza do nível? Faça este teste",
                lbl_q4: "4. Você tem um diploma?", lbl_q5: "5. Que tipo de curso você quer?", lbl_q6: "6. O que quer estudar?",
                lbl_q7: "7. Horário preferido?", lbl_q8: "8. Estaria disposto a estudar em Londres?", btn_submit_elig: "Enviar",
                test_title: "Valide seu Inglês", test_desc: "Certificado necessário.", btn_test: "Teste Duolingo",
                form_header: "Contato", form_sub: "Preencha o formulário.", lbl_name: "Nome", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Mensagem", btn_send: "Enviar"
            },
            el: {
                nav_courses: "Μαθήματα", nav_team: "Σύμβουλοι", nav_contact: "Επαφή", role_title: "Σύμβουλος Φοιτητών", btn_contact: "Επικοινωνία", btn_back: "Πίσω",
                search_title: "Αναζήτηση Μαθημάτων", lbl_postcode: "ΤΚ / Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι", btn_find: "Εύρεση",
                bio_header: "Καθοδήγηση για το Μέλλον", bio_intro: "Ειδίκευση στην υποστήριξη φοιτητών.",
                bio_p1: "Είμαι η Andreea Macxim, Σύμβουλος Φοιτητών. Στόχος μου είναι να βοηθήσω τους φοιτητές.",
                bio_quote: "Ο ρόλος μου είναι να σας καθοδηγήσω υπεύθυνα.",
                bio_p2: "Παρέχω ήρεμη υποστήριξη.",
                offer_title: "Τι Προσφέρω:",
                list_1: "Ήρεμη υποστήριξη", list_2: "Ενημερωμένες αποφάσεις", list_3: "Υπεύθυνη καθοδήγηση", 
                list_4: "Υποστήριξη παντού", list_5: "Εμπιστοσύνη",
                prep_title: "Προετοιμασία Συνέντευξης", prep_sub: "Βελτιώστε τις δεξιότητές σας.",
                star_t: "Μέθοδος STAR", star_d: "Συμπεριφορά.", psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική.", case_t: "Μελέτες Περίπτωσης", case_d: "Σενάρια.",
                elig_title: "Έλεγχος Επιλεξιμότητας", elig_desc: "Απαντήστε σε ερωτήσεις.", btn_check_elig: "Απάντηση",
                test_title: "Αγγλικά", test_desc: "Απαιτείται πιστοποίηση.", btn_test: "Τεστ Duolingo",
                form_header: "Επαφή", form_sub: "Συμπληρώστε τη φόρμα.", lbl_name: "Όνομα", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Μήνυμα", btn_send: "Αποστολή"
            },
            bg: {
                nav_courses: "Курсове", nav_team: "Съветници", nav_contact: "Контакт", role_title: "Студентски Съветник", btn_contact: "Контакт", btn_back: "Назад",
                search_title: "Търсене на Курсове", lbl_postcode: "ПК / Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Пътуване", btn_find: "Търси",
                bio_header: "Насоки за Бъдещето", bio_intro: "Специализирана в подкрепата на студенти.",
                bio_p1: "Аз съм Андреа Макксим, студентски съветник.",
                bio_quote: "Моята роля е да ви напътствам отговорно.",
                bio_p2: "Предоставям спокойна подкрепа.",
                offer_title: "Какво Предлагам:",
                list_1: "Спокойна подкрепа", list_2: "Информирани решения", list_3: "Отговорни насоки", 
                list_4: "Пълна подкрепа", list_5: "Увереност",
                prep_title: "Подготовка за Интервю", prep_sub: "Усъвършенствайте уменията си.",
                star_t: "Метод STAR", star_d: "Поведение.", psych_t: "Оценка на Способности", psych_d: "Логика.", case_t: "Казуси", case_d: "Сценарии.",
                elig_title: "Проверка на Допустимост", elig_desc: "Отговорете на въпроси.", btn_check_elig: "Отговори",
                test_title: "Английски", test_desc: "Изисква се сертификат.", btn_test: "Тест Duolingo",
                form_header: "Контакт", form_sub: "Попълнете формата.", lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Съобщение", btn_send: "Изпрати"
            }
        };

        function changeLanguage(lang) {
            const t = translations[lang] || translations['en'];
            document.querySelectorAll('[data-key]').forEach(el => {
                const k = el.getAttribute('data-key');
                if(t[k]) {
                    if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                    else el.textContent = t[k];
                }
            });
        }
    </script>

</body>
</html>
