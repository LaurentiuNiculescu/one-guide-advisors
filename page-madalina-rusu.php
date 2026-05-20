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
    <title>Madalina Rusu | Student Advisor</title>
    
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
        
        body { font-family: 'Lato', sans-serif; color: var(--text-main); overflow-x: hidden; position: relative; background-color: #f8fafc; }
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }
        
        #bg-fixed { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png'); background-position: center center; background-repeat: no-repeat; background-size: cover; }
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); }
        
        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .content-card { background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        
        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
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
                    <img src="<?php echo get_template_directory_uri(); ?>/images/MadalinaRusu.jpg" alt="Madalina Rusu" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Madalina Rusu</h1>
                    <p class="text-[#ff7f7f] font-bold tracking-widest uppercase mb-6" data-key="role_title">Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6">
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 0755 513 0205
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> Madalina.rusu@ask33.co.uk
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-blue shadow-lg transition" data-key="nav_contact">Get in Touch</a>
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
                    
                    <div id="loading-spinner" class="hidden mt-6 text-[#1e3a8a] font-bold animate-pulse text-center">
                        <i data-feather="loader" class="animate-spin mr-2"></i> Searching...
                    </div>
                    
                    <div id="results-area" class="mt-8 space-y-4 text-left"></div>
                </div>
            </div>
        </section>

        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">Your Academic Partner</h2>
                    <p class="text-slate-500 mt-2" data-key="hobby_header">Dedicated to Your Success</p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I am Madalina Rusu, a dedicated Student Advisor at Ask33. My passion is helping students navigate the complex world of university admissions with ease and confidence. I believe that every student deserves a personalized plan to achieve their educational goals.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"Education opens doors. Let me help you find the right key to your future."</p>
                        </div>
                        
                        <p data-key="bio_p2">I understand the challenges of higher education and am here to provide clear, actionable advice at every step of your journey.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">Why Work With Me?</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_1">Personalized guidance</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_2">Expert knowledge of Student Finance</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_3">Support from application to enrollment</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_4">Clear communication</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_5">Dedicated to your success</span></li>
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
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Ready to start? Fill in the details below.</p>
                    
                    <form id="madalina-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="hidden" name="subject" value="New Contact for Madalina Rusu">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="Message" required></textarea>
                        
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

    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="document.getElementById('eligibility-modal').style.display='none'" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]" data-key="elig_title">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="Eligibility Check - Madalina Rusu">
                
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

    function changeLanguage(lang) {
        const translations = {
            en: {
                nav_courses: "Courses", nav_eligibility: "Eligibility", nav_contact: "Contact", role_title: "Student Advisor",
                btn_back: "Back to Team",
                search_title: "Search Accredited Courses", btn_find: "Find",
                bio_header: "Your Academic Partner", hobby_header: "Dedicated to Your Success",
                bio_p1: "I am Madalina Rusu, a dedicated Student Advisor at Ask33. My passion is helping students navigate the complex world of university admissions with ease and confidence.",
                bio_quote: "\"Education opens doors. Let me help you find the right key to your future.\"",
                bio_p2: "I understand the challenges of higher education and am here to provide clear, actionable advice at every step of your journey.",
                offer_title: "Why Work With Me?", 
                list_1: "Personalized guidance", list_2: "Expert knowledge of Student Finance", list_3: "Support from application to enrollment", list_4: "Clear communication", list_5: "Dedicated to your success",
                prep_title: "Interview Preparation", prep_sub: "Master the skills needed.",
                star_t: "STAR Method", star_d: "Master behavioral questions.",
                psych_t: "Ability Assessment", psych_d: "Logic & reasoning.",
                case_t: "Case Studies", case_d: "Real-world scenarios.",
                elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions.", btn_check_elig: "Answer Questions",
                test_title: "Validate Your English", test_desc: "Take the official test.", btn_test: "Take Test",
                form_header: "Contact Me", form_sub: "Ready to start?", 
                lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "Message", btn_send: "Send Message",
                lbl_q1: "1. City", lbl_q2: "2. Residency", lbl_q3: "3. English", link_duolingo_check: "Not sure? Take test",
                lbl_q4: "4. Diploma", lbl_q5: "5. Course Type", lbl_q6: "6. Field", lbl_q7: "7. Schedule", lbl_q8: "8. London?", btn_submit_elig: "Submit Answers",
                lbl_postcode: "City", lbl_level: "Level", lbl_subject: "Subject"
            },
            ro: {
                nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", nav_contact: "Contact", role_title: "Consilier Student",
                btn_back: "Înapoi la Echipă",
                search_title: "Caută Cursuri", btn_find: "Caută",
                bio_header: "Partenerul Tău Academic", hobby_header: "Dedicat Succesului Tău",
                bio_p1: "Sunt Mădălina Rusu, un Consilier Student dedicat. Pasiunea mea este să ajut studenții să navigheze lumea complexă a admiterilor universitare cu ușurință.",
                bio_quote: "\"Educația deschide uși. Lasă-mă să te ajut să găsești cheia potrivită.\"",
                bio_p2: "Înțeleg provocările învățământului superior și sunt aici pentru a oferi sfaturi clare și practice.",
                offer_title: "De ce să lucrezi cu mine?",
                list_1: "Ghidare personalizată", list_2: "Expertiză Student Finance", list_3: "Suport complet", list_4: "Comunicare clară", list_5: "Dedicare pentru succes",
                prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile.",
                star_t: "Metoda STAR", star_d: "Întrebări comportamentale.",
                elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la întrebări.", btn_check_elig: "Răspunde",
                test_title: "Validează Engleza", test_desc: "Fă testul online.", btn_test: "Fă Testul",
                form_header: "Contactează-mă", form_sub: "Gata de start?", 
                lbl_name: "Nume", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Mesaj", btn_send: "Trimite",
                lbl_q1: "1. Oraș", lbl_q2: "2. Rezidență", lbl_q3: "3. Engleză", link_duolingo_check: "Nu ești sigur? Fă testul",
                lbl_q4: "4. Diplomă", lbl_q5: "5. Tip Curs", lbl_q6: "6. Domeniu", lbl_q7: "7. Program", lbl_q8: "8. Londra?", btn_submit_elig: "Trimite",
                lbl_postcode: "Oraș", lbl_level: "Nivel", lbl_subject: "Domeniu"
            },
            pl: {
                nav_courses: "Kursy", nav_eligibility: "Kwalifikowalność", nav_contact: "Kontakt", role_title: "Doradca Studenta",
                btn_back: "Powrót",
                search_title: "Szukaj Kursów", btn_find: "Szukaj",
                bio_header: "Twój Partner Akademicki", hobby_header: "Dedykowany Twojemu Sukcesowi",
                bio_p1: "Jestem Madalina Rusu, oddanym Doradcą Studenta. Moją pasją jest pomaganie studentom w poruszaniu się po świecie rekrutacji.",
                bio_quote: "\"Edukacja otwiera drzwi. Pozwól mi znaleźć właściwy klucz.\"",
                bio_p2: "Rozumiem wyzwania szkolnictwa wyższego i jestem tutaj, aby zapewnić jasne porady.",
                offer_title: "Dlaczego ja?",
                list_1: "Spersonalizowane porady", list_2: "Ekspert finansowy", list_3: "Wsparcie w rekrutacji", list_4: "Jasna komunikacja", list_5: "Długoterminowy sukces",
                prep_title: "Przygotowanie", prep_sub: "Opanuj umiejętności.",
                elig_title: "Sprawdź Uprawnienia", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Sprawdź",
                test_title: "Potwierdź Angielski", test_desc: "Zrób test online.", btn_test: "Zrób Test",
                form_header: "Kontakt", form_sub: "Gotowy?", 
                lbl_name: "Imię", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Wiadomość", btn_send: "Wyślij",
                lbl_q1: "1. Miasto", lbl_q2: "2. Status", lbl_q3: "3. Angielski", link_duolingo_check: "Sprawdź poziom",
                lbl_q4: "4. Dyplom", lbl_q5: "5. Typ", lbl_q6: "6. Kierunek", lbl_q7: "7. Harmonogram", lbl_q8: "8. Londyn?", btn_submit_elig: "Wyślij",
                lbl_postcode: "Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek"
            },
            hu: {
                nav_courses: "Tanfolyamok", nav_eligibility: "Jogosultság", nav_contact: "Kapcsolat", role_title: "Diáktanácsadó",
                btn_back: "Vissza",
                search_title: "Keresés", btn_find: "Keresés",
                bio_header: "Az Ön Akadémiai Partnere", hobby_header: "Elkötelezve a Sikeredért",
                bio_p1: "Madalina Rusu vagyok, diáktanácsadó. Szenvedélyem, hogy segítsem a diákokat az egyetemi felvételi világában.",
                bio_quote: "\"Az oktatás ajtókat nyit meg. Segítek megtalálni a kulcsot.\"",
                bio_p2: "Megértem a kihívásokat és gyakorlatias tanácsokat adok.",
                offer_title: "Miért én?",
                list_1: "Személyre szabott útmutatás", list_2: "Pénzügyi szakértelem", list_3: "Felvételi támogatás", list_4: "Világos kommunikáció", list_5: "Sikerorientált",
                prep_title: "Interjú", prep_sub: "Felkészülés.",
                elig_title: "Jogosultság", elig_desc: "Ellenőrzés.", btn_check_elig: "Válasz",
                test_title: "Angol Teszt", test_desc: "Online teszt.", btn_test: "Teszt",
                form_header: "Kapcsolat", form_sub: "Írj nekem!", 
                lbl_name: "Név", lbl_phone: "Tel", lbl_email: "Email", lbl_msg: "Üzenet", btn_send: "Küldés",
                lbl_q1: "1. Város", lbl_q2: "2. Státusz", lbl_q3: "3. Angol", link_duolingo_check: "Teszteld",
                lbl_q4: "4. Diploma", lbl_q5: "5. Típus", lbl_q6: "6. Terület", lbl_q7: "7. Órarend", lbl_q8: "8. London?", btn_submit_elig: "Küldés",
                lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy"
            },
            es: {
                nav_courses: "Cursos", nav_eligibility: "Elegibilidad", nav_contact: "Contacto", role_title: "Asesora Estudiantil",
                btn_back: "Volver",
                search_title: "Buscar", btn_find: "Buscar",
                bio_header: "Tu Socio Académico", hobby_header: "Dedicado a tu Éxito",
                bio_p1: "Soy Madalina Rusu, Asesora Estudiantil. Mi pasión es ayudar a los estudiantes en las admisiones universitarias.",
                bio_quote: "\"La educación abre puertas. Encuentra la llave correcta.\"",
                bio_p2: "Entiendo los desafíos y brindo consejos claros.",
                offer_title: "¿Por qué yo?",
                list_1: "Orientación personalizada", list_2: "Experta en finanzas", list_3: "Apoyo total", list_4: "Comunicación clara", list_5: "Éxito a largo plazo",
                prep_title: "Entrevista", prep_sub: "Preparación.",
                elig_title: "Elegibilidad", elig_desc: "Verificar.", btn_check_elig: "Responder",
                test_title: "Inglés", test_desc: "Requerido.", btn_test: "Test", form_header: "Contacto", form_sub: "Rellena.", 
                lbl_name: "Nombre", lbl_phone: "Tel", lbl_email: "Email", lbl_msg: "Mensaje", btn_send: "Enviar",
                lbl_q1: "1. Ciudad", lbl_q2: "2. Residencia", lbl_q3: "3. Inglés", link_duolingo_check: "Test",
                lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Horario", lbl_q8: "8. ¿Londres?", btn_submit_elig: "Enviar",
                lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema"
            },
            it: {
                nav_courses: "Corsi", nav_eligibility: "Idoneità", nav_contact: "Contatti", role_title: "Consulente Studente",
                btn_back: "Indietro",
                search_title: "Cerca", btn_find: "Cerca",
                bio_header: "Il Tuo Partner Accademico", hobby_header: "Dedicato al Tuo Successo",
                bio_p1: "Sono Madalina Rusu, Consulente Studentesco. Aiuto gli studenti nelle ammissioni universitarie.",
                bio_quote: "\"L'istruzione apre le porte. Trova la chiave giusta.\"",
                bio_p2: "Capisco le sfide e offro consigli chiari.",
                offer_title: "Perché io?",
                list_1: "Guida personalizzata", list_2: "Esperta finanziamenti", list_3: "Supporto completo", list_4: "Comunicazione chiara", list_5: "Successo garantito",
                prep_title: "Colloquio", prep_sub: "Preparazione.",
                elig_title: "Idoneità", elig_desc: "Verifica.", btn_check_elig: "Rispondi",
                test_title: "Inglese", test_desc: "Online.", btn_test: "Test",
                form_header: "Contatti", form_sub: "Scrivimi.", 
                lbl_name: "Nome", lbl_phone: "Tel", lbl_email: "Email", lbl_msg: "Messaggio", btn_send: "Invia",
                lbl_q1: "1. Città", lbl_q2: "2. Residenza", lbl_q3: "3. Inglese", link_duolingo_check: "Test",
                lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Orario", lbl_q8: "8. Londra?", btn_submit_elig: "Invia",
                lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia"
            },
            pt: {
                nav_courses: "Cursos", nav_eligibility: "Elegibilidade", nav_contact: "Contato", role_title: "Consultora Estudantil",
                btn_back: "Voltar",
                search_title: "Buscar", btn_find: "Buscar",
                bio_header: "Sua Parceira Acadêmica", hobby_header: "Dedicado ao Seu Sucesso",
                bio_p1: "Sou Madalina Rusu, Consultora Estudantil. Ajudo alunos nas admissões universitárias.",
                bio_quote: "\"A educação abre portas. Encontre a chave certa.\"",
                bio_p2: "Entendo os desafios e dou conselhos claros.",
                offer_title: "Por que eu?",
                list_1: "Orientação personalizada", list_2: "Especialista em Finanças", list_3: "Apoio total", list_4: "Comunicação clara", list_5: "Sucesso a longo prazo",
                prep_title: "Entrevista", prep_sub: "Preparação.",
                elig_title: "Elegibilidade", elig_desc: "Verifique.", btn_check_elig: "Responder",
                test_title: "Inglês", test_desc: "Online.", btn_test: "Teste",
                form_header: "Contato", form_sub: "Pronto?", 
                lbl_name: "Nome", lbl_phone: "Tel", lbl_email: "Email", lbl_msg: "Mensagem", btn_send: "Enviar",
                lbl_q1: "1. Cidade", lbl_q2: "2. Residência", lbl_q3: "3. Inglês", link_duolingo_check: "Teste",
                lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Área", lbl_q7: "7. Horário", lbl_q8: "8. Londres?", btn_submit_elig: "Enviar",
                lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto"
            },
            el: {
                nav_courses: "Μαθήματα", nav_eligibility: "Επιλεξιμότητα", nav_contact: "Επαφή", role_title: "Σύμβουλος Φοιτητών",
                btn_back: "Πίσω",
                search_title: "Αναζήτηση", btn_find: "Εύρεση",
                bio_header: "Ο Ακαδημαϊκός Συνεργάτης", hobby_header: "Αφιερωμένος στην Επιτυχία",
                bio_p1: "Είμαι η Madalina Rusu, Σύμβουλος Φοιτητών. Βοηθώ στις εισαγωγές πανεπιστημίων.",
                bio_quote: "\"Η εκπαίδευση ανοίγει πόρτες. Βρείτε το κλειδί.\"",
                bio_p2: "Κατανοώ τις προκλήσεις και παρέχω συμβουλές.",
                offer_title: "Γιατί εγώ;",
                list_1: "Εξατομικευμένη καθοδήγηση", list_2: "Γνώση Οικονομικών", list_3: "Υποστήριξη", list_4: "Σαφής επικοινωνία", list_5: "Επιτυχία",
                prep_title: "Συνέντευξη", prep_sub: "Προετοιμασία.",
                elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Απάντηση",
                test_title: "Αγγλικά", test_desc: "Online.", btn_test: "Τεστ",
                form_header: "Επαφή", form_sub: "Στείλτε μήνυμα.", 
                lbl_name: "Όνομα", lbl_phone: "Τηλ", lbl_email: "Email", lbl_msg: "Μήνυμα", btn_send: "Αποστολή",
                lbl_q1: "1. Πόλη", lbl_q2: "2. Διαμονή", lbl_q3: "3. Αγγλικά", link_duolingo_check: "Τεστ",
                lbl_q4: "4. Δίπλωμα", lbl_q5: "5. Τύπος", lbl_q6: "6. Πεδίο", lbl_q7: "7. Πρόγραμμα", lbl_q8: "8. Λονδίνο;", btn_submit_elig: "Υποβολή",
                lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα"
            },
            bg: {
                nav_courses: "Курсове", nav_eligibility: "Допустимост", nav_contact: "Контакт", role_title: "Студентски Съветник",
                btn_back: "Назад",
                search_title: "Търсене", btn_find: "Търси",
                bio_header: "Академичен Партньор", hobby_header: "Посветен на Успеха",
                bio_p1: "Аз съм Мадалина Русу, Съветник. Помагам за университетски прием.",
                bio_quote: "\"Образованието отваря врати. Намерете ключа.\"",
                bio_p2: "Разбирам предизвикателствата и давам съвети.",
                offer_title: "Защо аз?",
                list_1: "Персонализирани насоки", list_2: "Финанси", list_3: "Подкрепа", list_4: "Комуникация", list_5: "Успех",
                prep_title: "Интервю", prep_sub: "Подготовка.",
                elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Отговори",
                test_title: "Английски", test_desc: "Онлайн.", btn_test: "Тест",
                form_header: "Контакт", form_sub: "Пишете ми.", 
                lbl_name: "Име", lbl_phone: "Тел", lbl_email: "Имейл", lbl_msg: "Съобщение", btn_send: "Изпрати",
                lbl_q1: "1. Град", lbl_q2: "2. Статут", lbl_q3: "3. Английски", link_duolingo_check: "Тест",
                lbl_q4: "4. Диплома", lbl_q5: "5. Тип", lbl_q6: "6. Сфера", lbl_q7: "7. График", lbl_q8: "8. Лондон?", btn_submit_elig: "Изпрати",
                lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Тема"
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

        const form = document.getElementById('madalina-contact-form');
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
