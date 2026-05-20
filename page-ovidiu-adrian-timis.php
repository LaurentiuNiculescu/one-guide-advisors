<?php
/*
*/


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

$coursesJson = json_encode($allCourses);

$web3FormsKey = "{your api here}";
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovidiu Adrian Timis | Student Advisor</title>
    
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
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(3px); }
        
        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* CARDS & INPUTS */
        .content-card { background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; transition: all 0.2s; width: 100%; }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; background: #ffffff; }
        
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
                <a href="#prep" class="hover:text-[#1e3a8a] transition" data-key="nav_prep">Prep</a>
                
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
                <a href="#prep" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_prep">Prep</a>
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
                    <img src="<?php echo get_template_directory_uri(); ?>/images/OvidiuAdrianTimis.jpg" alt="Ovidiu Adrian Timis" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Ovidiu Adrian Timis</h1>
                    <p class="font-bold tracking-widest uppercase mb-6 text-[#ff7f7f]" data-key="role_title">Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6">
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 0773 548 4570
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> adrian.timis@ask33.co.uk
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
            <button id="toggle-search-btn" onclick="document.getElementById('search-container').classList.toggle('hidden')" class="text-sm text-[#1e3a8a] underline hover:text-blue-600">Hide Search</button>
        </div>
        
        <div id="search-container">
            <div class="grid md:grid-cols-4 gap-6 text-left">
                <div class="md:col-span-1">
                    <label class="text-xs font-bold uppercase mb-2 block text-gray-500" data-key="lbl_postcode">City</label>
                    <select id="user-postcode" class="input-standard w-full" required>
                        <option value="" disabled selected>Select a city</option>
                        <option value="Online">Online / Self-Learning</option>
                        <option value="London">London</option>
                        <option value="Manchester">Manchester</option>
                        <option value="Birmingham">Birmingham</option>
                        <option value="Leeds">Leeds</option>
                        <option value="Bradford">Bradford</option>
                        <option value="Sheffield">Sheffield</option>
                        <option value="Nottingham">Nottingham</option>
                        <option value="Newcastle">Newcastle</option>
                        <option value="Leicester">Leicester</option>
                    </select>
                </div>
                
                <div class="md:col-span-1">
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

                <div class="md:col-span-1">
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
                        <option value="Engineering">Engineering</option>
                    </select>
                </div>

                <div class="md:col-span-1 flex items-end">
                    <button type="button" onclick="handleSearch(event)" class="w-full btn-blue py-3 rounded text-white font-bold bg-[#1e3a8a] hover:bg-blue-800 transition" data-key="btn_find">Find</button>
                </div>
            </div>
            
            <div id="loading-spinner" class="hidden mt-6 text-blue-600 font-bold animate-pulse">Searching...</div>
            <div id="results-area" class="mt-8 space-y-4 text-left"></div>
            
            <div id="pagination-controls" class="hidden mt-6 flex justify-center items-center gap-4">
                <button onclick="changePage(-1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition font-medium">Previous</button>
                <span id="page-indicator" class="px-4 py-2 font-bold text-gray-700">Page 1</span>
                <button onclick="changePage(1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition font-medium">Next</button>
            </div>
        </div>
    </div>
