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
$jsonErrors = [];

foreach ($jsonFiles as $file) {
    $filePath = $baseDir . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $allCourses = array_merge($allCourses, $data);
        } else {
            $jsonErrors[] = "Error loading $file: " . json_last_error_msg();
        }
    }
}

$coursesJson = json_encode($allCourses);
$phpErrorsJson = json_encode($jsonErrors);


$web3FormsKey = "{your api here}"
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carmen Alexandra Mihaila | Student Advisor</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($googleMapsKey); ?>&libraries=geometry" async defer></script>
    <?php endif; ?>
    
    <style>
        
        :root {
            --primary: #1e3a8a; /* Oxford Blue */
            --accent: #2563eb;  /* Brighter Blue */
            --coral: #ff7f7f;   /* Accent Color */
            --text-main: #1e293b;
            --border-color: #e2e8f0;
        }
        
        body { font-family: 'Lato', sans-serif; color: var(--text-main); overflow-x: hidden; position: relative; }
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }
        
        #bg-fixed { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png'); background-position: center center; background-repeat: no-repeat; background-size: cover; }
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); }
        
        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* CARDS & INPUTS */
        .content-card { background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; background: #ffffff; }
        
        
        .form-sublabel { font-size: 0.8rem; color: #64748b; font-weight: 400; margin-left: 5px; }
        .checkbox-group { margin-bottom: 25px; }
        .checkbox-grid { display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: 10px; }
        @media (min-width: 640px) { .checkbox-grid { grid-template-columns: 1fr 1fr; } }
        .checkbox-item { display: flex; align-items: center; gap: 10px; font-size: 0.95rem; background: #f8fafc; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
        .checkbox-item:hover { background-color: #f1f5f9; border-color: var(--primary); }
        .trust-box { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 20px; border-radius: 8px; text-align: center; margin: 30px 0; display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .closing-msg { text-align: center; font-style: italic; color: var(--primary); margin-top: 20px; font-weight: 600; }

        .btn-blue { background-color: var(--primary); color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700; transition: transform 0.2s, background-color 0.2s; display: inline-block; cursor: pointer; text-align: center; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }
        .btn-outline-blue { background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 10px 28px; border-radius: 8px; font-weight: 700; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-blue:hover { background: var(--primary); color: white; }

        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-content { background: white; width: 100%; max-width: 600px; border-radius: 1rem; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        #mobile-menu { display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; flex-direction: column; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 40; animation: slideDown 0.3s ease-out; }
        #mobile-menu.active { display: flex; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        footer { background: #ffffff; color: var(--text-main); border-top: 1px solid var(--border-color); }
        
        .pagination-btn { padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; font-weight: 600; color: #334155; transition: all 0.2s; }
        .pagination-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }
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
                <span class="text-sm font-medium text-gray-700">
        We help you find the right direction
    </span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" 
onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
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
                    <img src="<?php echo get_template_directory_uri(); ?>/images/CarmenMihaila.jpg" alt="Carmen Alexandra Mihaila" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Carmen Alexandra Mihaila</h1>
                    <p class="font-bold tracking-widest uppercase mb-6 text-[#ff7f7f]" data-key="role_title">Dedicated Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6">
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 0743 710 0497
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> carmen.mihaila@ask33.co.uk
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
                    <button id="toggle-search-btn" onclick="document.getElementById('search-container').classList.toggle('hidden')" class="text-sm text-[#1e3a8a] underline">Hide Search</button>
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
                        <label class="text-xs font-bold uppercase mb-2 block text-gray-500" data-key="lbl_level">Level</label>
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
                        <label class="text-xs font-bold uppercase mb-2 block text-gray-500" data-key="lbl_subject">Subject</label>
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
                    
                     <div id="loading-spinner" class="hidden mt-6 text-blue-600 font-bold animate-pulse">Searching...</div>
            
            <div id="results-area" class="mt-8 space-y-4 text-left"></div>
            
            <div id="pagination-controls" class="hidden mt-6 flex justify-center gap-4">
                <button onclick="changePage(-1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition">Previous</button>
                <span id="page-indicator" class="px-4 py-2 font-bold text-gray-700">Page 1</span>
                <button onclick="changePage(1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition">Next</button>
            </div>
            
        </div>
    </section>


        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">About Me</h2>
                    <p class="text-slate-500 mt-2" data-key="hobby_header">Dedicated to Your Success</p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I am a dedicated Student Advisor with previous experience as a Social Worker Assistant and Carer, where I supported individuals from diverse backgrounds with personal, academic, and emotional challenges. These roles helped me develop strong skills in communication, empathy, active listening, and person-centred support.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"My approach is professional, approachable, and student-focused. I aim to create a supportive and confidential environment where students feel comfortable seeking advice and guidance."</p>
                        </div>
                        
                        <p data-key="bio_p2">I am also a 4th-year student at Global Banking School, which allows me to understand first-hand the academic pressures, expectations, and challenges students face. This dual perspective enables me to offer practical, relatable, and informed guidance.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">How I Can Help You:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_1">Academic guidance and decision-making</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_2">Managing personal and academic challenges</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_3">Adapting to higher education life</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_4">Accessing appropriate university resources</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_5">Supportive and confidential environment</span></li>
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
                <button onclick="document.getElementById('eligibility-modal').style.display='flex'" class="btn-blue shadow-lg hover:-translate-y-1 transition" data-key="btn_check_elig">Answer Questions</button>
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
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Need guidance or support?</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Fill in the form below and I’ll get back to you to discuss how I can support you. All enquiries are confidential.</p>
                    
                    <form id="carmen-contact-form" action="https://api.web3forms.com/submit" method="POST">
                        
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                        <input type="hidden" name="subject" value="New Contact for Carmen Mihaila">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_name">Full Name <span class="form-sublabel" data-key="sub_name">(Please enter your full name)</span></label>
                                <input type="text" name="name" class="input-standard" required>
                            </div>
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_email">Email Address <span class="form-sublabel" data-key="sub_email">(So I can contact you)</span></label>
                                <input type="email" name="email" class="input-standard" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_phone">Phone Number <span class="form-sublabel" data-key="sub_phone">(Optional)</span></label>
                                <input type="tel" name="phone" class="input-standard">
                            </div>
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_inst">Institution <span class="form-sublabel" data-key="sub_inst">(e.g. GBS)</span></label>
                                <input type="text" name="institution" class="input-standard" data-placeholder="ph_inst" placeholder="e.g. GBS">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_course">Course / Programme <span class="form-sublabel" data-key="sub_course">(e.g. Business)</span></label>
                                <input type="text" name="course" class="input-standard" data-placeholder="ph_course" placeholder="e.g. Business">
                            </div>
                            <div class="form-group">
                                <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_year">Year of Study</label>
                                <select name="year" class="input-standard">
                                    <option data-key="opt_found" value="Foundation">Foundation</option>
                                    <option data-key="opt_y1" value="Year 1">Year 1</option>
                                    <option data-key="opt_y2" value="Year 2">Year 2</option>
                                    <option data-key="opt_y3" value="Year 3">Year 3</option>
                                    <option data-key="opt_y4" value="Year 4">Year 4</option>
                                </select>
                            </div>
                        </div>

                        <div class="checkbox-group mb-6">
                            <label class="block text-xs font-bold uppercase mb-2" data-key="lbl_reason">What would you like support with? <span class="form-sublabel" data-key="sub_reason">(Select all that apply)</span></label>
                            <div class="checkbox-grid">
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="Academic guidance"> <span data-key="chk_1">Academic guidance</span></label>
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="Managing workload"> <span data-key="chk_2">Managing workload</span></label>
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="Personal concerns"> <span data-key="chk_3">Personal concerns</span></label>
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="Motivation & Focus"> <span data-key="chk_4">Motivation & Focus</span></label>
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="University processes"> <span data-key="chk_5">University processes</span></label>
                                <label class="checkbox-item"><input type="checkbox" name="support[]" value="Future planning"> <span data-key="chk_6">Future planning</span></label>
                            </div>
                        </div>

                        <div class="form-group mb-6">
                            <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_open">How can I support you? <span class="form-sublabel" data-key="sub_open">(Briefly describe your situation)</span></label>
                            <textarea name="message" rows="4" class="input-standard" data-placeholder="ph_msg" placeholder="e.g. I need help with..."></textarea>
                        </div>

                        <div class="trust-box">
                            <i class="fa-solid fa-shield-heart text-2xl mb-2"></i>
                            <div>
                                <strong data-key="trust_title">Confidential & Supportive</strong>
                                <p style="font-size:0.9rem; margin:0;" data-key="trust_desc">Your information will be kept confidential. I provide a safe, non-judgmental, and supportive space for all students.</p>
                            </div>
                        </div>

                        <button type="submit" id="submit-btn" class="btn-blue w-full text-lg flex justify-center items-center gap-2">
                            <span id="btn-text" data-key="btn_cta">Request Support</span>
                            <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                        <div class="closing-msg" data-key="closing">You don’t have to face your academic challenges alone. Support is available — take the first step today.</div>
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
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]" data-key="elig_title">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="Eligibility Check - Carmen Mihaila">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Town</label>
                        <input type="text" name="city" class="input-standard" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q2">2. Residency Status</label>
                        <select name="residency" class="input-standard">
                            <option>Pre-settle (Working)</option><option>Pre-settle (Not Working)</option><option>Settle Status</option><option>British Citizen</option><option>Refugee</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q3">3. English Level</label>
                        <select name="english_level" class="input-standard">
                            <option>Basic</option><option>Medium</option><option>Conversational</option><option>Advanced</option><option>None</option>
                        </select>
                        <div class="mt-2 text-center"><a href="https://englishtest.duolingo.com/applicants" target="_blank" class="text-[#1e3a8a] underline text-xs font-bold" data-key="link_duolingo_check">Not sure about the level? Take this test</a></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q4">4. Diploma (Bac, Lvl 3, A-Levels)</label>
                        <input type="text" name="diploma" class="input-standard" placeholder="Yes/No">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q5">5. Course Type</label>
                        <select name="course_type" class="input-standard">
                            <option>Undergraduate</option><option>Postgraduate (Master)</option><option>Second Degree</option><option>Full Online</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q6">6. Field of Study</label>
                        <input type="text" name="field" class="input-standard" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q7">7. Schedule</label>
                        <select name="schedule" class="input-standard">
                            <option>2 Days x 4h</option><option>1 Day Online / 1 Day Campus</option><option>Weekend</option><option>Evening</option><option>Mix</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q8">8. London?</label>
                        <select name="london" class="input-standard"><option>Yes</option><option>No</option></select>
                    </div>

                    <button type="submit" class="w-full btn-blue" data-key="btn_submit_elig">Submit Answers</button>
                </div>
            </form>
        </div>
    </div>

  <footer class="bg-gray-100 text-gray-500 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-red-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('active')) {
            menu.classList.remove('active');
        } else {
            menu.classList.add('active');
        }
    }

        async function handleSearch(e) {
            e.preventDefault();
            
            const userLocation = document.getElementById('user-postcode').value.trim().toLowerCase();
            const userMode = document.getElementById('user-mode').value;
            const userLevel = document.getElementById('user-level').value;
            const userSubject = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            const pagControls = document.getElementById('pagination-controls');

            if(!userLocation && userMode !== 'Online' && userMode !== 'All') {
                return alert("Please enter a City or select 'Online' as your study mode.");
            }

            div.innerHTML = '';
            spinner.classList.remove('hidden');
            if(pagControls) pagControls.classList.add('hidden');
            allSortedResults = []; 

            setTimeout(() => {
                let rawResults = coursesDB.filter(course => {
                    
                    // A. Mode Match (Campus vs Online)
                    const dbMode = (course.mode || course.study_program || course.title || "").toLowerCase();
                    let isModeMatch = true;
                    
                    if (userMode === "Campus") {
                        isModeMatch = !dbMode.includes("online") && !dbMode.includes("distance") && !dbMode.includes("self");
                    } else if (userMode === "Online") {
                        isModeMatch = dbMode.includes("online") || dbMode.includes("distance") || dbMode.includes("self");
                    }

                    // B. City Match (Ignore city if looking for Online courses)
                    let isLocationMatch = true;
                    if (userLocation !== "" && userMode !== "Online") {
                        const courseCity = (course.city || "").toLowerCase();
                        const courseAddress = (course.address || "").toLowerCase();
                        isLocationMatch = courseCity.includes(userLocation) || courseAddress.includes(userLocation);
                    }

                    // C. Level Match
                    const dbLevel = (course.level || "").toLowerCase();
                    const selLevel = userLevel.toLowerCase();
                    const isLevelMatch = (userLevel === 'All') || 
                                         (dbLevel.includes(selLevel)) || 
                                         (selLevel === "year 1" && dbLevel.includes("level 4")) ||
                                         (selLevel === "year 2" && dbLevel.includes("level 5")) ||
                                         (selLevel === "top-up" && dbLevel.includes("level 6")) ||
                                         (selLevel === "master" && (dbLevel.includes("master") || dbLevel.includes("level 7")));

                    // D. Subject Match
                    const isSubjectMatch = (userSubject === 'All') || (course.subject === userSubject);

                    return isLocationMatch && isLevelMatch && isSubjectMatch && isModeMatch;
                });

                const seen = new Set();
                allSortedResults = rawResults.filter(course => {
                    const courseTitle = course.title || course.courses[0] || "Course";
                    const courseCity = course.city || "Campus";
                    const uniqueKey = `${courseTitle.toLowerCase()}-${course.level}-${courseCity.toLowerCase()}`;
                    
                    if (seen.has(uniqueKey)) {
                        return false; 
                    } else {
                        seen.add(uniqueKey);
                        return true; 
                    }
                });

                spinner.classList.add('hidden');

                if (allSortedResults.length > 0) {
                    currentPage = 1;
                    renderPage(1);
                } else {
                    div.innerHTML = `
                    <div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">
                        <p class="font-bold text-lg mb-2">No courses found matching your criteria.</p>
                        <p class="text-sm">Try adjusting your filters, searching for a different city, or selecting Online learning.</p>
                    </div>`;
                }
            }, 600); 
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
                 const courseTitle = c.title || c.courses[0] || "Course";
                 const safeTitle = courseTitle.replace(/'/g, "\\'");

                 div.innerHTML += `
                <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">Accredited Course</span>
                                <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                            </div>
                            <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${courseTitle}</h4>
                            <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                                <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}</span>
                                <span class="flex items-center gap-1.5"><i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}</span>
                            </div>
                        </div>
                        <div class="text-right sm:text-right w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between border-t sm:border-0 pt-3 sm:pt-0 border-slate-100 mt-2 sm:mt-0">
                            <div class="mb-0 sm:mb-3 text-left sm:text-right"><span class="block text-lg font-bold text-emerald-600">Available</span></div>
                            <a href="#contact" onclick="document.querySelector('textarea[name=\\'message\\']').value = 'I am interested in applying for: ${safeTitle} (${c.level}). Please contact me details.';" class="btn-blue text-xs px-6 py-2 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5" style="display:inline-flex; align-items:center;">Apply Now</a>
                        </div>
                    </div>
                </div>`;
            });

            if (pagControls) {
                if (allSortedResults.length > resultsPerPage) {
                    pagControls.classList.remove('hidden');
                    indicator.innerText = `Page ${page} of ${Math.ceil(allSortedResults.length / resultsPerPage)}`;
                } else {
                    pagControls.classList.add('hidden');
                }
            }
            feather.replace();
        }

        function changePage(dir) {
            const totalPages = Math.ceil(allSortedResults.length / resultsPerPage);
            const newPage = currentPage + dir;
            if (newPage > 0 && newPage <= totalPages) {
                currentPage = newPage;
                renderPage(currentPage);
                document.getElementById('course-search').scrollIntoView({ behavior: 'smooth' });
            }
        }
    const translations = {
        en: {
            nav_courses: "Courses", nav_team: "Advisors", nav_contact: "Contact", nav_prep: "Prep",
            nav_tagline: "We help you find the right direction",
            role_title: "Dedicated Student Advisor",
            btn_contact: "Get in Touch", btn_back: "Back to Team",
            search_title: "Search Accredited Courses", 
            lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel", btn_find: "Find",

            // Bio
            bio_header: "About Me", hobby_header: "Dedicated to Your Success",
            bio_p1: "I am a dedicated Student Advisor with previous experience as a Social Worker Assistant and Carer, where I supported individuals from diverse backgrounds with personal, academic, and emotional challenges. These roles helped me develop strong skills in communication, empathy, active listening, and person-centred support.",
            bio_p2: "I am also a 4th-year student at Global Banking School, which allows me to understand first-hand the academic pressures, expectations, and challenges students face. This dual perspective enables me to offer practical, relatable, and informed guidance.",
            bio_quote: "\"My approach is professional, approachable, and student-focused. I aim to create a supportive and confidential environment where students feel comfortable seeking advice and guidance.\"",
            
            // Offer
            offer_title: "How I Can Help You:",
            list_1: "Academic guidance and decision-making",
            list_2: "Managing personal and academic challenges",
            list_3: "Adapting to higher education life",
            list_4: "Accessing appropriate university resources",
            list_5: "Supportive and confidential environment",

            // Prep
            prep_title: "Interview Preparation", prep_sub: "Master your interview skills.",
            star_t: "STAR Method", star_d: "Behavioral answers.", psych_t: "Ability Assessment", psych_d: "Logic & reasoning.", case_t: "Case Studies", case_d: "Real scenarios.",

            // Eligibility
            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance and admission.", btn_check_elig: "Answer Questions",
            lbl_q1: "1. In which city do you live?", lbl_q2: "2. What is your residency status?", lbl_q3: "3. What is your level of English?", link_duolingo_check: "Not sure about the level of english take this test",
            lbl_q4: "4. Do you have a diploma (Bac, Lvl 3, A-Levels)?", lbl_q5: "5. What type of course do you want?", lbl_q6: "6. What field do you want to study?",
            lbl_q7: "7. What is your preferred schedule?", lbl_q8: "8. Would you be willing to study in London?", btn_submit_elig: "Submit Answers",

            // Test
            test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required for university admission.", btn_test: "Take Duolingo English Test",

            // DETAILED FORM
            form_header: "Need guidance or support?", 
            form_sub: "Fill in the form below and I’ll get back to you to discuss how I can support you. All enquiries are confidential.",
            lbl_name: "Full Name", sub_name: "(Please enter your full name)",
            lbl_email: "Email Address", sub_email: "(So I can contact you)",
            lbl_phone: "Phone Number", sub_phone: "(Optional)",
            
            lbl_inst: "Institution", sub_inst: "(e.g. GBS)", ph_inst: "e.g. GBS",
            lbl_course: "Course / Programme", sub_course: "(e.g. Business)", ph_course: "e.g. Business",
            
            lbl_year: "Year of Study", 
            opt_found: "Foundation", opt_y1: "Year 1", opt_y2: "Year 2", opt_y3: "Year 3", opt_y4: "Year 4",
            
            lbl_reason: "What would you like support with?", sub_reason: "(Select all that apply)",
            chk_1: "Academic guidance", chk_2: "Managing workload", chk_3: "Personal concerns", 
            chk_4: "Motivation & Focus", chk_5: "University processes", chk_6: "Future planning",
            
            lbl_open: "How can I support you?", sub_open: "(Briefly describe your situation)", ph_msg: "e.g. I need help with...",
            
            trust_title: "Confidential & Supportive", trust_desc: "Your information will be kept confidential. I provide a safe, non-judgmental, and supportive space.",
            btn_cta: "Request Support", closing: "You don’t have to face your academic challenges alone. Support is available."
        },

        ro: {
            nav_courses: "Cursuri", nav_team: "Consilieri", nav_contact: "Contact", nav_prep: "Pregătire",
            nav_tagline: "Te ajutăm să găsești direcția potrivită",
            role_title: "CONSILIER STUDENT DEDICAT", btn_contact: "Contactează", btn_back: "Înapoi la Echipă",
            search_title: "Caută Cursuri Acreditate", lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport", btn_find: "Caută",
            
            bio_header: "Despre Mine", hobby_header: "Dedicat Succesului Tău",
            bio_p1: "Sunt un Consilier Student dedicat, cu experiență anterioară ca Asistent Social și Îngrijitor, unde am sprijinit persoane din medii diverse cu provocări personale și academice. Aceste roluri m-au ajutat să dezvolt abilități puternice de comunicare și empatie.",
            bio_p2: "Sunt, de asemenea, studentă în anul 4 la Global Banking School, ceea ce îmi permite să înțeleg direct presiunile academice și așteptările cu care se confruntă studenții.",
            bio_quote: "\"Abordarea mea este profesională și axată pe student. Ofer un mediu de susținere și confidențial.\"",

            offer_title: "Cum te pot ajuta:",
            list_1: "Îndrumare academică și luarea deciziilor", list_2: "Gestionarea provocărilor personale", 
            list_3: "Adaptarea la viața universitară", list_4: "Accesarea resurselor universitare", list_5: "Mediu de susținere și confidențial",

            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește interviul.", star_t: "Metoda STAR", star_d: "Răspunsuri comportamentale.", psych_t: "Evaluare Abilități", psych_d: "Teste logice.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la câteva întrebări.", btn_check_elig: "Răspunde",
            lbl_q1: "1. În ce oraș locuiești?", lbl_q2: "2. Ce status de rezidență ai?", lbl_q3: "3. Nivel Engleză?", link_duolingo_check: "Nu ești sigur?",
            lbl_q4: "4. Diplomă?", lbl_q5: "5. Tip Curs?", lbl_q6: "6. Domeniu?", lbl_q7: "7. Program?", lbl_q8: "8. Londra?", btn_submit_elig: "Trimite",
            test_title: "Validează Competențele", test_desc: "Nivel certificat necesar.", btn_test: "Test Duolingo",
            
            form_header: "Ai nevoie de îndrumare?", form_sub: "Completează formularul. Toate cererile sunt confidențiale.",
            lbl_name: "Nume Complet", sub_name: "(Nume)", lbl_email: "Email", sub_email: "(Contact)", lbl_phone: "Telefon", sub_phone: "(Opțional)",
            lbl_inst: "Instituție", sub_inst: "(ex. GBS)", ph_inst: "ex. GBS", lbl_course: "Curs", sub_course: "(ex. Afaceri)", ph_course: "ex. Afaceri",
            lbl_year: "An", opt_found: "Pregătitor", opt_y1: "An 1", opt_y2: "An 2", opt_y3: "An 3", opt_y4: "An 4",
            lbl_reason: "Sprijin cu?", sub_reason: "(Alege)", chk_1: "Îndrumare", chk_2: "Volum muncă", chk_3: "Personal", chk_4: "Motivație", chk_5: "Procese", chk_6: "Viitor",
            lbl_open: "Cum te ajut?", sub_open: "(Descrie)", ph_msg: "Am nevoie...", trust_title: "Confidențial", trust_desc: "Informațiile rămân sigure.", btn_cta: "Solicită Sprijin", closing: "Nu ești singur."
        },

        pl: {
            nav_courses: "Kursy", nav_team: "Doradcy", nav_contact: "Kontakt", nav_prep: "Przygotowanie",
            nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek", role_title: "ODDANY DORADCA STUDENTA", btn_contact: "Skontaktuj się", btn_back: "Powrót",
            search_title: "Szukaj Kursów", lbl_postcode: "Kod / Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd", btn_find: "Szukaj",
            
            bio_header: "O Mnie", hobby_header: "Dedykowany Twojemu Sukcesowi",
            bio_p1: "Jestem oddanym Doradcą Studenta z doświadczeniem jako Asystent Pracownika Socjalnego i Opiekun, gdzie wspierałam osoby z różnych środowisk w wyzwaniach osobistych i akademickich.",
            bio_p2: "Jestem również studentką 4 roku w Global Banking School, co pozwala mi zrozumieć z pierwszej ręki presję akademicką i oczekiwania.",
            bio_quote: "\"Moje podejście jest profesjonalne i skoncentrowane na studencie. Tworzę poufne środowisko.\"",
            offer_title: "Jak mogę pomóc:", list_1: "Poradnictwo akademickie", list_2: "Zarządzanie wyzwaniami", list_3: "Adaptacja do studiów", list_4: "Dostęp do zasobów", list_5: "Poufne środowisko",
            
            prep_title: "Przygotowanie", prep_sub: "Opanuj rozmowę.", star_t: "STAR", star_d: "Zachowanie.", psych_t: "Ocena Umiejętności", psych_d: "Logika.", case_t: "Studium", case_d: "Scenariusze.",
            elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Sprawdź",
            lbl_q1: "1. Miasto?", lbl_q2: "2. Status?", lbl_q3: "3. Angielski?", link_duolingo_check: "Test?", lbl_q4: "4. Dyplom?", lbl_q5: "5. Kurs?", lbl_q6: "6. Kierunek?", lbl_q7: "7. Harmonogram?", lbl_q8: "8. Londyn?", btn_submit_elig: "Wyślij",
            test_title: "Potwierdź angielski", test_desc: "Certyfikat wymagany.", btn_test: "Zrób Test",
            
            form_header: "Potrzebujesz wsparcia?", form_sub: "Wypełnij formularz. Wszystko jest poufne.", 
            lbl_name: "Imię", sub_name: "(Pełne)", lbl_email: "Email", sub_email: "(Kontakt)", lbl_phone: "Telefon", sub_phone: "(Opcja)",
            lbl_inst: "Instytucja", ph_inst: "np. GBS", lbl_course: "Kierunek", ph_course: "np. Biznes", lbl_year: "Rok", opt_found: "Zerowy", opt_y1: "Rok 1", opt_y2: "Rok 2", opt_y3: "Rok 3", opt_y4: "Rok 4",
            lbl_reason: "W czym pomóc?", sub_reason: "(Wybierz)", chk_1: "Poradnictwo", chk_2: "Obciążenie", chk_3: "Osobiste", chk_4: "Motywacja", chk_5: "Procesy", chk_6: "Przyszłość",
            lbl_open: "Jak pomóc?", sub_open: "(Opis)", ph_msg: "Potrzebuję...", trust_title: "Poufność", trust_desc: "Bezpiecznie.", btn_cta: "Poproś o Wsparcie", closing: "Jesteśmy tu."
        },

        hu: {
            nav_courses: "Tanfolyamok", nav_team: "Tanácsadók", nav_contact: "Kapcsolat", nav_prep: "Felkészülés",
            nav_tagline: "Segítünk megtalálni a helyes irányt", role_title: "ELKÖTELEZETT DIÁKTANÁCSADÓ", btn_contact: "Kapcsolat", btn_back: "Vissza",
            search_title: "Keresés", lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás", btn_find: "Keresés",
            bio_header: "Rólam", hobby_header: "Elkötelezve a Sikeredért",
            bio_p1: "Elkötelezett diáktanácsadó vagyok, korábbi tapasztalattal szociális munkás asszisztensként és gondozóként, ahol különböző hátterű egyéneket támogattam.",
            bio_p2: "Negyedéves hallgató is vagyok a Global Banking School-ban, így első kézből értem az akadémiai nyomást.",
            bio_quote: "\"Célom, hogy bizalmas és támogató környezetet teremtsek.\"",
            offer_title: "Hogyan segíthetek:", list_1: "Akadémiai tanácsadás", list_2: "Kihívások kezelése", list_3: "Alkalmazkodás", list_4: "Források elérése", list_5: "Támogató környezet",
            
            prep_title: "Interjú", prep_sub: "Felkészülés.", star_t: "STAR", star_d: "Viselkedés.", psych_t: "Képességfelmérés", psych_d: "Logika.", case_t: "Eset", case_d: "Forgatókönyv.",
            elig_title: "Jogosultság", elig_desc: "Ellenőrzés.", btn_check_elig: "Válasz",
            lbl_q1: "1. Város?", lbl_q2: "2. Státusz?", lbl_q3: "3. Angol?", link_duolingo_check: "Teszt?", lbl_q4: "4. Diploma?", lbl_q5: "5. Kurzus?", lbl_q6: "6. Tárgy?", lbl_q7: "7. Idő?", lbl_q8: "8. London?", btn_submit_elig: "Küldés",
            test_title: "Angol Teszt", test_desc: "Szükséges.", btn_test: "Teszt",
            
            form_header: "Segítségre van szüksége?", form_sub: "Töltse ki az űrlapot.", 
            lbl_name: "Név", sub_name: "(Teljes)", lbl_email: "Email", sub_email: "(Kapcsolat)", lbl_phone: "Tel", sub_phone: "(Opc)",
            lbl_inst: "Intézmény", ph_inst: "pl. GBS", lbl_course: "Szak", ph_course: "pl. Üzlet", lbl_year: "Év", opt_found: "Alapozó", opt_y1: "1. év", opt_y2: "2. év", opt_y3: "3. év", opt_y4: "4. év",
            lbl_reason: "Téma?", sub_reason: "(Válasszon)", chk_1: "Tanácsadás", chk_2: "Teher", chk_3: "Személyes", chk_4: "Motiváció", chk_5: "Folyamatok", chk_6: "Jövő",
            lbl_open: "Leírás", sub_open: "(Helyzet)", ph_msg: "pl. Kell...", trust_title: "Bizalmas", trust_desc: "Védett.", btn_cta: "Támogatás Kérése", closing: "Van segítség."
        },

        es: {
            nav_courses: "Cursos", nav_team: "Asesores", nav_contact: "Contacto", nav_prep: "Preparación",
            nav_tagline: "Te ayudamos a encontrar el camino", role_title: "ASESORA ESTUDIANTIL DEDICADA", btn_contact: "Contacto", btn_back: "Volver",
            search_title: "Buscar", lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje", btn_find: "Buscar",
            bio_header: "Sobre Mí", hobby_header: "Dedicado a tu Éxito",
            bio_p1: "Soy una Asesora Estudiantil dedicada con experiencia previa como Asistente de Trabajador Social y Cuidadora, apoyando a personas con desafíos personales y académicos.",
            bio_p2: "También soy estudiante de cuarto año en GBS, comprendiendo de primera mano las presiones.",
            bio_quote: "\"Mi objetivo es crear un entorno de apoyo y confidencialidad.\"",
            offer_title: "Cómo ayudo:", list_1: "Orientación académica", list_2: "Desafíos personales", list_3: "Adaptación", list_4: "Recursos", list_5: "Entorno de apoyo",
            
            prep_title: "Entrevista", prep_sub: "Preparación.", star_t: "STAR", star_d: "Comportamiento.", psych_t: "Evaluación de Capacidad", psych_d: "Lógica.", case_t: "Casos", case_d: "Escenarios.",
            elig_title: "Elegibilidad", elig_desc: "Verificar.", btn_check_elig: "Responder",
            lbl_q1: "1. ¿Ciudad?", lbl_q2: "2. ¿Estado?", lbl_q3: "3. ¿Inglés?", link_duolingo_check: "¿Prueba?", lbl_q4: "4. ¿Diploma?", lbl_q5: "5. ¿Curso?", lbl_q6: "6. ¿Campo?", lbl_q7: "7. ¿Horario?", lbl_q8: "8. ¿Londres?", btn_submit_elig: "Enviar",
            test_title: "Inglés", test_desc: "Requerido.", btn_test: "Test",
            
            form_header: "¿Necesitas orientación?", form_sub: "Rellena el formulario.", 
            lbl_name: "Nombre", sub_name: "(Completo)", lbl_email: "Email", sub_email: "(Contacto)", lbl_phone: "Tel", sub_phone: "(Opc)",
            lbl_inst: "Institución", ph_inst: "ej. GBS", lbl_course: "Curso", ph_course: "ej. Negocios", lbl_year: "Año", opt_found: "Base", opt_y1: "Año 1", opt_y2: "Año 2", opt_y3: "Año 3", opt_y4: "Año 4",
            lbl_reason: "¿Tema?", sub_reason: "(Elige)", chk_1: "Académico", chk_2: "Carga", chk_3: "Personal", chk_4: "Motivación", chk_5: "Procesos", chk_6: "Futuro",
            lbl_open: "¿Descripción?", sub_open: "(Situación)", ph_msg: "Ayuda...", trust_title: "Confidencial", trust_desc: "Seguro.", btn_cta: "Solicitar Apoyo", closing: "Hay apoyo."
        },

        it: {
            nav_courses: "Corsi", nav_team: "Team", nav_contact: "Contatti", nav_prep: "Preparazione",
            nav_tagline: "Ti aiutiamo a trovare la strada giusta", role_title: "CONSULENTE DEDICATA", btn_contact: "Contatti", btn_back: "Indietro",
            search_title: "Cerca", lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio", btn_find: "Cerca",
            bio_header: "Su di Me", hobby_header: "Dedicato al Tuo Successo",
            bio_p1: "Sono una Consulente dedicata con esperienza come Assistente Sociale, supportando persone con sfide personali e accademiche.",
            bio_p2: "Sono anche studentessa del 4° anno alla GBS e capisco le pressioni accademiche.",
            bio_quote: "\"Miro a creare un ambiente di supporto e riservato.\"",
            offer_title: "Cosa Offro:", list_1: "Orientamento", list_2: "Sfide personali", list_3: "Adattamento", list_4: "Risorse", list_5: "Supporto riservato",
            
            prep_title: "Colloquio", prep_sub: "Preparazione.", star_t: "STAR", star_d: "Comportamentale.", psych_t: "Valutazione Abilità", psych_d: "Logica.", case_t: "Casi", case_d: "Scenari.",
            elig_title: "Idoneità", elig_desc: "Verifica.", btn_check_elig: "Rispondi",
            lbl_q1: "1. Città?", lbl_q2: "2. Stato?", lbl_q3: "3. Inglese?", link_duolingo_check: "Test?", lbl_q4: "4. Diploma?", lbl_q5: "5. Corso?", lbl_q6: "6. Studio?", lbl_q7: "7. Orario?", lbl_q8: "8. Londra?", btn_submit_elig: "Invia",
            test_title: "Inglese", test_desc: "Richiesto.", btn_test: "Test",
            
            form_header: "Hai bisogno di guida?", form_sub: "Compila il modulo.", 
            lbl_name: "Nome", sub_name: "(Completo)", lbl_email: "Email", sub_email: "(Contatto)", lbl_phone: "Tel", sub_phone: "(Opz)",
            lbl_inst: "Istituto", ph_inst: "es. GBS", lbl_course: "Corso", ph_course: "es. Business", lbl_year: "Anno", opt_found: "Base", opt_y1: "Anno 1", opt_y2: "Anno 2", opt_y3: "Anno 3", opt_y4: "Anno 4",
            lbl_reason: "Motivo?", sub_reason: "(Scegli)", chk_1: "Studio", chk_2: "Carico", chk_3: "Personale", chk_4: "Motivazione", chk_5: "Processi", chk_6: "Futuro",
            lbl_open: "Descrizione", sub_open: "(Situazione)", ph_msg: "Serve...", trust_title: "Riservato", trust_desc: "Sicuro.", btn_cta: "Richiedi Supporto", closing: "Siamo qui."
        },

        pt: {
            nav_courses: "Cursos", nav_team: "Consultores", nav_contact: "Contato", nav_prep: "Preparação",
            nav_tagline: "Ajudamos você a encontrar o caminho", role_title: "CONSULTORA DEDICADA", btn_contact: "Contato", btn_back: "Voltar",
            search_title: "Buscar", lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem", btn_find: "Buscar",
            bio_header: "Sobre Mim", hobby_header: "Dedicado ao Seu Sucesso",
            bio_p1: "Sou uma Consultora dedicada com experiência como Assistente Social, apoiando indivíduos com desafios pessoais e acadêmicos.",
            bio_p2: "Também sou estudante do 4º ano na GBS, compreendendo as pressões acadêmicas.",
            bio_quote: "\"O meu objetivo é criar um ambiente de apoio e confidencial.\"",
            offer_title: "O que Ofereço:", list_1: "Orientação", list_2: "Desafios", list_3: "Adaptação", list_4: "Recursos", list_5: "Apoio",
            
            prep_title: "Entrevista", prep_sub: "Preparação.", star_t: "STAR", star_d: "Comportamental.", psych_t: "Avaliação de Capacidade", psych_d: "Lógica.", case_t: "Casos", case_d: "Cenários.",
            elig_title: "Elegibilidade", elig_desc: "Verifique.", btn_check_elig: "Responder",
            lbl_q1: "1. Cidade?", lbl_q2: "2. Estado?", lbl_q3: "3. Inglês?", link_duolingo_check: "Teste?", lbl_q4: "4. Diploma?", lbl_q5: "5. Curso?", lbl_q6: "6. Estudo?", lbl_q7: "7. Horário?", lbl_q8: "8. Londres?", btn_submit_elig: "Enviar",
            test_title: "Inglês", test_desc: "Necessário.", btn_test: "Teste",
            
            form_header: "Precisa de orientação?", form_sub: "Preencha o formulário.", 
            lbl_name: "Nome", sub_name: "(Completo)", lbl_email: "Email", sub_email: "(Contato)", lbl_phone: "Tel", sub_phone: "(Opc)",
            lbl_inst: "Instituição", ph_inst: "ex. GBS", lbl_course: "Curso", ph_course: "ex. Negócios", lbl_year: "Ano", opt_found: "Base", opt_y1: "Ano 1", opt_y2: "Ano 2", opt_y3: "Ano 3", opt_y4: "Ano 4",
            lbl_reason: "Motivo?", sub_reason: "(Escolha)", chk_1: "Acadêmico", chk_2: "Carga", chk_3: "Pessoal", chk_4: "Motivação", chk_5: "Processos", chk_6: "Futuro",
            lbl_open: "Descrição", sub_open: "(Situação)", ph_msg: "Preciso...", trust_title: "Confidencial", trust_desc: "Seguro.", btn_cta: "Solicitar Apoio", closing: "Estamos aqui."
        },

        el: {
            nav_courses: "Μαθήματα", nav_team: "Ομάδα", nav_contact: "Επαφή", nav_prep: "Προετοιμασία",
            nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση", role_title: "ΑΦΟΣΙΩΜΕΝΗ ΣΥΜΒΟΥΛΟΣ", btn_contact: "Επικοινωνία", btn_back: "Πίσω",
            search_title: "Αναζήτηση", lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι", btn_find: "Εύρεση",
            bio_header: "Σχετικά", hobby_header: "Επιτυχία",
            bio_p1: "Είμαι αφοσιωμένη Σύμβουλος με εμπειρία ως Κοινωνικός Λειτουργός, υποστηρίζοντας άτομα με ακαδημαϊκές προκλήσεις.",
            bio_p2: "Είμαι επίσης φοιτήτρια 4ου έτους στο GBS, κατανοώντας τις πιέσεις.",
            bio_quote: "\"Στόχος μου είναι ένα υποστηρικτικό και εμπιστευτικό περιβάλλον.\"",
            offer_title: "Τι Προσφέρω:", list_1: "Καθοδήγηση", list_2: "Προκλήσεις", list_3: "Προσαρμογή", list_4: "Πόροι", list_5: "Υποστήριξη",
            
            prep_title: "Συνέντευξη", prep_sub: "Προετοιμασία.", star_t: "STAR", star_d: "Συμπεριφορά.", psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική.", case_t: "Μελέτες", case_d: "Σενάρια.",
            elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Απάντηση",
            lbl_q1: "1. Πόλη;", lbl_q2: "2. Καθεστώς;", lbl_q3: "3. Αγγλικά;", link_duolingo_check: "Τεστ;", lbl_q4: "4. Δίπλωμα;", lbl_q5: "5. Μάθημα;", lbl_q6: "6. Σπουδές;", lbl_q7: "7. Πρόγραμμα;", lbl_q8: "8. Λονδίνο;", btn_submit_elig: "Αποστολή",
            test_title: "Αγγλικά", test_desc: "Απαιτείται.", btn_test: "Τεστ",
            
            form_header: "Χρειάζεστε καθοδήγηση;", form_sub: "Συμπληρώστε.", 
            lbl_name: "Όνομα", sub_name: "(Πλήρες)", lbl_email: "Email", sub_email: "(Επαφή)", lbl_phone: "Τηλ", sub_phone: "(Προαιρ)",
            lbl_inst: "Ίδρυμα", ph_inst: "π.χ. GBS", lbl_course: "Μάθημα", ph_course: "π.χ. Διοίκηση", lbl_year: "Έτος", opt_found: "Βάση", opt_y1: "Έτος 1", opt_y2: "Έτος 2", opt_y3: "Έτος 3", opt_y4: "Έτος 4",
            lbl_reason: "Λόγος;", sub_reason: "(Επιλέξτε)", chk_1: "Σπουδές", chk_2: "Φόρτος", chk_3: "Προσωπικά", chk_4: "Κίνητρο", chk_5: "Διαδικασίες", chk_6: "Μέλλον",
            lbl_open: "Περιγραφή", sub_open: "(Κατάσταση)", ph_msg: "Χρειάζομαι...", trust_title: "Εμπιστευτικό", trust_desc: "Ασφαλές.", btn_cta: "Ζητήστε Υποστήριξη", closing: "Είμαστε εδώ."
        },

        bg: {
            nav_courses: "Курсове", nav_team: "Екип", nav_contact: "Контакт", nav_prep: "Подготовка",
            nav_tagline: "Ние ви помагаме да намерите правилната посока", role_title: "ПОСВЕТЕН СЪВЕТНИК", btn_contact: "Контакт", btn_back: "Назад",
            search_title: "Търсене", lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Пътуване", btn_find: "Търси",
            bio_header: "За мен", hobby_header: "Успех",
            bio_p1: "Аз съм посветен Съветник с опит като Социален Асистент, подкрепящ хора с лични и академични предизвикателства.",
            bio_p2: "Също така съм студентка в 4-ти курс в GBS, разбирайки натиска.",
            bio_quote: "\"Целта ми е подкрепяща и конфиденциална среда.\"",
            offer_title: "Помощ:", list_1: "Насоки", list_2: "Предизвикателства", list_3: "Адаптиране", list_4: "Ресурси", list_5: "Подкрепа",
            
            prep_title: "Интервю", prep_sub: "Подготовка.", star_t: "STAR", star_d: "Поведение.", psych_t: "Оценка на Способности", psych_d: "Логика.", case_t: "Казуси", case_d: "Сценарии.",
            elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Отговори",
            lbl_q1: "1. Град?", lbl_q2: "2. Статус?", lbl_q3: "3. Английски?", link_duolingo_check: "Тест?", lbl_q4: "4. Диплома?", lbl_q5: "5. Курс?", lbl_q6: "6. Учене?", lbl_q7: "7. График?", lbl_q8: "8. Лондон?", btn_submit_elig: "Изпрати",
            test_title: "Английски", test_desc: "Изисква се.", btn_test: "Тест",
            
            form_header: "Нужда от насоки?", form_sub: "Попълнете.", 
            lbl_name: "Име", sub_name: "(Пълно)", lbl_email: "Имейл", sub_email: "(Контакт)", lbl_phone: "Телефон", sub_phone: "(Опция)",
            lbl_inst: "Институция", ph_inst: "напр. GBS", lbl_course: "Курс", ph_course: "напр. Бизнес", lbl_year: "Година", opt_found: "База", opt_y1: "Година 1", opt_y2: "Година 2", opt_y3: "Година 3", opt_y4: "Година 4",
            lbl_reason: "Причина?", sub_reason: "(Изберете)", chk_1: "Учене", chk_2: "Натоварване", chk_3: "Лични", chk_4: "Мотивация", chk_5: "Процеси", chk_6: "Бъдеще",
            lbl_open: "Описание", sub_open: "(Ситуация)", ph_msg: "Нуждая се...", trust_title: "Поверително", trust_desc: "Сигурно.", btn_cta: "Поискайте Подкрепа", closing: "Тук сме."
        }
    };
    
    function changeLanguage(lang) {
        const t = translations[lang] || translations['en'];
        
        document.querySelectorAll('[data-key]').forEach(el => {
            const k = el.getAttribute('data-key');
            if(t[k]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                else el.innerText = t[k];
            }
        });

        document.querySelectorAll('[data-placeholder]').forEach(el => {
            const k = el.getAttribute('data-placeholder');
            if(t[k]) el.placeholder = t[k];
        });
    }

    // Initialize Feather Icons
    if (typeof feather !== 'undefined') feather.replace();

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('carmen-contact-form');
        const formWrapper = document.getElementById('contact-form-wrapper');
        const successMessage = document.getElementById('success-message');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                // Loading State
                submitBtn.disabled = true;
                btnText.textContent = "Sending...";
                btnSpinner.classList.remove('hidden');

                const formData = new FormData(form);
                const originalMsg = formData.get("message");
                formData.set("message", originalMsg + "\n\n[Ref ID: " + Date.now() + "]");

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
            btnText.textContent = "Request Support";
            btnSpinner.classList.add('hidden');
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
        
        const coursesDB = <?php echo $coursesJson; ?>;
        
        window.handleSearch = function(e) {
            e.preventDefault();
            
            const cityInput = document.getElementById('user-postcode').value.toLowerCase().trim();
            const levelInput = document.getElementById('user-level').value;
            const subjectInput = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            
            if(!cityInput) return alert("Please enter a City.");
            
            div.innerHTML = '';
            spinner.classList.remove('hidden');
            
            setTimeout(() => {
                const results = coursesDB.filter(c => {
                    const courseCity = (c.city || "").toLowerCase();
                    const courseAddress = (c.address || "").toLowerCase();
                    const matchCity = courseCity.includes(cityInput) || courseAddress.includes(cityInput);

                    const dbLevel = (c.level || "").toLowerCase();
                    const selLevel = levelInput.toLowerCase();
                    const matchLevel = (levelInput === 'All') || dbLevel.includes(selLevel);

                    const matchSubject = (subjectInput === 'All') || (c.subject === subjectInput);

                    return matchCity && matchLevel && matchSubject;
                });
                
                spinner.classList.add('hidden');

                if(results.length > 0) {
                    results.slice(0, 10).forEach(c => { 
                        div.innerHTML += `
                        <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">Accredited</span>
                                         <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                                    </div>
                                    <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${c.title || c.courses[0] || "Course Title"}</h4>
                                    
                                    <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                                        <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || cityInput}</span>
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
                    });
                    if (typeof feather !== 'undefined') feather.replace();
                } else {
                    div.innerHTML = `
                    <div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">
                        <p class="font-bold">No courses found in "${document.getElementById('user-postcode').value}".</p>
                        <p class="text-sm mt-1">Try searching for a larger nearby city.</p>
                    </div>`;
                }
            }, 600);
        };
    function renderPage(page) {
        const div = document.getElementById('results-area');
        const pagControls = document.getElementById('pagination-controls');
        const indicator = document.getElementById('page-indicator');
        
        div.innerHTML = '';
        
        const start = (page - 1) * resultsPerPage;
        const end = start + resultsPerPage;
        const pageItems = allSortedResults.slice(start, end);

        pageItems.forEach(c => {
             const courseTitle = c.title || "Course";
             const institution = c.institution || "Unknown Institution";
             const level = c.level || "Not specified";
             const schedule = c.study_schedule || "Not specified";
             const city = c.city || "Not specified";

             div.innerHTML += `
                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <h3 class="font-bold text-[#1e3a8a] text-lg mb-3">${courseTitle}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-700">
                        <p><strong class="text-gray-900">Institution:</strong> ${institution}</p>
                        <p><strong class="text-gray-900">City:</strong> ${city}</p>
                        <p><strong class="text-gray-900">Level:</strong> ${level}</p>
                        <p><strong class="text-gray-900">Schedule:</strong> ${schedule}</p>
                    </div>
                </div>
             `;
        });

        // Pagination layout (Forced to show!)
        const totalPages = Math.ceil(allSortedResults.length / resultsPerPage);
        if (totalPages > 0) {
            pagControls.classList.remove('hidden');
            pagControls.style.display = 'flex'; // Extra safety net to force it visible
            indicator.innerText = `Page ${page} of ${totalPages}`;
        } else {
            pagControls.classList.add('hidden');
            pagControls.style.display = 'none'; // Ensure it hides if 0 results
        }
    }
    });
</script>
</body>
</html>