</section>

     <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">Bridging the Language Gap</h2>
                    <p class="text-slate-500 mt-2" data-key="bio_intro">Specializing in supporting students across 4 languages.</p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I am Ovidiu Adrian Timis, a Multilingual Student Advisor. I understand that language can sometimes feel like a barrier when applying to UK universities. That's why I offer guidance in multiple languages to ensure you fully understand every step of the process.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"My goal is to make higher education accessible to everyone, no matter where they come from or what language they speak."</p>
                        </div>
                        
                        <p data-key="bio_p2">I provide comprehensive support with university applications, Student Finance, and interview preparation, communicating clearly in the language you are most comfortable with.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">What I Offer:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_1">Fluent support in 4 languages</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_2">Breaking down language barriers</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_3">Assistance with university and SFE applications</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_4">Clear and accurate communication</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_5">100% Free, personalized guidance</span></li>
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
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Contact Me</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Ready to turn your dream into reality? Fill in the details below.</p>
                    
                    <form id="ovidiu-adrian-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="hidden" name="subject" value="New Contact for Ovidiu Timis">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="How can I help?" required></textarea>
                        
                        <button type="submit" id="submit-btn" class="w-full btn-blue flex justify-center items-center gap-2">
                            <span id="btn-text" data-key="btn_send">Send Message</span>
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

   <footer class="bg-gray-100 text-gray-500 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-red-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>

    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="document.getElementById('eligibility-modal').style.display='none'" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]" data-key="elig_title">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="Eligibility Check - Ovidiu Timis">
                
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

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('active')) {
            menu.classList.remove('active');
        } else {
            menu.classList.add('active');
        }
    }

    function changeLanguage(lang) {
       const translations = {
        en: {
            nav_courses: "Courses", nav_team: "Advisors", nav_contact: "Contact", nav_prep: "Prep",
            nav_tagline: "We help you find the right direction",
            role_title: "Multilingual Student Advisor",
            btn_contact: "Get in Touch", btn_back: "Back to Team",
            search_title: "Search Accredited Courses", 
            lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel", btn_find: "Find",
            
            // Bio Section (Tailored for Ovidiu)
            bio_header: "Bridging the Language Gap",
            bio_intro: "Specializing in supporting students across 4 languages.",
            bio_p1: "I am Ovidiu Adrian Timis, a Multilingual Student Advisor. I understand that language can sometimes feel like a barrier when applying to UK universities. That's why I offer guidance in multiple languages to ensure you fully understand every step of the process.",
            bio_quote: "My goal is to make higher education accessible to everyone, no matter where they come from or what language they speak.",
            bio_p2: "I provide comprehensive support with university applications, Student Finance, and interview preparation, communicating clearly in the language you are most comfortable with.",
            
            offer_title: "What I Offer:",
            list_1: "Fluent support in 4 languages", 
            list_2: "Breaking down language barriers", 
            list_3: "Assistance with university and SFE applications", 
            list_4: "Clear and accurate communication", 
            list_5: "100% Free, personalized guidance",
            
            // Prep & Common Sections
            prep_title: "Interview Preparation", prep_sub: "Master your interview skills.",
            star_t: "STAR Method", star_d: "Behavioral answers.", psych_t: "Ability Assessment", psych_d: "Logic & reasoning.", case_t: "Case Studies", case_d: "Real scenarios.",
            
            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance and admission.", btn_check_elig: "Answer Questions",
            lbl_q1: "1. In which city do you live?", lbl_q2: "2. What is your residency status?", lbl_q3: "3. What is your level of English?", link_duolingo_check: "Not sure about the level of english take this test",
            lbl_q4: "4. Do you have a diploma (Bac, Lvl 3, A-Levels)?", lbl_q5: "5. What type of course do you want?", lbl_q6: "6. What field do you want to study?",
            lbl_q7: "7. What is your preferred schedule?", lbl_q8: "8. Would you be willing to study in London?", btn_submit_elig: "Submit Answers",
            
            test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required for university admission.", btn_test: "Take Duolingo English Test",
            form_header: "Start Your Journey", form_sub: "Fill in the form below for guidance on your academic journey.",
            lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "How can I help?", btn_send: "Send Request"
        },
        
        ro: {
            nav_courses: "Cursuri", nav_team: "Consilieri", nav_contact: "Contact", nav_prep: "Pregătire",
            nav_tagline: "Te ajutăm să găsești direcția potrivită",
            role_title: "Consilier Student Multilingv", btn_contact: "Contactează", btn_back: "Înapoi la Echipă",
            search_title: "Caută Cursuri Acreditate", lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport", btn_find: "Caută",
            
            bio_header: "Depășirea Barierelor Lingvistice",
            bio_intro: "Specializat în sprijinirea studenților în 4 limbi.",
            bio_p1: "Sunt Ovidiu Adrian Timiș, Consilier Student Multilingv. Înțeleg că limba poate fi uneori un obstacol în aplicarea la universitățile din UK. De aceea, ofer îndrumare în mai multe limbi pentru a mă asigura că înțelegi pe deplin fiecare pas.",
            bio_quote: "Scopul meu este să fac învățământul superior accesibil tuturor, indiferent de unde provin sau ce limbă vorbesc.",
            bio_p2: "Ofer suport complet pentru aplicațiile universitare, Student Finance și pregătirea pentru interviuri, comunicând clar în limba în care te simți cel mai confortabil.",
            
            offer_title: "Ce Ofer:",
            list_1: "Suport fluent în 4 limbi", list_2: "Eliminarea barierelor lingvistice", 
            list_3: "Asistență la înscrieri și SFE", list_4: "Comunicare clară și precisă", list_5: "100% Gratuit, îndrumare personalizată",
            
            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește interviul.",
            star_t: "Metoda STAR", star_d: "Răspunsuri comportamentale.", psych_t: "Evaluare Abilități", psych_d: "Teste logice.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la câteva întrebări pentru a vedea dacă te califici.", btn_check_elig: "Răspunde la Întrebări",
            lbl_q1: "1. În ce oraș locuiești?", lbl_q2: "2. Ce status de rezidență ai?", lbl_q3: "3. Care este nivelul tău de engleză?", link_duolingo_check: "Nu ești sigur de nivelul de engleză? Fă acest test",
            lbl_q4: "4. Deții o diplomă (Bac, Level 3, A-Levels)?", lbl_q5: "5. Pentru ce fel de curs vrei să aplici?", lbl_q6: "6. Ce domeniu îți dorești să studiezi?",
            lbl_q7: "7. Ce program de studiu preferi?", lbl_q8: "8. Ai fi dispus să studiezi în Londra?", btn_submit_elig: "Trimite Răspunsurile",
            test_title: "Validează-ți Competențele de Engleză", test_desc: "Un nivel certificat de engleză este adesea necesar pentru admitere.", btn_test: "Fă Testul Duolingo",
            form_header: "Contactează-mă", form_sub: "Completează formularul pentru îndrumare academică.",
            lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Cum te pot ajuta?", btn_send: "Trimite Cerere"
        },
        
        pl: {
            nav_courses: "Kursy", nav_team: "Doradcy", nav_contact: "Kontakt", nav_prep: "Przygotowanie",
            nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
            role_title: "Wielojęzyczny Doradca Studenta", btn_contact: "Skontaktuj się", btn_back: "Powrót",
            search_title: "Szukaj Kursów", lbl_postcode: "Kod / Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd", btn_find: "Szukaj",
            
            bio_header: "Przełamywanie Barier Językowych",
            bio_intro: "Specjalizuję się we wspieraniu studentów w 4 językach.",
            bio_p1: "Nazywam się Ovidiu Adrian Timis, jestem Wielojęzycznym Doradcą Studenta. Rozumiem, że język może czasem stanowić barierę. Dlatego oferuję wsparcie w wielu językach, abyś w pełni zrozumiał każdy krok.",
            bio_quote: "Moim celem jest uczynienie szkolnictwa wyższego dostępnym dla każdego, bez względu na pochodzenie.",
            bio_p2: "Zapewniam kompleksowe wsparcie przy aplikacjach, Student Finance i rozmowach kwalifikacyjnych, komunikując się w języku, w którym czujesz się najlepiej.",
            
            offer_title: "Co Oferuję:",
            list_1: "Płynne wsparcie w 4 językach", list_2: "Przełamywanie barier językowych", 
            list_3: "Pomoc przy aplikacjach na uczelnie i SFE", list_4: "Jasna i dokładna komunikacja", list_5: "W 100% darmowe, spersonalizowane doradztwo",
            
            prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj swoje umiejętności.",
            star_t: "Metoda STAR", star_d: "Pytania behawioralne.", psych_t: "Ocena Umiejętności", psych_d: "Logika i rozumowanie.", case_t: "Studia Przypadku", case_d: "Scenariusze.",
            elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na kilka pytań, aby sprawdzić, czy się kwalifikujesz.", btn_check_elig: "Odpowiedz na Pytania",
            lbl_q1: "1. W jakim mieście mieszkasz?", lbl_q2: "2. Jaki masz status rezydenta?", lbl_q3: "3. Jaki jest Twój poziom angielskiego?", link_duolingo_check: "Nie jesteś pewien poziomu? Zrób ten test",
            lbl_q4: "4. Czy posiadasz dyplom (Matura, Level 3)?", lbl_q5: "5. Na jaki rodzaj kursu chcesz aplikować?", lbl_q6: "6. Jaki kierunek chcesz studiować?",
            lbl_q7: "7. Preferowany harmonogram?", lbl_q8: "8. Czy chciałbyś studiować w Londynie?", btn_submit_elig: "Wyślij Odpowiedzi",
            test_title: "Potwierdź swój angielski", test_desc: "Certyfikat jest wymagany.", btn_test: "Zrób Test Duolingo",
            form_header: "Kontakt", form_sub: "Wypełnij formularz.", lbl_name: "Imię", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "W czym pomóc?", btn_send: "Wyślij"
        },
        
        hu: {
            nav_courses: "Tanfolyamok", nav_team: "Tanácsadók", nav_contact: "Kapcsolat", nav_prep: "Felkészülés",
            nav_tagline: "Segítünk megtalálni a helyes irányt",
            role_title: "Többnyelvű Diáktanácsadó", btn_contact: "Lépjen kapcsolatba", btn_back: "Vissza",
            search_title: "Tanfolyamok Keresése", lbl_postcode: "Irányítószám / Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás", btn_find: "Keresés",
            
            bio_header: "Nyelvi Akadályok Leküzdése", 
            bio_intro: "A diákok támogatására specializálódott 4 nyelven.",
            bio_p1: "Ovidiu Adrian Timis vagyok, többnyelvű diáktanácsadó. Megértem, hogy a nyelv néha akadályt jelenthet. Ezért több nyelven nyújtok útmutatást, hogy minden lépést pontosan megértsen.",
            bio_quote: "Célom, hogy a felsőoktatást mindenki számára elérhetővé tegyem, függetlenül attól, honnan jön.",
            bio_p2: "Átfogó támogatást nyújtok az egyetemi jelentkezésekhez, a diákhitelhez és az interjúkhoz, azon a nyelven kommunikálva, amelyik a legkényelmesebb az Ön számára.",
            
            offer_title: "Amit Kínálok:",
            list_1: "Folyékony támogatás 4 nyelven", list_2: "Nyelvi akadályok lebontása", list_3: "Segítség az egyetemi és SFE jelentkezésben", 
            list_4: "Világos és pontos kommunikáció", list_5: "100% Ingyenes útmutatás",
            
            prep_title: "Interjú Felkészülés", prep_sub: "Sajátítsa el az interjú készségeket.",
            star_t: "STAR Módszer", star_d: "Viselkedési kérdések.", psych_t: "Képességfelmérés", psych_d: "Logika.", case_t: "Esettanulmányok", case_d: "Forgatókönyvek.",
            elig_title: "Jogosultság Ellenőrzése", elig_desc: "Válaszoljon néhány kérdésre.", btn_check_elig: "Válaszadás",
            lbl_q1: "1. Melyik városban élsz?", lbl_q2: "2. Milyen a tartózkodási státuszod?", lbl_q3: "3. Milyen szintű az angol tudásod?", link_duolingo_check: "Végezze el ezt a tesztet",
            lbl_q4: "4. Van diplomád (Érettségi, Level 3)?", lbl_q5: "5. Milyen típusú kurzust szeretnél?", lbl_q6: "6. Mit szeretnél tanulni?",
            lbl_q7: "7. Preferált időbeosztás?", lbl_q8: "8. Hajlandó lennél Londonban tanulni?", btn_submit_elig: "Válaszok Küldése",
            test_title: "Igazold Angol Tudásod", test_desc: "Tanúsítvány szükséges.", btn_test: "Duolingo Teszt",
            form_header: "Kapcsolat", form_sub: "Töltse ki az űrlapot.", lbl_name: "Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Üzenet", btn_send: "Küldés"
        },

        es: {
            nav_courses: "Cursos", nav_team: "Asesores", nav_contact: "Contacto", nav_prep: "Preparación",
            nav_tagline: "Te ayudamos a encontrar el camino correcto",
            role_title: "Asesor Estudiantil Multilingüe", btn_contact: "Contáctame", btn_back: "Volver",
            search_title: "Buscar Cursos", lbl_postcode: "Código / Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje", btn_find: "Buscar",
            
            bio_header: "Superando las Barreras del Idioma", 
            bio_intro: "Especializado en apoyar a los estudiantes en 4 idiomas.",
            bio_p1: "Soy Ovidiu Adrian Timis, Asesor Estudiantil Multilingüe. Entiendo que el idioma a veces puede ser una barrera. Por eso ofrezco orientación en varios idiomas para asegurar que entiendas cada paso.",
            bio_quote: "Mi objetivo es hacer que la educación superior sea accesible para todos, sin importar de dónde vengan.",
            bio_p2: "Brindo apoyo integral con las solicitudes universitarias, Student Finance y la preparación de entrevistas, comunicándome en el idioma en el que te sientas más cómodo.",
            
            offer_title: "Lo que Ofrezco:",
            list_1: "Soporte fluido en 4 idiomas", list_2: "Superando barreras lingüísticas", list_3: "Asistencia con SFE y universidades", 
            list_4: "Comunicación clara", list_5: "Orientación 100% gratuita",
            
            prep_title: "Preparación Entrevista", prep_sub: "Domina tus habilidades.",
            star_t: "Método STAR", star_d: "Comportamiento.", psych_t: "Evaluación de Capacidad", psych_d: "Lógica.", case_t: "Casos de Estudio", case_d: "Escenarios.",
            elig_title: "Verificar Elegibilidad", elig_desc: "Responde algunas preguntas.", btn_check_elig: "Responder",
            lbl_q1: "1. ¿En qué ciudad vives?", lbl_q2: "2. ¿Cuál es tu estado de residencia?", lbl_q3: "3. ¿Cuál es tu nivel de inglés?", link_duolingo_check: "Haz esta prueba",
            lbl_q4: "4. ¿Tienes un diploma?", lbl_q5: "5. ¿Qué tipo de curso deseas?", lbl_q6: "6. ¿Qué campo deseas estudiar?",
            lbl_q7: "7. ¿Horario preferido?", lbl_q8: "8. ¿Estarías dispuesto a estudiar en Londres?", btn_submit_elig: "Enviar",
            test_title: "Valida tu Inglés", test_desc: "Se requiere certificado.", btn_test: "Test Duolingo",
            form_header: "Contacto", form_sub: "Rellena el formulario.", lbl_name: "Nombre", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Mensaje", btn_send: "Enviar"
        },

        it: {
            nav_courses: "Corsi", nav_team: "Advisor", nav_contact: "Contatti", nav_prep: "Preparazione",
            nav_tagline: "Ti aiutiamo a trovare la strada giusta",
            role_title: "Consulente Studentesco Multilingue", btn_contact: "Contattami", btn_back: "Indietro",
            search_title: "Cerca Corsi", lbl_postcode: "CAP / Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio", btn_find: "Cerca",
            
            bio_header: "Superare le Barriere Linguistiche", 
            bio_intro: "Specializzato nel supporto agli studenti in 4 lingue.",
            bio_p1: "Sono Ovidiu Adrian Timis, Consulente Studentesco Multilingue. Capisco che la lingua possa a volte sembrare una barriera. Ecco perché offro orientamento in più lingue per assicurarmi che tu comprenda ogni passaggio.",
            bio_quote: "Il mio obiettivo è rendere l'istruzione superiore accessibile a tutti, non importa da dove provengano.",
            bio_p2: "Fornisco supporto completo per le domande universitarie, Student Finance e la preparazione ai colloqui, comunicando nella lingua con cui ti senti più a tuo agio.",
            
            offer_title: "Cosa Offro:",
            list_1: "Supporto fluente in 4 lingue", list_2: "Abbattimento barriere linguistiche", list_3: "Assistenza università e SFE", 
            list_4: "Comunicazione chiara", list_5: "Orientamento 100% gratuito",
            
            prep_title: "Preparazione Colloquio", prep_sub: "Migliora le tue abilità.",
            star_t: "Metodo STAR", star_d: "Comportamentale.", psych_t: "Valutazione Abilità", psych_d: "Logica.", case_t: "Casi Studio", case_d: "Scenari.",
            elig_title: "Verifica Idoneità", elig_desc: "Rispondi a poche domande.", btn_check_elig: "Rispondi",
            lbl_q1: "1. In quale città vivi?", lbl_q2: "2. Qual è il tuo stato di residenza?", lbl_q3: "3. Qual è il tuo livello di inglese?", link_duolingo_check: "Fai questo test",
            lbl_q4: "4. Hai un diploma?", lbl_q5: "5. Che tipo di corso desideri?", lbl_q6: "6. Cosa vuoi studiare?",
            lbl_q7: "7. Orario preferito?", lbl_q8: "8. Saresti disposto a studiare a Londra?", btn_submit_elig: "Invia",
            test_title: "Convalida il tuo Inglese", test_desc: "Certificato richiesto.", btn_test: "Test Duolingo",
            form_header: "Contatti", form_sub: "Compila il modulo.", lbl_name: "Nome", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Messaggio", btn_send: "Invia"
        },

        pt: {
            nav_courses: "Cursos", nav_team: "Consultores", nav_contact: "Contato", nav_prep: "Preparação",
            nav_tagline: "Ajudamos você a encontrar o caminho certo",
            role_title: "Consultor Estudantil Multilíngue", btn_contact: "Contacte-me", btn_back: "Voltar",
            search_title: "Buscar Cursos", lbl_postcode: "Código / Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem", btn_find: "Buscar",
            
            bio_header: "Superando as Barreiras do Idioma", 
            bio_intro: "Especializado em apoiar alunos em 4 idiomas.",
            bio_p1: "Sou Ovidiu Adrian Timis, Consultor Estudantil Multilíngue. Entendo que o idioma às vezes pode parecer uma barreira. É por isso que ofereço orientação em vários idiomas.",
            bio_quote: "Meu objetivo é tornar o ensino superior acessível a todos, independentemente de onde venham.",
            bio_p2: "Forneço suporte abrangente com inscrições em universidades, Student Finance e preparação para entrevistas, comunicando-me no idioma com o qual você se sente mais confortável.",
            
            offer_title: "O que Ofereço:",
            list_1: "Suporte fluente em 4 idiomas", list_2: "Quebrando barreiras linguísticas", list_3: "Assistência universidade e SFE", 
            list_4: "Comunicação clara", list_5: "Orientação 100% gratuita",
            
            prep_title: "Preparação Entrevista", prep_sub: "Domine suas habilidades.",
            star_t: "Método STAR", star_d: "Comportamental.", psych_t: "Avaliação Capacidade", psych_d: "Lógica.", case_t: "Estudos de Caso", case_d: "Cenários.",
            elig_title: "Verificar Elegibilidade", elig_desc: "Responda algumas perguntas.", btn_check_elig: "Responder",
            lbl_q1: "1. Em que cidade você mora?", lbl_q2: "2. Qual é o seu status de residência?", lbl_q3: "3. Qual é o seu nível de inglês?", link_duolingo_check: "Faça este teste",
            lbl_q4: "4. Você tem um diploma?", lbl_q5: "5. Que tipo de curso você quer?", lbl_q6: "6. O que quer estudar?",
            lbl_q7: "7. Horário preferido?", lbl_q8: "8. Estaria disposto a estudar em Londres?", btn_submit_elig: "Enviar",
            test_title: "Valide seu Inglês", test_desc: "Certificado necessário.", btn_test: "Teste Duolingo",
            form_header: "Contato", form_sub: "Preencha o formulário.", lbl_name: "Nome", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Mensagem", btn_send: "Enviar"
        },

        el: {
            nav_courses: "Μαθήματα", nav_team: "Σύμβουλοι", nav_contact: "Επαφή", nav_prep: "Προετοιμασία",
            nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
            role_title: "Πολύγλωσσος Σύμβουλος", btn_contact: "Επικοινωνία", btn_back: "Πίσω",
            search_title: "Αναζήτηση Μαθημάτων", lbl_postcode: "ΤΚ / Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι", btn_find: "Εύρεση",
            
            bio_header: "Γεφυρώνοντας το Γλωσσικό Χάσμα", 
            bio_intro: "Ειδίκευση στην υποστήριξη φοιτητών σε 4 γλώσσες.",
            bio_p1: "Είμαι ο Οβίντιου Άντριαν Τίμις, Πολύγλωσσος Σύμβουλος. Καταλαβαίνω ότι η γλώσσα μπορεί να είναι εμπόδιο. Γι' αυτό προσφέρω καθοδήγηση σε πολλές γλώσσες.",
            bio_quote: "Στόχος μου είναι να κάνω την τριτοβάθμια εκπαίδευση προσιτή σε όλους, από όπου κι αν προέρχονται.",
            bio_p2: "Παρέχω ολοκληρωμένη υποστήριξη στις αιτήσεις, το Student Finance και τις συνεντεύξεις, επικοινωνώντας στη γλώσσα που σας βολεύει.",
            
            offer_title: "Τι Προσφέρω:",
            list_1: "Άπταιστη υποστήριξη σε 4 γλώσσες", list_2: "Κατάργηση εμποδίων", list_3: "Βοήθεια με αιτήσεις", 
            list_4: "Σαφής επικοινωνία", list_5: "100% Δωρεάν",
            
            prep_title: "Προετοιμασία Συνέντευξης", prep_sub: "Βελτιώστε τις δεξιότητές σας.",
            star_t: "Μέθοδος STAR", star_d: "Συμπεριφορά.", psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική.", case_t: "Μελέτες Περίπτωσης", case_d: "Σενάρια.",
            elig_title: "Έλεγχος Επιλεξιμότητας", elig_desc: "Απαντήστε σε ερωτήσεις.", btn_check_elig: "Απάντηση",
            test_title: "Αγγλικά", test_desc: "Απαιτείται πιστοποίηση.", btn_test: "Τεστ Duolingo",
            form_header: "Επαφή", form_sub: "Συμπληρώστε τη φόρμα.", lbl_name: "Όνομα", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Μήνυμα", btn_send: "Αποστολή"
        },

        bg: {
            nav_courses: "Курсове", nav_team: "Съветници", nav_contact: "Контакт", nav_prep: "Подготовка",
            nav_tagline: "Помагаме ви да намерите правилната посока",
            role_title: "Многоезичен Съветник", btn_contact: "Контакт", btn_back: "Назад",
            search_title: "Търсене на Курсове", lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Пътуване", btn_find: "Търси",
            
            bio_header: "Преодоляване на Езиковата Бариера", 
            bio_intro: "Специализиран в подкрепата на студенти на 4 езика.",
            bio_p1: "Аз съм Овидиу Адриан Тимиш, многоезичен студентски съветник. Разбирам, че езикът понякога може да бъде бариера. Затова предлагам насоки на няколко езика.",
            bio_quote: "Моята цел е да направя висшето образование достъпно за всеки, независимо откъде идва.",
            bio_p2: "Предоставям цялостна подкрепа за кандидатстване в университети, студентско финансиране и подготовка за интервюта, комуникирайки на езика, който ви е най-удобен.",
            
            offer_title: "Какво Предлагам:",
            list_1: "Свободна подкрепа на 4 езика", list_2: "Преодоляване на бариери", list_3: "Помощ при кандидатстване", 
            list_4: "Ясна комуникация", list_5: "100% безплатно",
            
            prep_title: "Подготовка за Интервю", prep_sub: "Усъвършенствайте уменията си.",
            star_t: "Метод STAR", star_d: "Поведение.", psych_t: "Оценка Способности", psych_d: "Логика.", case_t: "Казуси", case_d: "Сценарии.",
            elig_title: "Проверка на Допустимост", elig_desc: "Отговорете на въпроси.", btn_check_elig: "Отговори",
            test_title: "Английски", test_desc: "Изисква се сертификат.", btn_test: "Тест Duolingo",
            form_header: "Контакт", form_sub: "Попълнете формата.", lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Съобщение", btn_send: "Изпрати"
        }
    };
        const t = translations[lang] || translations['en'];
        document.querySelectorAll('[data-key]').forEach(el => {
            const k = el.getAttribute('data-key');
            if(t[k]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                else el.innerText = t[k];
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') feather.replace();

        const form = document.getElementById('ovidiu-adrian-contact-form');
        const formWrapper = document.getElementById('contact-form-wrapper');
        const successMessage = document.getElementById('success-message');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnSpinner = document.getElementById('btn-spinner');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                // Loading State
                submitBtn.disabled = true;
                btnText.textContent = "Sending...";
                btnIcon.classList.add('hidden');
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
                        // Success Animation
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
            btnText.textContent = "Send Message";
            btnIcon.classList.remove('hidden');
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
    });
</script>
</body>
</html>
